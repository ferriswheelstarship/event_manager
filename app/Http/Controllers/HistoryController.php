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
use App\Entry;
use App\Careerup_certificate;
use App\Certificates;
use Mail;
use App\Mail\FinishedSendMail;
use App\Mail\CertificateSendMail;

class HistoryController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());

        if(Gate::allows('admin-higher')) { //個人ユーザのみ表示
            return redirect()
                ->route('history.user');
        }

        // 参加済
        $entrys = Entry::select('event_id','finished_status')
                        ->where('user_id',Auth::id())
                        ->where('entry_status','Y')
                        ->where('ticket_status','Y')
                        ->where('attend_status','Y')
                        ->groupBy('event_id','finished_status')->get();
        if($entrys->count() > 0) {
            foreach($entrys as $key => $entry) {
                
                // 参加済研修 
                $event = Event::find($entry->event_id);
                                
                if($event->general_or_carrerup == 'carrerup') {

                    $notattend_entry_cnt = Entry::where('user_id',$user->id)
                                        ->where('event_id',$event->id)
                                        ->where('attend_status','N')
                                        ->get()
                                        ->count();

                    if($notattend_entry_cnt > 0) {
                        $carrerup_data[$key] = null;
                    } else {
                        // 参加済キャリアアップ研修の分野          
                        $careerup_curriculums = $event->careerup_curriculums()->get();
                        
                        // 参加済キャリアアップ研修の研修開催日
                        $event_dates = $event->event_dates()->get();

                        $carrerup_data[$key] = [
                            'event' => $event,
                            'event_dates' => $event_dates,
                            'careerup_curriculums' => $careerup_curriculums,
                            'finished_status' => $entry->finished_status,
                        ];
                    }

                    $general_data[$key] = null;

                } 
                if($event->general_or_carrerup == 'general') {
                    // 参加済一般研修の研修開催日
                    $event_dates = $event->event_dates()->get();

                    $general_data[$key] = [
                        'event' => $event,
                        'event_dates' => $event_dates,
                        'finished_status' => $entry->finished_status,
                    ];
                    $carrerup_data[$key] = null;
                }
            }
        } else {
            $carrerup_data = [];
            $general_data = [];
        }
        $carrerup_data = array_merge(array_filter($carrerup_data));
        $general_data = array_merge(array_filter($general_data));

        // キャリアアップ研修view用
        $fields = config('const.PARENT_CURRICULUM');
        
        foreach($fields as $i => $val) {
            if(count($carrerup_data) > 0) {
                foreach($carrerup_data as $key => $item) {
                    $careerup_curriculums_exists = false;
                    $filterd_careerup_curriculums = null;
                    foreach($item['careerup_curriculums'] as $careerup_curriculums){
                        if($careerup_curriculums->parent_curriculum == $val) {
                            $filterd_careerup_curriculums[] = $careerup_curriculums;
                            $careerup_curriculums_exists = true;
                        }
                    }
                    $sum_training_minute[$i][$key] = 0;
                    if($careerup_curriculums_exists === true) {

                        //dd($filterd_careerup_curriculums);
                        foreach($filterd_careerup_curriculums as $cc) {
                            $sum_training_minute[$i][$key] += (int)$cc['training_minute'];
                        }

                        $view_data[$i][$key] = [
                            'content' => $filterd_careerup_curriculums,
                            'event' => $carrerup_data[$key]['event'],
                            'event_dates' => $carrerup_data[$key]['event_dates'],
                            'finished_status' => $carrerup_data[$key]['finished_status'],
                        ];

                    } else {

                        $view_data[$i][$key] = [
                            'content' => null,
                            'event' => null,
                            'event_dates' => null,
                            'finished_status' => null,
                        ];

                    }
                }
            } else {
                $sum_training_minute = 0;
                $view_data = null;
            }

            $each_fields_sum_training_minute[$i] = 0;
            if($sum_training_minute != 0) {
                foreach($sum_training_minute as $i => $each_carrerup) {
                    foreach($each_carrerup as $each_minutes) {
                        $each_fields_sum_training_minute[$i] += $each_minutes;
                    }
                }
            }

            $event_content[$i] = null;
            if($view_data != null) {
                foreach($view_data as $i => $items) {
                    foreach($items as $event_infos) {
                        if($event_infos['content']) {
                            $event_content[$i][] = $event_infos;
                        } 
                    }
                }
            }
            
            $carrerup_view_data[] = [
                'fields' => $val,
                'training_minute' => $each_fields_sum_training_minute[$i],
                'eventinfo' => $event_content[$i],
            ];

        }

        return view
                ('history.index',
                    compact('user','carrerup_view_data','general_data','fields','fields_item')
                );
    }

    public function user()
    {
        $user_self = User::find(Auth::id());

        if(Gate::allows('system-only')){ // 特権ユーザのみ
            // $users = User::where('status',1)
            //                 ->where('role_id',4)
            //                 ->orderBy('id', 'desc')
            //                 ->get();
            $users = [];
            DB::table('users')
            ->where('status',1)
            ->where('role_id',4)
            ->whereNotNull('name')
            ->where('deleted_at',null)
            ->orderBy('id', 'desc')
            ->chunk(100, function ($data) use (&$users) {
                $users[] = $data;
            });
        } elseif(Gate::allows('admin-only')) { // 法人ユーザのみ
            // $users = User::where('status',1)
            //                 ->where('role_id',4)
            //                 ->where('company_profile_id',$user_self->company_profile_id)
            //                 ->orderBy('id', 'desc')
            //                 ->get();
            $users = [];
            DB::table('users')
            ->where('status',1)
            ->where('role_id',4)
            ->where('company_profile_id',$user_self->company_profile_id)
            ->whereNotNull('name')
            ->where('deleted_at',null)
            ->orderBy('id', 'desc')
            ->chunk(100, function ($data) use (&$users) {
                $users[] = $data;
            });
        } else{
            return redirect()
                ->route('dashboard');
        }
        
        if(count($users) > 0) {
            foreach($users as $chunk) {
                foreach($chunk as $user) {
                    if($user->company_profile_id) {
                        $company = User::where('role_id',3)
                                        ->where('company_profile_id',$user->company_profile_id)
                                        ->first();
                        $companyname = $company->name;

                        if(preg_match('/村/',$company->address)){
                            list($city,$etc) = explode("村",$company->address);
                            $city = $city."村";
                        } elseif(preg_match('/市/',$company->address)){
                            list($city,$etc) = explode("市",$company->address);
                            $city = $city."市";
                        } elseif(preg_match('/郡/',$company->address)){
                            list($city,$etc) = explode("郡",$company->address);
                            $city = $city."郡";
                        } else {
                            $city = $company->address;
                        }

                    } else {
                        $profile = Profile::find($user->profile_id);
                        $companyname = $profile->other_facility_name;
                        $city = $profile->other_facility_pref.$profile->other_facility_address;
                    }

                    $datas[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'ruby' => $user->ruby,
                        'companyname' => $companyname,
                        'city' => $city,
                    ];
                }
            }
        } else {
            $datas = [];
        }

        if(count($datas) > 0) {
            // 参加者氏名（フリガナ順）にソート
            foreach ((array)$datas as $key => $value) {
                $sort[$key] = $value['ruby'];
            }
            array_multisort($sort, SORT_ASC, $datas);
        }


        return view('history.user',compact('datas','pref'));
    }

    public function show($id) 
    {

        $user = User::find($id);
        $user_self = User::find(Auth::id());

        if(Gate::allows('user-only')) { //個人ユーザ

            return redirect()->route('history.index');
        
        } elseif(Gate::allows('admin-only')) { // 法人ユーザ
            // 参加済
            $entrys = Entry::select('event_id','finished_status')
                        ->where('user_id',$user->id)
                        ->where('applying_user_id',$user_self->id)
                        ->where('entry_status','Y')
                        ->where('ticket_status','Y')
                        ->where('attend_status','Y')
                        ->groupBy('event_id','finished_status')->get();

        } elseif(Gate::allows('system-only')) { // 特権ユーザ
            // 参加済
            $entrys = Entry::select('event_id','finished_status')
                        ->where('user_id',$user->id)
                        ->where('entry_status','Y')
                        ->where('ticket_status','Y')
                        ->where('attend_status','Y')
                        ->groupBy('event_id','finished_status')->get();

        } else {
            return redirect()->route('dashboard');
        }
        //dd($entrys);

        if($entrys->count() > 0) {
            foreach($entrys as $key => $entry) {
                
                // 参加済研修 
                $event = Event::find($entry->event_id);
                if($event) {
                    if($event->general_or_carrerup == 'carrerup') {

                        $notattend_entry_cnt = Entry::where('user_id',$user->id)
                                            ->where('event_id',$event->id)
                                            ->where('attend_status','N')
                                            ->get()
                                            ->count();

                        if($notattend_entry_cnt > 0) {
                            $carrerup_data[$key] = null;
                        } else {
                            // 参加済キャリアアップ研修の分野          
                            $careerup_curriculums = $event->careerup_curriculums()->get();
                            
                            // 参加済キャリアアップ研修の研修開催日
                            $event_dates = $event->event_dates()->get();

                            $carrerup_data[$key] = [
                                'event' => $event,
                                'event_dates' => $event_dates,
                                'careerup_curriculums' => $careerup_curriculums,
                                'finished_status' => $entry->finished_status,
                            ];
                        }

                        $general_data[$key] = null;

                    } 
                    if($event->general_or_carrerup == 'general') {
                        // 参加済一般研修の研修開催日
                        $event_dates = $event->event_dates()->get();

                        $general_data[$key] = [
                            'event' => $event,
                            'event_dates' => $event_dates,
                            'finished_status' => $entry->finished_status,
                        ];
                        $carrerup_data[$key] = null;
                    }

                }
            }
        } else {
            $carrerup_data = [];
            $general_data = [];
        }
        $carrerup_data = array_merge(array_filter($carrerup_data));
        $general_data = array_merge(array_filter($general_data));

        //dd($carrerup_data);

        // キャリアアップ研修view用
        $fields = config('const.PARENT_CURRICULUM');
        
        foreach($fields as $i => $val) {
            if(count($carrerup_data) > 0) {
                foreach($carrerup_data as $key => $item) {
                    $careerup_curriculums_exists = false;
                    $filterd_careerup_curriculums = null;
                    foreach($item['careerup_curriculums'] as $careerup_curriculums){
                        if($careerup_curriculums->parent_curriculum == $val) {
                            $filterd_careerup_curriculums[] = $careerup_curriculums;
                            $careerup_curriculums_exists = true;
                        }
                    }
                    $sum_training_minute[$i][$key] = 0;
                    if($careerup_curriculums_exists === true) {

                        //dd($filterd_careerup_curriculums);
                        foreach($filterd_careerup_curriculums as $cc) {
                            $sum_training_minute[$i][$key] += (int)$cc['training_minute'];
                        }

                        $view_data[$i][$key] = [
                            'content' => $filterd_careerup_curriculums,
                            'event' => $carrerup_data[$key]['event'],
                            'event_dates' => $carrerup_data[$key]['event_dates'],
                            'finished_status' => $carrerup_data[$key]['finished_status'],
                        ];

                    } else {

                        $view_data[$i][$key] = [
                            'content' => null,
                            'event' => null,
                            'event_dates' => null,
                            'finished_status' => null,
                        ];

                    }
                }
            } else {
                $sum_training_minute = 0;
                $view_data = null;
            }

            $each_fields_sum_training_minute[$i] = 0;
            if($sum_training_minute != 0) {
                foreach($sum_training_minute as $i => $each_carrerup) {
                    foreach($each_carrerup as $each_minutes) {
                        $each_fields_sum_training_minute[$i] += $each_minutes;
                    }
                }
            }

            $event_content[$i] = null;
            if($view_data != null) {
                foreach($view_data as $i => $items) {
                    foreach($items as $event_infos) {
                        if($event_infos['content']) {
                            $event_content[$i][] = $event_infos;
                        } 
                    }
                }
            }
            
            $carrerup_view_data[] = [
                'fields' => $val,
                'training_minute' => $each_fields_sum_training_minute[$i],
                'eventinfo' => $event_content[$i],
            ];

        }
        //dd($carrerup_view_data);

        return view
                ('history.show',
                    compact('user','carrerup_view_data','general_data','fields','fields_item')
                );

    }

    public function attendance_pdf(Request $request,$id) 
    {
        // $idのバリデーション例外はpdf表示不可表示
        if(!preg_match('/\-/',$id)) {
            $emes = '不正なデータです。';
        } else {
            list($user_id,$event_id) = explode('-',$id);

            $user = User::find($user_id);
            $event = Event::find($event_id);

            if(!$user || !$event) { //ユーザ、研修
                $emes = '不正なデータです。';
            } else {
                if($user->deleted_at) {
                    $emes = '不正なデータです。';
                }
            }

            // 研修開催日
            $event_dates = $event->event_dates;
            // 未開催の開催日が残っている場合
            //dd('研修は終了していません。');

            $entrys_self = Entry::where('user_id',$user_id)
                        ->where('event_id',$event_id)
                        ->where('entry_status','Y')
                        ->where('ticket_status','Y')
                        ->where('attend_status','Y')
                        ->where('finished_status','Y')
                        ->first();
            if(!$entrys_self) {// 該当研修の申込ステータス確認
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

            // 印鑑画像
            $host = $request->getHttpHost(); 
            $img_src = ('http://'.$host.'/img/seal.png');
            $seal_img = '<img class="seal_img" src="'.$img_src.'">';

            $data = [
                'user' => $user,
                'profile' => $user->profile,
                'event' => $event,
                'event_dates' => $event_dates,
                'company_name' => $company_name,
                'careerup_data' => $careerup_data,
                'seal_img' => $seal_img,
            ];                     
        }

        if(isset($emes)) {
            $pdf = PDF::loadView('error_pdf', compact('emes'));
        } else {
            if($event->general_or_carrerup == 'carrerup') {
                $pdf = PDF::loadView('history.attendance_pdf', compact('data'));
            } else {
                $pdf = PDF::loadView('history.attendance_general_pdf', compact('data'));
            }
        }
        //return $pdf->download('attendance.pdf');
        return $pdf->stream('attendance.pdf');

    }

    public function certificate_pdf($id) 
    {
        $carrerup_certificates = Careerup_certificate::find($id);
        if(!$carrerup_certificates) {
            $emes = '不正なデータです。';
        } else {
            $user = User::find($carrerup_certificates->user_id);
            $profile = $user->profile;

            // 所属施設
            if($user->company_profile_id) {
                $company = User::where('status',1)
                                ->where('role_id',3)
                                ->where('company_profile_id',$user->company_profile_id)
                                ->first();
                $company_name = ($company) ? $company->name : null;
            } else {
                $company_name = $profile->other_facility_name;
            }

            $data = [
                'carrerup_certificates' => $carrerup_certificates,
                'user' => $user,
                'profile' => $profile,
                'company_name' => $company_name,
            ];                     
            
        }

        //dd($data);

        if(isset($emes)) {
            $pdf = PDF::loadView('error_pdf', compact('emes'));
        } else {
            $pdf = PDF::loadView('history.certificate_pdf', compact('data'));
        }
        return $pdf->stream('certificate.pdf');

    }


    public function finishedsend(Request $request) 
    {
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
                ->route('history.show',['id' => $request->user_id])
                ->with('status',$user->name.'へ【'.$event->title.'】受講証明書を発行しました。');
    }

    public function certificatesend(Request $request) 
    {

        $user = User::find($request->user_id);
        $parent_curriculum = $request->parent_curriculum;
        $careerup_certificate = NEW Careerup_certificate;
        $careerup_certificate->user_id = $request->user_id;
        $careerup_certificate->parent_curriculum = $request->parent_curriculum;
        $careerup_certificate->certificate_status = 'Y';


        $data = [
            'username' => $user->name,
            'parent_curriculum' => $parent_curriculum,
        ];
        if($careerup_certificate->save()) {
            $email = new CertificateSendMail($data);
            Mail::to($user->email)->send($email);
        }

        return redirect()
                ->route('history.show',['id' => $request->user_id])
                ->with('status',$user->name.'へ【'.$parent_curriculum.'】修了証発行のメールを送信しました。');
    }

}
