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
use App\Event_upload;
use App\Entry;
use Mail;
use App\Http\Traits\Csv;

class ReceptionController extends Controller
{
    public function index()
    {
        $user_self = User::find(Auth::id());

        if(Gate::allows('system-only')) { //特権ユーザのみ
            $events = Event::orderBy('id', 'desc')->get();
        } elseif(Gate::allows('area-only')) { //支部ユーザのみ
            $events = Event::where('user_id',$user_self)->orderBy('id', 'desc')->get();
        }

        $data_cnt = false;

        foreach($events as $event) {

            // 申込数（受講券発行者数）
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where('entry_status','Y')
                            ->Where('ticket_status','Y')
                            ->groupBy('user_id')->get()->count();

            // 受付数
            $reception_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where('entry_status','Y')
                            ->Where('ticket_status','Y')
                            ->Where('attend_status','Y')
                            ->groupBy('user_id')->get()->count();

            // 研修開催日
            $dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
            $dt7daysafter = $dt->addDays(7);
            $nowdt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
            $event_dates = $event->event_dates()->get();

            foreach($event_dates as $date) {
                $event_date = new Carbon($date['event_date']);

                if($nowdt <= $event_date && $dt7daysafter >= $event_date) {// 研修開催日が現在から1週間以内であれば
                    $data[] = [
                        'event_id' => $event->id,
                        'event_date_id' => $date['id'],
                        'title' => $event->title,
                        'entry_end_date' => $event->entry_end_date,
                        'event_date' => $event_date,                        
                        'entrys_cnt' => $entrys_cnt,
                        'reception_cnt' => $reception_cnt,
                    ];
                    $data_cnt = true;
                }
            }
        }
        $data = ($data_cnt === true) ? $data : [];

        return view('reception.index',compact('events','data'));
    }

    public function finished()
    {
        $user_self = User::find(Auth::id());

        if(Gate::allows('system-only')) { //特権ユーザのみ
            $events = Event::withTrashed()->orderBy('id', 'desc')->get();
        } elseif(Gate::allows('area-only')) { //支部ユーザのみ
            $events = Event::withTrashed()->where('user_id',$user_self)->orderBy('id', 'desc')->get();
        }

        $data_cnt = false;

        foreach($events as $event) {

            // 申込数（受講券発行者数）
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where('entry_status','Y')
                            ->Where('ticket_status','Y')
                            ->groupBy('user_id')->get()->count();

            // 受付数
            $reception_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where('entry_status','Y')
                            ->Where('ticket_status','Y')
                            ->Where('attend_status','Y')
                            ->groupBy('user_id')->get()->count();

            // 研修開催日
            $dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
            $event_dates = $event->event_dates()->get();

            foreach($event_dates as $date) {
                $event_date = new Carbon($date['event_date']);                

                if($dt > $event_date) {// 研修開催日が現在から翌日以降
                    $data[] = [
                        'event_id' => $event->id,
                        'event_date_id' => $date['id'],
                        'title' => $event->title,
                        'entry_end_date' => $event->entry_end_date,
                        'event_date' => $event_date,                        
                        'entrys_cnt' => $entrys_cnt,
                        'reception_cnt' => $reception_cnt,
                    ];
                    $data_cnt = true;
                }
            }
        }
        $data = ($data_cnt === true) ? $data : [];

        return view('reception.finished',compact('events','data'));
    }    

    public function show($id)
    {
        if(!preg_match('/\-/',$id)) {
            return redirect()->back();
        } else {
            list($event_id,$event_date_id) = explode('-',$id);

            $event = Event::find($event_id);
            $event_date = Event_date::find($event_date_id);

            if(!$event || !$event_date) { //研修、研修開催日
                return redirect()->back();
            }
            $general_or_carrerup = 
                ($event->general_or_carrerup === 'carrerup') 
                ? config('const.TRAINING_VARIATION.carrerup') 
                : config('const.TRAINING_VARIATION.general');
            
            // 申込完了者
            $entrys = Entry::where('event_id',$event_id)
                            ->where('event_date_id',$event_date->id)
                            ->where('entry_status','Y')
                            ->where('ticket_status','Y')
                            ->get();

            // 受付完了者数
            $reception_cnt = Entry::where('event_id',$event_id)
                            ->where('event_date_id',$event_date->id)
                            ->where('entry_status','Y')
                            ->where('ticket_status','Y')
                            ->where('attend_status','Y')
                            ->get()->count();
            
            if($entrys->count() > 0) {

                foreach($entrys as $entry) {

                    // ユーザ名
                    $user = User::find($entry->user_id);

                    // 所属施設名
                    if($user->company_profile_id) {
                        $company = User::where('role_id',3)->where('company_profile_id',$user->company_profile_id)->first();
                        $company_name = $company->name;
                    } else {
                        $company = $user->profile;
                        $company_name = $company->other_facility_name;
                    }

                    // 状態
                    if($entry['attend_status'] == 'Y') {
                        $status = "参加受付済";
                    } else {
                        $status = "受付未";
                    }

                    $entrys_view[] = [
                        'id' => $entry['id'],
                        'status' => $status,
                        'user_id' => $entry['user_id'],
                        'user_name' => $user->name,
                        'user_ruby' => $user->ruby,
                        'company_name' => $company_name,
                        'created' => $entry['created_at'],
                    ];                
                }

            } else {
                $entrys_view = [];
            }

            if(count($entrys_view) > 0) {
                // 参加者氏名（フリガナ順）にソート
                foreach ((array)$entrys_view as $key => $value) {
                    $sort[$key] = $value['user_ruby'];
                }
                array_multisort($sort, SORT_ASC, $entrys_view);
            }

            return view('reception.show',
                    compact('event','event_date','general_or_carrerup','entrys_view','reception_cnt'));
                            
        }
    }

    public function readqr($id) 
    {
        if(!preg_match('/\-/',$id)) {
            return redirect()->back();
        } else {
            list($event_id,$event_date_id) = explode('-',$id);

            $event = Event::find($event_id);
            $event_date = Event_date::find($event_date_id);


            if(!$event || !$event_date) { //研修、研修開催日
                return redirect()->back();
            }
            $general_or_carrerup = 
                ($event->general_or_carrerup === 'carrerup') 
                ? config('const.TRAINING_VARIATION.carrerup') 
                : config('const.TRAINING_VARIATION.general');
            
            // 受付完了者
            $entrys = Entry::where('event_id',$event_id)
                            ->where('event_date_id',$event_date->id)
                            ->where('entry_status','Y')
                            ->where('ticket_status','Y')
                            ->where('attend_status','Y')
                            ->get();

            // 参加予定者数
            $entrys_cnt = Entry::where('event_id',$event_id)
                            ->where('event_date_id',$event_date->id)
                            ->where('entry_status','Y')
                            ->where('ticket_status','Y')
                            ->get()->count();
            // 受付完了者数
            $reception_cnt = Entry::where('event_id',$event_id)
                            ->where('event_date_id',$event_date->id)
                            ->where('entry_status','Y')
                            ->where('ticket_status','Y')
                            ->where('attend_status','Y')
                            ->get()->count();
            
            if($entrys->count() > 0) {

                foreach($entrys as $entry) {

                    // ユーザ名
                    $user = User::find($entry->user_id);

                    // 所属施設名
                    if($user->company_profile_id) {
                        $company = User::where('role_id',3)->where('company_profile_id',$user->company_profile_id)->first();
                        $company_name = $company->name;
                    } else {
                        $company = $user->profile;
                        $company_name = $company->other_facility_name;
                    }

                    // 状態
                    if($entry['attend_status'] == 'Y') {
                        $status = "参加受付済";
                    } else {
                        $status = "受付未";
                    }

                    $entrys_view[] = [
                        'id' => $entry['id'],
                        'status' => $status,
                        'user_id' => $entry['user_id'],
                        'user_name' => $user->name,
                        'user_ruby' => $user->ruby,
                        'company_name' => $company_name,
                        'created' => $entry['created_at'],
                    ];                
                }

            } else {
                $entrys_view = [];
            }

            return view('reception.readqr',
                    compact('event','event_date','general_or_carrerup','entrys_view','entrys_cnt','reception_cnt'));
                            
        }
    }

    public function manual(Request $request) {

        $user_id = $request->user_id;
        $event_id = $request->event_id;

        $user = User::find($user_id);
        $event = Event::find($event_id);

        if($user->role_id != 4 || !$event) { //ユーザ、研修
            return redirect()
                ->route('reception.show',['id' => $event_id.'-'.$request->event_date_id])
                ->with('attention','不正なデータです。');
        } else {
            if($user->deleted_at) {
                return redirect()
                    ->route('reception.show',['id' => $event_id.'-'.$request->event_date_id])
                    ->with('attention','退会しているため、受付完了にできません。');
            }
        }
        
        $entry = Entry::where('user_id',$user_id)
                        ->where('event_id',$event_id)
                        ->where('event_date_id',$request->event_date_id)
                        ->first();
        if(!$entry) {
            return redirect()
                ->route('reception.show',['id' => $event_id.'-'.$request->event_date_id])
                ->with('attention','受付する該当データがみつかりません。');
        }
        $entry->attend_status = 'Y';
        $entry->save();
        
        return redirect()
                    ->route('reception.show',['id' => $event_id.'-'.$request->event_date_id])
                    ->with('status',$user->name.'様を受付完了にしました。');        
    }

    public function auto(Request $request) {

        $len = mb_strlen($request->qrread, "UTF-8");
        $wdt = mb_strwidth($request->qrread, "UTF-8");
        if($len == $wdt) {
            $qrread = $request->qrread;
        } elseif($len * 2 == $wdt) {
            $qrread = mb_convert_kana($request->qrread, "nhk", "utf-8");
        } else {
            $qrread = mb_convert_kana($request->qrread, "nhk", "utf-8");
        }

        list($user_id4,$event_id4,$serial_num4) = explode('-',$qrread);
        $user_id = (int)$user_id4;
        $event_id = (int)$event_id4;
        $serial_num = (int)$serial_num4;

        $user = User::find($user_id);
        $event = Event::find($event_id);

        if($user->role_id != 4 || !$event) { //ユーザ、研修
            return redirect()
                ->route('reception.readqr',['id' => $event_id.'-'.$request->event_date_id])
                ->with('attention','不正なデータです。');
        } else {
            if($user->deleted_at) {
                return redirect()
                    ->route('reception.readqr',['id' => $event_id.'-'.$request->event_date_id])
                    ->with('attention','退会しているため、受付完了にできません。');
            }
        }
        
        $entry = Entry::where('user_id',$user_id)
                        ->where('event_id',$event_id)
                        ->where('event_date_id',$request->event_date_id)
                        ->first();
        if(!$entry) {
            return redirect()
                ->route('reception.readqr',['id' => $event_id.'-'.$request->event_date_id])
                ->with('attention','受付する該当データがみつかりません。');
        }
        $entry->attend_status = 'Y';
        $entry->save();
        
        return redirect()
                    ->route('reception.readqr',['id' => $event_id.'-'.$request->event_date_id])
                    ->with('status',$user->name.'様を受付完了にしました。');

    }

    public function reception_csv(Request $request) 
    {
        if(Gate::denies('area-higher')) {
            return redirect()->route('event.index');
        }
 
        // 受付完了者
        $entrys_y = Entry::select('user_id','created_at','ticket_status','attend_status')
                        ->where('event_id',$request->event_id)
                        ->where('entry_status','Y')
                        ->where('ticket_status','Y')
                        ->groupBy('user_id','created_at','ticket_status','attend_status')
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
                if($entry['attend_status'] == 'Y') {
                    $status = "受付完了";
                } else {
                    $status = "受付未";
                }

                $lists[] = [
                    $status,
                    $user->name,
                    $user->ruby,
                    $user->email,
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
        $heading = ['状況','名前','フリガナ','メールアドレス','生年月日','職種','保育士番号','個人の郵便番号','個人の住所','所属施設名','所属施設住所','所属施設メールアドレス'];

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
