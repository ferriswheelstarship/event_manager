<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Gate;
use Carbon\Carbon;
use App\Event;
use App\User;
use App\Profile;
use App\Careerup_curriculum;
use App\Event_date;
use App\Entry;
use Mail;
use App\Mail\TicketSendMail;
use App\Mail\UpgradingNoticeMail;
use App\Http\Traits\Csv;

class EntryController extends Controller
{
    public function index()
    {
        $user_self = User::find(Auth::id());

        if(Gate::allows('system-only')) { //特権ユーザのみ
            $events = Event::withTrashed()->orderBy('id', 'desc')->get();
        } elseif(Gate::allows('area-only')) { //支部ユーザのみ
            $events = Event::withTrashed()->where('user_id',$user_self)->orderBy('id', 'desc')->get();
        } else {
            $events = Event::where('view_start_date','<=',now())
                                ->where('view_end_date','>',now())
                                ->orderBy('id', 'desc')->get();
        }

        foreach($events as $event) {

            // 研修申込期間
            $dt = Carbon::now();
            $entry_start_date = new Carbon($event['entry_start_date']);
            $entry_end_date = new Carbon($event['entry_end_date']);

            // 申込数
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where(function($q){
                                $q->where('entry_status','Y')
                                    ->orWhere('entry_status','YC');
                            })->groupBy('user_id')->get()->count();

            // ステータス
            if($event->deleted_at) {
                $status = "削除済";
            } else {
                if($entrys_cnt >= $event['capacity']){
                    $status = "キャンセル待申込";
                } else {
                    if($entry_start_date > $dt){
                        $status = "申込開始前";
                    } elseif($entry_end_date < $dt) {
                        $status = "申込受付終了";
                    } else {
                        $status = "申込受付中";
                    } 
                }
            }
                            
            $data[] = [
                'id' => $event->id,
                'title' => $event->title,
                'status' => $status,
                'event_dates' => $event->event_dates()->select('event_date')->get(),
                'capacity' => $event->capacity,
                'entrys_cnt' => $entrys_cnt,
                'deleted_at' => $event->deleted_at,
            ];
        }

        return view('entry.index',compact('events','data'));
    }

    public function interm()
    {
        $user_self = User::find(Auth::id());

        if(Gate::allows('system-only')) { //特権ユーザのみ
            $events = Event::where('entry_start_date','<=',now())
                                ->where('entry_end_date','>',now())
                                ->orderBy('id', 'desc')->get();
        } elseif(Gate::allows('area-only')) { //支部ユーザのみ
            $events = Event::where('user_id',$user_self)
                                ->where('entry_start_date','<=',now())
                                ->where('entry_end_date','>',now())
                                ->orderBy('id', 'desc')->get();
        }

        foreach($events as $event) {

            // 研修申込期間
            $dt = Carbon::now();
            $entry_start_date = new Carbon($event['entry_start_date']);
            $entry_end_date = new Carbon($event['entry_end_date']);

            // 申込数
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where(function($q){
                                $q->where('entry_status','Y')
                                    ->orWhere('entry_status','YC');
                            })->groupBy('user_id')->get()->count();

            // ステータス
            if($event->deleted_at) {
                $status = "削除済";
            } else {
                if($entrys_cnt >= $event['capacity']){
                    $status = "キャンセル待申込";
                } else {
                    if($entry_start_date > $dt){
                        $status = "申込開始前";
                    } elseif($entry_end_date < $dt) {
                        $status = "申込受付終了";
                    } else {
                        $status = "申込受付中";
                    } 
                }
            }
                            
            $data[] = [
                'id' => $event->id,
                'title' => $event->title,
                'status' => $status,
                'event_dates' => $event->event_dates()->select('event_date')->get(),
                'capacity' => $event->capacity,
                'entrys_cnt' => $entrys_cnt,
                'deleted_at' => $event->deleted_at,
            ];
        }

        return view('entry.interm',compact('events','data'));
    }

    public function finished()
    {
        $user_self = User::find(Auth::id());

        if(Gate::allows('system-only')) { //特権ユーザのみ
            $events = Event::where('entry_end_date','<',now())
                                ->orderBy('id', 'desc')->get();
        } elseif(Gate::allows('area-only')) { //支部ユーザのみ
            $events = Event::where('user_id',$user_self)
                                ->where('entry_end_date','<',now())
                                ->orderBy('id', 'desc')->get();
        } 

        foreach($events as $event) {

            // 研修申込期間
            $dt = Carbon::now();
            $entry_start_date = new Carbon($event['entry_start_date']);
            $entry_end_date = new Carbon($event['entry_end_date']);

            // 申込数
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where(function($q){
                                $q->where('entry_status','Y')
                                    ->orWhere('entry_status','YC');
                            })->groupBy('user_id')->get()->count();

            // ステータス
            if($event->deleted_at) {
                $status = "削除済";
            } else {
                if($entrys_cnt >= $event['capacity']){
                    $status = "キャンセル待申込";
                } else {
                    if($entry_start_date > $dt){
                        $status = "申込開始前";
                    } elseif($entry_end_date < $dt) {
                        $status = "申込受付終了";
                    } else {
                        $status = "申込受付中";
                    } 
                }
            }
                            
            $data[] = [
                'id' => $event->id,
                'title' => $event->title,
                'status' => $status,
                'event_dates' => $event->event_dates()->select('event_date')->get(),
                'capacity' => $event->capacity,
                'entrys_cnt' => $entrys_cnt,
                'deleted_at' => $event->deleted_at,
            ];
        }

        return view('entry.finished',compact('events','data'));
    }

    public function show($id)
    {
        $event = Event::find($id);
        if($event->id) {
            $careerup_curriculums = $event->careerup_curriculums;
            $event_dates = $event->event_dates;
        } else {
            $careerup_curriculums = null;
            $event_dates = null;
        }
        $general_or_carrerup = 
            ($event->general_or_carrerup === 'carrerup') 
            ? config('const.TRAINING_VARIATION.carrerup') 
            : config('const.TRAINING_VARIATION.general');

        // 申込者数（=申込者数+申込後キャンセル数） 
        $entrys_cnt = Entry::select('user_id')
                        ->where('event_id',$id)
                        ->where(function($q){
                            $q->where('entry_status','Y')
                                ->orWhere('entry_status','YC');
                        })->groupBy('user_id')->get()->count();
        //定員数＝申込数フラグ
        $max_frag = ($entrys_cnt === $event->capacity) ? true : false;

 
        // 申込完了者
        $entrys_y = Entry::select('user_id','created_at','ticket_status')
                        ->where('event_id',$id)
                        ->where('entry_status','Y')
                        ->groupBy('user_id','created_at','ticket_status')
                        ->get();

        if($entrys_y->count() > 0){
            foreach($entrys_y as $entry) {
                
                // ユーザ名
                $user = User::withTrashed()->find($entry->user_id);
                // 所属施設名
                if($user->company_profile_id) {
                    $company = User::where('role_id',3)->where('company_profile_id',$user->company_profile_id)->first();
                    $company_name = $company->name;
                } else {
                    $company = $user->profile;
                    $company_name = $company->other_facility_name;
                }
                // 状態
                if($entry['ticket_status'] == 'Y') {
                    $status = "受講券発行済";
                } else {
                    $status = "受講券未";
                }

                $entrys_y_view[] = [
                    'user_id' => $entry['user_id'],
                    'user_name' => $user->name,
                    'user_ruby' => $user->ruby,
                    'user_deleted_at' => $user->deleted_at,
                    'company_name' => $company_name,
                    'created' => $entry['created_at'],
                    'status' => $status,
                ];
            }
        } else {
            $entrys_y_view = [];
        }
        //申込完了者を氏名（フリガナ）でソート
        foreach ((array)$entrys_y_view as $key => $value) {
            $sort[$key] = $value['user_ruby'];
        }
        array_multisort($sort, SORT_ASC, $entrys_y_view);



        // 申込後キャンセル者
        $entrys_yc = Entry::select('user_id','created_at','ticket_status')
                        ->where('event_id',$id)
                        ->where('entry_status','YC')
                        ->groupBy('user_id','created_at','ticket_status')
                        ->get();
        
        if($entrys_yc->count() > 0){
            foreach($entrys_yc as $entry) {
                
                // ユーザ名
                $user = User::withTrashed()->find($entry->user_id);
                // 所属施設名
                if($user->company_profile_id) {
                    $company = User::where('role_id',3)->where('company_profile_id',$user->company_profile_id)->first();
                    $company_name = $company->name;
                } else {
                    $company = $user->profile;
                    $company_name = $company->other_facility_name;
                }
                // 状態
                if($entry['ticket_status'] == 'Y') {
                    $status = "受講券発行済";
                } else {
                    $status = "受講券未";
                }

                $entrys_yc_view[] = [
                    'user_id' => $entry['user_id'],
                    'user_name' => $user->name,
                    'user_ruby' => $user->ruby,
                    'user_deleted_at' => $user->deleted_at,
                    'company_name' => $company_name,
                    'created' => $entry['created_at'],
                    'status' => $status,
                ];
                //dd($entrys_yc_view);
            }
        } else {
            $entrys_yc_view = [];
        }

        // キャンセル待ち申込者
        $entrys_cw = Entry::select('user_id','created_at','ticket_status')
                        ->where('event_id',$id)
                        ->where('entry_status','CW')
                        ->groupBy('user_id','created_at','ticket_status')
                        ->get();

        if($entrys_cw->count() > 0){
            foreach($entrys_cw as $entry_cw) {
                
                // ユーザ名
                $user = User::withTrashed()->find($entry_cw->user_id);
                // 所属施設名
                if($user->company_profile_id) {
                    $company = User::where('role_id',3)->where('company_profile_id',$user->company_profile_id)->first();
                    $company_name = $company->name;
                } else {
                    $company = $user->profile;
                    $company_name = $company->other_facility_name;
                }
                // 状態
                $status = "キャンセル待ち";

                $entrys_cw_view[] = [
                    'user_id' => $entry_cw['user_id'],
                    'user_name' => $user->name,
                    'user_ruby' => $user->ruby,
                    'user_deleted_at' => $user->deleted_at,
                    'company_name' => $company_name,
                    'created' => $entry_cw['created_at'],
                    'status' => $status,
                ];
            }
        } else {
            $entrys_cw_view = [];
        }

        return view('entry.show',
                compact(
                    'event','careerup_curriculums','event_dates',
                    'general_or_carrerup','max_frag',
                    'entrys_y_view','entrys_yc_view','entrys_cw_view'
                ));
    }

    public function ticketsend(Request $request)
    {
        $user = User::find($request->user_id);
        $event = Event::find($request->event_id);
        $event_dates = $event->event_dates()->get();
        $entrys = Entry::where('user_id',$request->user_id)
                        ->where('event_id',$request->event_id)
                        ->where('entry_status','Y')
                        ->get();

        foreach($entrys as $entry){
            $entry->ticket_status = "Y";
            $entry->save();
        }

        $data = [
            'username' => $user->name,
            'eventtitle' => $event->title,
            'eventdates' => $event_dates,
            'ticketid' => $user->id.'-'.$event->id,
        ];

        $email = new TicketSendMail($data);
        Mail::to($user->email)->send($email);

        return redirect()
                ->route('entry.show',['id' => $request->event_id])
                ->with('status',$user->name.'へ受講券発行案内のメールを送信しました。');
    }

    public function cancel(Request $request) {

        $event = Event::find($request->event_id);
        $user = User::find($request->user_id);
        $entrys = Entry::where('user_id',$request->user_id)
                        ->where('event_id',$request->event_id)
                        ->where('entry_status','Y')
                        ->get();

        foreach($entrys as $entry){
            $entry->entry_status = "YC";
            $entry->save();
        }

        return redirect()
                    ->route('entry.show',['id' => $request->event_id])
                    ->with('attention','ユーザ：'.$user->name.'の申込をキャンセルしました。');
    }

    public function destroy(Request $request) {

        $event = Event::find($request->event_id);
        $event_dates = $event->event_dates()->get();

        // 削除
        $delete_user = User::find($request->delete_user_id);
        $delete_entrys = Entry::where('user_id',$request->delete_user_id)
                        ->where('event_id',$request->event_id)
                        ->where('entry_status','YC')
                        ->get();
        foreach($delete_entrys as $entry){
            $entry->delete();
        }

        //繰り上げ者がいる場合
        if($request->upgrade_user_id) {
            $upgrade_user = User::find($request->upgrade_user_id);
            $upgrade_entrys = Entry::where('user_id',$request->upgrade_user_id)
                            ->where('event_id',$request->event_id)
                            ->where('entry_status','CW')
                            ->get();
            // 通し番号
            $anumber = Entry::where('event_id',$request->event_id) 
                            ->where(function($q){
                                $q->where('entry_status','Y')
                                    ->orWhere('entry_status','YC');
                            })->get();
            $applynumber = ($anumber->count() > 0) ? $anumber->max('serial_number') : 0;
            
            // 申込ステータスと通し番号更新
            foreach($upgrade_entrys as $entry){
                $entry->entry_status = "Y";
                $entry->serial_number = ($applynumber+1);
                $entry->save();
            }                       
            $vmessage = 'ユーザ：【'.$delete_user->name.'】の申込データを削除し、ユーザ：【'.$upgrade_user->name.'】を申込者へ繰り上げしました。';

            $data = [
                'username' => $upgrade_user->name,
                'eventtitle' => $event->title,
                'eventdates' => $event_dates,
            ];

            $email = new UpgradingNoticeMail($data);
            Mail::to($upgrade_user->email)->send($email);


        } else {
            $vmessage = 'ユーザ：【'.$delete_user->name.'】の申込データを削除しました。';
        }

        return redirect()
                    ->route('entry.show',['id' => $request->event_id])
                    ->with('attention',$vmessage);
        
    }

    public function entry_csv(Request $request) 
    {
        if(Gate::denies('area-higher')) {
            return redirect()->route('event.index');
        }
 
        // 申込完了者
        $entrys_y = Entry::select('user_id','created_at','ticket_status')
                        ->where('event_id',$request->event_id)
                        ->where('entry_status','Y')
                        ->groupBy('user_id','created_at','ticket_status')
                        ->get();

        if($entrys_y->count() > 0){
            foreach($entrys_y as $entry) {
                
                // ユーザ名
                $user = User::find($entry->user_id);
                // 所属施設名
                if($user->company_profile_id) {
                    $company = User::where('role_id',3)->where('company_profile_id',$user->company_profile_id)->first();
                    $company_name = $company->name;
                    $company_email = $company->email;
                    $company_address = $company->address;
                } else {
                    $company = $user->profile;
                    $company_name = $company->other_facility_name;
                    $company_email = null;
                    $company_address = $company->other_facility_address;
                }
                // 状態
                if($entry['ticket_status'] == 'Y') {
                    $status = "受講券発行済";
                } else {
                    $status = "受講券未";
                }

                $lists[] = [
                    $status,
                    $entry['created_at'],
                    $user->name,
                    $user->ruby,
                    $user->profile->birth_year."年".$user->profile->birth_month."月".$user->profile->birth_day."日",
                    $user->profile->job,
                    $user->profile->childminder_number,
                    $user->zip,
                    $user->address,
                    $company_name,
                    $company_address,
                    $company_email,
                ];
            }
        } else {
            $lists = [];
        }

        $filename = 'entry.csv';
        $file = Csv::createCsv($filename);

        // 見出し
        $heading = ['状況','申込日時','名前','フリガナ','生年月日','職種','保育士番号','個人の郵便番号','個人の住所','所属施設名','所属施設住所','所属施設メールアドレス'];

        Csv::write($file,$heading); 

        // data insert
        foreach ($lists as $data) {
            Csv::write($file, $data);
        }
        $response = file_get_contents($file);

        // ストリームに入れたら実ファイルは削除
        Csv::purge($filename);

        return response($response, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename='.$filename);

    }    
}
