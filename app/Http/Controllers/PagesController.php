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

class PagesController extends Controller
{
    public function afterwithdrawal()
    {
        return view('afterwithdrawal');
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
            dd('不正なデータです。');
        } else {
            list($user_id,$event_id) = explode('-',$id);

            $user = User::find($user_id);
            $event = Event::find($event_id);

            if(!$user || !$event) { //ユーザ、研修
                dd('不正なデータです。');
            } else {
                if($user->deleted_at) {
                    dd('退会しているため、受講券を表示できません。');
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
                dd('不正なデータです。');
            }


            // 研修種別
            $careerup_curriculums = $event->careerup_curriculum;
            
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

        $pdf = PDF::loadView('ticket_pdf', compact('data'));
        return $pdf->stream('title.pdf');
    }

    public function info()
    {
        return view('info');
    }

    public function contact()
    {
        return view('contact');
    }

}
