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
use App\Information;
use Mail;

class PagesController extends Controller
{
    public function afterwithdrawal()
    {
        return view('afterwithdrawal');
    }

    public function index() 
    {
        $infos = Information::orderBy('article_date','desc')->limit(3)->get();        
        return view('welcome',compact('infos'));
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
                $company_name = ($company) ? $company->name : null;
                
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

    public function contact()
    {
        return view('contact');
    }

    public function comfirm(Request $request)
    {
        $this->validate($request, [
            'cname' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'cmail' => 'required|same:email',
            'comment' => 'required',
        ]);

        $contact = $request->all();

        return view('comfirm',compact('contact'));
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
        
        $contact = Contact::create($request->all());        

        // 二重送信防止
        $request->session()->regenerateToken();

        if($contact) {
            // 自動返信
            Mail::send(new \App\Mail\Contact([
                'to' => $request->email,
                'subject' => '【自動返信】お問い合わせありがとうございました。',
                'cname' => $request->cname,
                'name' => $request->name,
                'email' => $request->email,
                'comment' => $request->comment
            ]));
        
            // 管理者宛
            Mail::send(new \App\Mail\Contact([
                'to' => 'ito@mj-inc.jp',
                'subject' => '研修サイトからお問い合わせ',
                'cname' => $request->cname,
                'name' => $request->name,
                'email' => $request->email,
                'comment' => $request->comment
            ], 'from'));
        }
            
        return view('complete');
    }

}
