<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
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
use App\Mail\FinishedSendMail;
use App\Mail\AllFinishedSendMail;
use App\Http\Traits\Csv;

class ReceptionController extends Controller
{
    public function index()
    {
        $user_self = User::find(Auth::id());

        if(Gate::allows('system-only')) { //特権ユーザのみ
            $events = Event::orderBy('id', 'desc')->get();
        } elseif(Gate::allows('area-only')) { //支部ユーザのみ
            $events = Event::where('user_id',$user_self->id)->orderBy('id', 'desc')->get();
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

            // 主催者（作成ユーザ)
            if($event->user_id) {
                $role_name = $event->user->role->display_name;
                if($role_name == 'admin') {
                    $organizer = '兵庫県保育協会';
                } elseif($role_name == 'area') {
                    $organizer = $event->user->name.'支部';
                } else {
                    $organizer = null;
                }
            } else {
                $organizer = null;
            }

            foreach($event_dates as $date) {
                $event_date = new Carbon($date['event_date']);

                if($nowdt <= $event_date && $dt7daysafter >= $event_date) {// 研修開催日が現在から1週間以内であれば
                    $data[] = [
                        'event_id' => $event->id,
                        'event_date_id' => $date['id'],
                        'organizer' => $organizer,
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
            $events = Event::withTrashed()->where('user_id',$user_self->id)->orderBy('id', 'desc')->get();
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

            // 主催者（作成ユーザ)
            if($event->user_id) {
                $role_name = $event->user->role->display_name;
                if($role_name == 'admin') {
                    $organizer = '兵庫県保育協会';
                } elseif($role_name == 'area') {
                    $organizer = $event->user->name.'支部';
                } else {
                    $organizer = null;
                }
            } else {
                $organizer = null;
            }

            foreach($event_dates as $date) {
                $event_date = new Carbon($date['event_date']);                

                if($dt > $event_date) {// 研修開催日が現在から翌日以降
                    $data[] = [
                        'event_id' => $event->id,
                        'event_date_id' => $date['id'],
                        'organizer' => $organizer,
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
                        if($entry['finished_status'] == 'Y') {
                            $finished_status = "受講証明書発行済";
                        } else {
                            $finished_status = "受講証明書未発行";
                        }
                    } else {
                        $status = "受付未";
                        $finished_status = null;
                    }

                    $entrys_view[] = [
                        'id' => $entry['id'],
                        'finished_status' => $finished_status,
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

            $for_finishedsend = [];
            if(count($entrys_view) > 0) {
                $collection = collect($entrys_view);
                $entrys_view = $collection->SortBy('user_ruby');
                $for_finishedsend = $collection->where('finished_status','受講証明書未発行');
            }

            return view('reception.show',
                    compact('event','event_date','general_or_carrerup','entrys_view','reception_cnt','for_finishedsend'));
                            
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


    public function finishedsend(Request $request) {

        $user = User::find($request->user_id);
        $event = Event::find($request->event_id);
        $entrys = Entry::where('user_id',$request->user_id)
                        ->where('event_id',$request->event_id)
                        ->get();

        foreach($entrys as $i => $entry) {
            $entry->finished_status = 'Y';
            $entry->save();
        }

        $data = [
            'username' => $user->name,
            'event_title' => $event->title,
        ];
        $email = new FinishedSendMail($data);
        Mail::to($user->email)->send($email);

        return redirect()
                    ->route('reception.show',['id' => $request->event_id.'-'.$request->event_date_id])
                    ->with('status',$user->name.'へ【'.$event->title.'】受講証明書を発行しました。');        
    }

    public function finishedsendmulti(Request $request) {

        $except_users = User::find($request->except_users);
        $event = Event::find($request->event_id);
        $event_date = Event_date::find($request->event_date_id);

        //dd($except_users);
        if($except_users) {

            // 除外ユーザ
            foreach($except_users as $item) {
                $except_users_id[] = $item->id;
            }

            // 受講証明書発行する参加者
            $notfinished_user_entrys = Entry::where('event_id',$event->id)
                            ->where('event_date_id',$event_date->id)
                            ->where('entry_status','Y')
                            ->where('ticket_status','Y')
                            ->where('attend_status','Y')
                            ->where('finished_status','N')                            
                            ->whereNotIn('user_id',$except_users_id)                            
                            ->get();

        } else {

            // 受講証明書発行する参加者
            $notfinished_user_entrys = Entry::where('event_id',$event->id)
                            ->where('event_date_id',$event_date->id)
                            ->where('entry_status','Y')
                            ->where('ticket_status','Y')
                            ->where('attend_status','Y')
                            ->where('finished_status','N')                            
                            ->get();
        }


        if($notfinished_user_entrys->count() > 0) {
            
            foreach($notfinished_user_entrys as $i => $entry) {

                // 受講証明書発行済フラグ付与
                $entry->finished_status = 'Y';
                $entry->save();

                // メール案内先ユーザ
                $users[] = User::find($entry->user_id);
                
            }
            $users = collect($users);

            // Sendgrid Personalizations用に成形
            $personalizations = [];
            $regstr = "/(\W|^)[\w.\-]{0,25}@(example)\.(com|net)(\W|$)/";            
            foreach($users as $i => $user) {
                if(!preg_match($regstr,$user->email)) {//ダミーアドレスを除外（ @example.com | @example.net )
                    $personalizations[$i]['to'] = [
                        'email' => $user->email
                    ];
                    $personalizations[$i]['substitutions'] = [
                        '-username-' => $user->name
                    ];
                }
            }
            $personalizations = array_merge($personalizations);    
            if(count($personalizations) == 0) {
                return redirect()
                        ->route('reception.show',['id' => $request->event_id.'-'.$request->event_date_id])
                        ->with('attention', '指定した送信先に有効なメールアドレスがないため送信できません。なお受講証明書は発行済となっております。');
            }

            $data = [
                'eventtitle' => $event->title,
                'personalizations' => $personalizations,// Sendgrid Personalizations用
            ];
            $emails = new AllFinishedSendMail($data);
            Mail::send($emails);

            return redirect()
                    ->route('reception.show',['id' => $request->event_id.'-'.$request->event_date_id])
                    ->with('status','受講券未発行のユーザへ受講券発行案内のメールを送信しました。');            

        } else {
            return redirect()
                ->route('reception.show',['id' => $request->event_id.'-'.$request->event_date_id])
                ->with('attention','受講証明書を発行するユーザがいません。');            
        }

    }

    public function reception_csv(Request $request) 
    {
        if(Gate::denies('area-higher')) {
            return redirect()->route('event.before');
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

    public function all_attendance_pdf(Request $request) 
    {
        if(Gate::denies('area-higher')) {
            return redirect()->route('event.before');
        }

        if(!$request->event_id || !is_numeric($request->event_id)) {
            $emes = '不正なデータです。';
        } else {

            $event = Event::find($request->event_id);

            if(!$event) { //ユーザ、研修
                $emes = '不正なデータです。';
            }

            // 研修開催日
            $event_dates = $event->event_dates;

            $entrys = Entry::where('event_id',$event->id)
                        ->where('entry_status','Y')
                        ->where('ticket_status','Y')
                        ->distinct('user_id')
                        ->get();
            if($entrys->count() === 0) {// 該当研修の申込ステータス確認
                $emes = '不正なデータです。';
            }

            // 研修種別
            $careerup_curriculums = $event->careerup_curriculums;

            if($careerup_curriculums->count() > 0) {
                foreach($careerup_curriculums as $careerup_curriculum) {
                    $fields[] = $careerup_curriculum->parent_curriculum;                        

                    if($careerup_curriculum->training_minute % 60 == 0) {
                        $training_hours = floor($careerup_curriculum->training_minute / 60);
                    } else {
                        if($careerup_curriculum->training_minute % 60 >= 30) {
                            $training_hours = floor($careerup_curriculum->training_minute / 60).'.5';
                        } else {
                            $training_hours = floor($careerup_curriculum->training_minute / 60);
                        }
                    }

                    $careerup_data[] = [
                        'parent' => $careerup_curriculum->parent_curriculum,
                        'child' => $careerup_curriculum->child_curriculum,
                        'training_minutes' => $training_hours,
                    ];
                }
            } else {
                $careerup_data = null;
            }


            // 印鑑画像
            $host = $request->getHttpHost(); 
            $img_src = ('http://'.$host.'/img/seal_blk.png');
            $seal_img = '<img class="seal_img" src="'.$img_src.'">';


            $datas = [];
            foreach($entrys as $entry) {
                $user = User::find($entry->user_id);

                // 所属施設
                if($user->company_profile_id) {
                    $company = User::where('status',1)
                                    ->where('role_id',3)
                                    ->where('company_profile_id',$user->company_profile_id)
                                    ->first();
                    $company_name = ($company) ? $company->name : null;
                } else {
                    $profile = $user->profile;
                    $company_name = $profile->other_facility_name;
                }

                $datas[] = [
                    'ruby' => $user->ruby,
                    'user' => $user,
                    'profile' => $user->profile,
                    'event' => $event,
                    'event_dates' => $event_dates,
                    'company_name' => $company_name,
                    'careerup_data' => $careerup_data,
                    'seal_img' => $seal_img,
                ];                     
            }
            if(count($datas) > 0 ) {
                $collection = collect($datas);
                $datas = $collection->sortBy('ruby')->all();
            }
        }

        if(isset($emes)) {
            return redirect()->back();
        } else {
            if(count($datas) > 0) {
                $datas = collect($datas);
                $datas->chunk(20);
                $datas->toArray();
                $pdf = PDF::loadView('reception.all_attendance_pdf', compact('datas'));
                //return $pdf->stream('attendance.pdf');
                return $pdf->download('attendance.pdf');
            } else {
                return redirect()->back();
            }
        }

    }

}
