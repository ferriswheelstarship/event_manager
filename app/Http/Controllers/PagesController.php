<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use QrCode;
use Carbon\Carbon;
use App\User;
use App\Profile;
use App\Event;
use App\Careerup_curriculum;
use App\Event_date;
use App\Entry;
use App\Contact;
use App\Registration_request;
use App\Information;
use Mail;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class PagesController extends Controller
{
    public function afterwithdrawal()
    {
        return view('afterwithdrawal');
    }

    public function index() 
    {
        $infos = Information::orderBy('article_date','desc')->limit(3)->get();
        
        $events = Event::where('view_start_date','<=',now())
                                ->where('view_end_date','>',now())
                                ->orderBy('id', 'desc')->get();
        foreach($events as $key => $event) {
            // 申込数
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where(function($q){
                                $q->where('entry_status','Y')
                                    ->orWhere('entry_status','YC');
                            })->groupBy('user_id')->get()->count();

            // 研修受付ステータス
            $dt = Carbon::now();
            $entry_start_date = new Carbon($event['entry_start_date']);
            $entry_end_date = new Carbon($event['entry_end_date']);
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

            // 研修開催日フィルタ（開催日前日）
            $event_dates = $event->event_dates()->select('event_date')->get();

            foreach($event_dates as $i => $item) {
                $event_date = new Carbon($item->event_date);
                if($event_date >= Carbon::today()) {//開催日前（当日含む）
                    $date_frag[$key][$i] = true;
                } else {
                    $date_frag[$key][$i] = false;
                }
            }

            // 開催日前のイベントデータのみ抽出
            if(in_array(true,$date_frag[$key],true)) {
                $data[] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'status' => $status,
                    'event_dates' => $event_dates,
                    'capacity' => $event->capacity,
                    'entrys_cnt' => $entrys_cnt,
                    'deleted_at' => $event->deleted_at,
                ];
            }             
        }
        $data = isset($data) ? $data : [];
        if(count($data) > 3) {
            foreach($data as $i => $item) {
                if($i > 2) {
                    unset($data[$i]);
                }
            } 
        }
        //dd($data);


        return view('welcome',compact('infos','data'));
    }

    public function greeting()
    {
        return view('greeting');
    }

    public function links()
    {
        return view('links');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function ticket_pdf($id) 
    {
        //dd($value);
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
            // 研修開催日がいずれも過去の場合

            //dd('該当の研修は終了しています。');

            $entrys_self = Entry::where('user_id',$user_id)
                        ->where('event_id',$event_id)
                        ->where('entry_status','Y')
                        ->first();
            if(!$entrys_self && $user->role_id > 2) {// 該当研修の申込ステータス確認
                $emes = '不正なデータです。';
            }

            // 研修種別
            $careerup_curriculums = $event->careerup_curriculums;
            
            if($user->role_id < 3) { //プレビュー表示用
            
                // 受付番号
                $event_id4 = sprintf('%04d',$event_id);
                $user_id4 = sprintf('%04d',$user_id);
                $app_num = $user_id4.'-'.$event_id4.'-001';

                // 所属施設
                $company_name = null;

            } else {

                // 受付番号
                $event_id4 = sprintf('%04d',$event_id);
                $user_id4 = sprintf('%04d',$user_id);
                $serial_num4 = sprintf('%04d',$entrys_self->serial_number);
                $app_num = $user_id4.'-'.$event_id4.'-'.$serial_num4;

                // 所属施設
                $company = User::where('status',1)
                                ->where('role_id',3)
                                ->where('company_profile_id',$user->company_profile_id)
                                ->first();

                $company_name = ($company) ? $company->name : $user->profile->other_facility_name.'（'.$user->profile->other_facility_pref.'）';
                
            }

            // QRコード
            $encode = base64_encode(QrCode::format('png')->size(120)->generate($app_num));
            $qrcode = '<img src="data:image/png;base64, ' . $encode . '">';


            $data = [
                'user' => $user,
                'event' => $event,
                'event_dates' => $event_dates,
                'app_num' => $app_num,
                'company_name' => $company_name,
                'careerup_curriculums' => $careerup_curriculums,
                'qrcode' => $qrcode,
            ];

        }
        if(isset($emes)) {
            $pdf = PDF::loadView('error_pdf', compact('emes'));
        } else {
            $pdf = PDF::loadView('ticket_pdf', compact('data'));
        }
        return $pdf->stream('title.pdf');

    }

    public function info()
    {
        $infos = Information::orderBy('article_date','desc')->paginate(10);        
        return view('info.index',compact('infos'));
    }
    public function infodetail($id)
    {
        $information = Information::find($id);
        if(!$information) {
            return redirect()->route('info');
        }
        return view('info.show',compact('information'));
    }


    public function eventinfo(Request $request)
    {
        $events = Event::where('view_start_date','<=',now())
                                ->where('view_end_date','>',now())
                                ->orderBy('id', 'desc')->get();
        foreach($events as $key => $event) {
            // 申込数
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where(function($q){
                                $q->where('entry_status','Y')
                                    ->orWhere('entry_status','YC');
                            })->groupBy('user_id')->get()->count();

            // 研修受付ステータス
            $dt = Carbon::now();
            $entry_start_date = new Carbon($event['entry_start_date']);
            $entry_end_date = new Carbon($event['entry_end_date']);
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

            // 研修開催日フィルタ（開催日前日）
            $event_dates = $event->event_dates()->select('event_date')->get();

            foreach($event_dates as $i => $item) {
                $event_date = new Carbon($item->event_date);
                if($event_date >= Carbon::today()) {//開催日前（当日含む）
                    $date_frag[$key][$i] = true;
                } else {
                    $date_frag[$key][$i] = false;
                }
            }

            // 開催日前のイベントデータのみ抽出
            if(in_array(true,$date_frag[$key],true)) {
                $datas[] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'status' => $status,
                    'event_dates' => $event_dates,
                    'capacity' => $event->capacity,
                    'entrys_cnt' => $entrys_cnt,
                    'deleted_at' => $event->deleted_at,
                ];
            }             
        }
        $datas = isset($datas) ? $datas : [];
        if(count($datas) > 0) {
            $datas = collect($datas);
            $datas = new LengthAwarePaginator( //https://qiita.com/wallkickers/items/35d13a62e0d53ce05732参照
                            $datas->forPage($request->page, 10),
                            count($datas),
                            10,
                            $request->page,
                            array('path' => $request->url())
                        );
        }
        
        return view('eventinfo.index',compact('datas'));
    }
    public function eventinfodetail($id)
    {
        $event = Event::find($id);
        if(!$event) {
            return redirect()->route('eventinfo');
        }
        $event_dates = $event->event_dates;
        $careerup_curriculums = $event->careerup_curriculums;

        $general_or_carrerup = config('const.TRAINING_VARIATION');

        return view('eventinfo.show',compact('event','event_dates','careerup_curriculums','general_or_carrerup'));
    }

    
    public function contact()
    {
        $types = ['general' => '一般お問い合わせ', 'regisrration' => 'ユーザ登録にお困りの方'];
        $registration_types = ['仮登録時の返信メールが届かない','仮登録時の返信メールは届くがメールのURLにアクセスできない'];
        $solutions = ['登録代行を依頼したい','登録は自分でするので本登録URLを送ってほしい'];

        // 施設ユーザ
        $company = User::where('role_id','3')->get();

        foreach($company as $key => $item) {

            if(preg_match('/郡/',$item->address)){
                list($city,$etc) = explode("郡",$item->address);
                $city = $city."郡";
            } elseif(preg_match('/市/',$item->address)){
                list($city,$etc) = explode("市",$item->address);
                $city = $city."市";
            } elseif(preg_match('/郡/',$item->address)){
                list($city,$etc) = explode("郡",$item->address);
                $city = $city."郡";
            } else {
                $city = $item->address;
            }

            $facilites[] = [
                'company_profile_id' => $item['company_profile_id'],
                'name' => $item['name'],
                'city' => $city,
            ];
        }

        // 都道府県
        $pref = config('const.PREF');
        $pref_all = config('const.PREF_ALL');
        // 職種
        $job = config('const.JOB');
        // 保育士番号所持状況
        $childminder_status = config('const.CHILDMINDER_STATUS');
        
        return view('contact',compact('types','registration_types','solutions',
                                        'facilites','pref','pref_all','job','childminder_status'));
    }

    public function comfirm(Request $request)
    {
        $types = ['general' => '一般お問い合わせ', 'regisrration' => 'ユーザ登録にお困りの方'];

        /* validation */
        $rules = [
            'type' => [
                Rule::notIn(['0']),
            ],
        ];

        if($request->type == "general") {
            $rules += [
                'cname' => 'required|string',
                'name' => 'required|string',
                'email' => 'required|email',
                'cmail' => 'required|same:email',
                'comment' => 'required',
            ];

            $faclity = null;
            
        } elseif($request->type == "regisrration") {
            
            $rules += [
                'registration_type' => [
                    Rule::notIn(['0']),
                ],
            ];

            // if($request->registration_type == "仮登録時の返信メールが届かない") {
            //     $rules += [
            //         'solution' => [
            //             Rule::notIn(['0','登録は自分でするので本登録URLを送ってほしい']),
            //         ],
            //     ];
            // } elseif($request->registration_type == "仮登録時の返信メールは届くがメールのURLにアクセスできない") {
            //     $rules += [
            //         'solution' => [
            //             Rule::notIn(['0']),
            //         ],
            //     ];
            // }

            // if($request->solution == "登録代行を依頼したい") {
                $rules += [
                    'reg_email' => 'required|email|confirmed',
                    'password' => 'required|string|min:6',
                    'firstname' => 'required|string',
                    'lastname' => 'required|string',
                    'firstruby' => 'required|string|katakana',
                    'lastruby' => 'required|string|katakana',
                    'phone' => 'required|string',
                    'zip' => 'required|string',
                    'address' => 'required|string',
                    'birth_year' => 'not_in:0',
                    'birth_month' => 'not_in:0',
                    'birth_day' => 'not_in:0',
                    'company_profile_id' => 'not_in:0',
                    'job' => 'not_in:0'
                ];

                if($request->company_profile_id === "なし") {
                    $rules += [            
                        'other_facility_name' => 'required|string',
                        'other_facility_pref' => 'not_in:0',
                        'other_facility_address' => 'required|string'
                    ];
                }

                if($request->job === config('const.JOB.0')) {//「保育士・保育教諭」の場合
                    $rules += [
                        'childminder_status' => 'not_in:0'
                    ];
                    
                    if($request->childminder_status == config('const.CHILDMINDER_STATUS.0')) {// 保育士番号ありの場合
                        $rules += [
                            'childminder_number_pref' => 'not_in:0',
                            'childminder_number_only' => 'required|alpha_num|digits:6'
                        ];
                    }
                            
                }

            // } elseif($request->solution == "登録は自分でするので本登録URLを送ってほしい") {
            //     $rules = [
            //         'self_email' => 'required|string|email|max:191|confirmed',
            //     ];
            // }
            
        }
        $request->validate($rules);


        if($request->type == "regisrration") {
            if($request->company_profile_id != "なし") {
                // 施設ユーザ
                $company = User::where('company_profile_id',$request->company_profile_id)->first();
                if(preg_match('/郡/',$company->address)){
                    list($city,$etc) = explode("郡",$company->address);
                    $city = $city."郡";
                } elseif(preg_match('/市/',$company->address)){
                    list($city,$etc) = explode("市",$company->address);
                    $city = $city."市";
                } else {
                    $city = $item->address;
                }
                $facility = "【". $city ."】".$company->name;

            } else {
                $facility = $request->other_facility_name;
            }
        } else {
            $facility = null;
        }

        $contact = $request->all();
        //dd($contact);

        return view('comfirm',compact('contact','types','facility'));
    }

    public function complete(Request $request)
    {

        $input = $request->except('action');
        
        if($request->action === '戻る') {
            return redirect()->route('contact')->withInput($input);
        }

        if(!isset($input['_token'])){
            return redirect()->route('contact');
        }
        
        // 二重送信防止
        $request->session()->regenerateToken();

        //dd($input,$request);

        if($request->type == "general") {
            $contact = Contact::create($request->all());

            $to_content = [
                'to' => $request->email,
                'subject' => '【自動返信】お問い合わせありがとうございました。',
                'type' => $request->type,
                'cname' => $request->cname,
                'name' => $request->name,
                'email' => $request->email,
                'comment' => $request->comment
            ];
            $from_content = [
                //'to' => 'ito@mj-inc.jp',
                'to' => 'hokyo@fancy.ocn.ne.jp',
                'subject' => '研修サイトからお問い合わせ',
                'type' => $request->type,
                'cname' => $request->cname,
                'name' => $request->name,
                'email' => $request->email,
                'comment' => $request->comment
            ];

            if($contact) {
                // 自動返信
                Mail::send(new \App\Mail\Contact($to_content));
            
                // 管理者宛
                Mail::send(new \App\Mail\Contact($from_content,'from'));
            }

        } elseif($request->type == "regisrration") {
            $contact = Registration_request::create($request->all());

            $to_content = [
                'to' => $request->reg_email,
                'subject' => '【自動返信】ユーザ登録代行を承りました。',
                'type' => $request->type,
                'registration_type' => $request->registration_type,
                'reg_email' => $request->reg_email,
                'password' => $request->password,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'firstruby' => $request->firstruby,
                'lastruby' => $request->lastruby,
                'phone' => $request->phone,
                'zip' => $request->zip,
                'address' => $request->address,
                'birth_year' => $request->birth_year,
                'birth_month' => $request->birth_month,
                'birth_day' => $request->birth_day,
                'facility' => $request->facility,
                'company_profile_id' => $request->company_profile_id,
                'other_facility_name' => $request->other_facility_name,
                'other_facility_pref' => $request->other_facility_pref,
                'other_facility_address' => $request->other_facility_address,
                'job' => $request->job,
                'childminder_status' => $request->childminder_status,
                'childminder_number_pref' => $request->childminder_number_pref,
                'childminder_number_only' => $request->childminder_number_only,
            ];
            $from_content = [
                //'to' => 'ito@mj-inc.jp',
                'to' => 'hokyo@fancy.ocn.ne.jp',
                'subject' => '研修サイトからユーザ登録代行依頼',
                'type' => $request->type,
                'registration_type' => $request->registration_type,
                'reg_email' => $request->reg_email,
                'password' => $request->password,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'firstruby' => $request->firstruby,
                'lastruby' => $request->lastruby,
                'phone' => $request->phone,
                'zip' => $request->zip,
                'address' => $request->address,
                'birth_year' => $request->birth_year,
                'birth_month' => $request->birth_month,
                'birth_day' => $request->birth_day,
                'facility' => $request->facility,
                'company_profile_id' => $request->company_profile_id,
                'other_facility_name' => $request->other_facility_name,
                'other_facility_pref' => $request->other_facility_pref,
                'other_facility_address' => $request->other_facility_address,
                'job' => $request->job,
                'childminder_status' => $request->childminder_status,
                'childminder_number_pref' => $request->childminder_number_pref,
                'childminder_number_only' => $request->childminder_number_only,
            ];

            if($contact) {
                // 自動返信
                Mail::send(new \App\Mail\Registration_request($to_content));
            
                // 管理者宛
                Mail::send(new \App\Mail\Registration_request($from_content,'from'));
            }

        }

            
        return view('complete');
    }

}
