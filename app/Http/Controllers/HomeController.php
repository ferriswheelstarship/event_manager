<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Gate;
use Validator;
use Carbon\Carbon;
use App\Event;
use App\User;
use App\Role;
use App\Profile;
use App\Careerup_curriculum;
use App\Event_date;
use App\Entry;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        $authlevel = Role::find($user->role_id)->level;
        
        $data = [];
        if(Gate::allows('area-higher')) { //支部、特権ユーザ用
            $data['company_users_cnt'] = User::where('status',1)
                            ->where('role_id',3)
                            ->get()
                            ->count();

            $data['company_users_later'] = User::where('status',1)
                            ->where('role_id',3)
                            ->orderBy('created_at', 'desc')
                            ->limit(3)
                            ->get();

            $data['general_users_cnt'] = User::where('status',1)
                            ->where('role_id',4)
                            ->get()
                            ->count();

            $data['general_users_later'] = User::where('status',1)
                            ->where('role_id',4)
                            ->orderBy('created_at', 'desc')
                            ->limit(3)
                            ->get();

            // 開催間近の研修
            $events = Event::orderBy('id', 'desc')->get();
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
                        $event_data[] = [
                            'event_id' => $event->id,
                            'event_date_id' => $date['id'],
                            'title' => $event->title,
                            'entry_end_date' => $event->entry_end_date,
                            'event_date' => $event_date,                        
                            'entrys_cnt' => $entrys_cnt,
                            'reception_cnt' => $reception_cnt,
                        ];
                        $event_data_cnt = true;
                    }
                }
            }
            $data['event'] = ($event_data_cnt === true) ? $event_data : [];
            //dd($data['event']);
        }


        if(Gate::allows('user-only')) { //個人ユーザ用
        
        }


        return view('home',compact('authlevel','data'));
    }


}
