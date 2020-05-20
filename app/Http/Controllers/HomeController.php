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
use App\Information;
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
            $event_data_cnt = false;
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
        } else {
            
            $infos = Information::orderBy('article_date','desc')
                                    ->limit(10)
                                    ->get();
            $data['infos'] = $infos;

            if(Gate::allows('user-only')) { //個人ユーザ用

                // 開催間近の研修（受講券発行済）
                $entry_ticket_sended = Entry::select('event_id','user_id')
                                        ->where('user_id',Auth::id())
                                        ->where('entry_status','Y')
                                        ->where('ticket_status','Y')
                                        ->groupBy('event_id', 'user_id')->get();

                $event_ticket_sended_data_cnt = false;
                foreach($entry_ticket_sended as $entry) {

                    $event = Event::find($entry['event_id']);

                    // 研修開催日
                    $dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                    $dt7daysafter = $dt->addDays(14);
                    $nowdt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                    $event_dates = $event->event_dates()->get();

                    foreach($event_dates as $i => $date) {
                        $event_date = new Carbon($date['event_date']);
                        if($nowdt <= $event_date && $dt7daysafter >= $event_date) {// 研修開催日が現在から2週間以内であれば
                            $data_event_ticket_sended[] = [
                                'event_id' => $event->id,
                                'event_date_id' => $date['id'],
                                'title' => $event->title,
                                'event_date' => $event_date,                        
                            ];
                            $event_ticket_sended_data_cnt = true;
                        }
                    }
                }
                $data['event_ticket_sended'] = 
                    ($event_ticket_sended_data_cnt === true) 
                        ? HomeController::getUniqueArray($data_event_ticket_sended,'event_date') : [];


                // 開催間近の研修（受講券未発行）
                $entry_ticket_none = Entry::select('event_id','user_id')
                                        ->where('user_id',Auth::id())
                                        ->where('entry_status','Y')
                                        ->where('ticket_status','N')
                                        ->groupBy('event_id', 'user_id')->get();

                $event_ticket_none_data_cnt = false;
                foreach($entry_ticket_none as $entry) {
                    
                    $event = Event::find($entry['event_id']);

                    // 研修開催日
                    $current_dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                    $current_dt7daysafter = $current_dt->addDays(14);
                    $now_dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                    $event_dates = $event->event_dates()->get();
                                
                    foreach($event_dates as $date) {
                        $event_date = new Carbon($date['event_date']);
                        if($now_dt <= $event_date && $current_dt7daysafter >= $event_date) {// 研修開催日が現在から2週間以内であれば
                            $data_event_ticket_none[] = [
                                'event_id' => $event->id,
                                'event_date_id' => $date['id'],
                                'title' => $event->title,
                                'event_date' => $event_date,                        
                            ];
                            $event_ticket_none_data_cnt = true;
                        }
                    }
                }
                $data['event_ticket_none'] = 
                    ($event_ticket_none_data_cnt === true) 
                        ? $data_event_ticket_none : [];

            } elseif(Gate::allows('admin-only')) {

                // 所属ユーザ
                $belonging_users = User::where('status',1)
                                ->where('role_id',4)
                                ->where('company_profile_id',$user->company_profile_id)
                                ->orderBy('id', 'desc')
                                ->get();
                foreach($belonging_users as $item) {
                    $belonging_users_ids[] = $item->id;                    
                }
                //dd($belonging_users_ids);

                // 開催間近の研修（受講券発行済）
                foreach($belonging_users_ids as $i => $belonging_users_id) {
                    $entry_ticket_sended = Entry::select('event_id','user_id')
                                            ->where('user_id',$belonging_users_id)
                                            ->where('entry_status','Y')
                                            ->where('ticket_status','Y')
                                            ->groupBy('event_id', 'user_id')->get();

                    $event_ticket_sended_data_cnt = false;
                    foreach($entry_ticket_sended as $j => $entry) {

                        $event = Event::find($entry['event_id']);

                        // 研修開催日
                        $dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                        $dt7daysafter = $dt->addDays(80);
                        $nowdt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                        $event_dates = $event->event_dates()->get();

                        foreach($event_dates as $date) {
                            $event_date = new Carbon($date['event_date']);
                            if($nowdt <= $event_date && $dt7daysafter >= $event_date) {// 研修開催日が現在から2週間以内であれば
                                $data_event_ticket_sended[$j] = [
                                    'event_id' => $event->id,
                                    'event_date_id' => $date['id'],
                                    'title' => $event->title,
                                    'event_date' => $event_date,                        
                                ];
                                $event_ticket_sended_data_cnt = true;
                            }
                        }
                    }
                    $data['event_ticket_sended'] = 
                        ($event_ticket_sended_data_cnt === true) 
                            ? $this->getUniqueArray($data_event_ticket_sended,'event_date') : [];
                }


                // 開催間近の研修（受講券未発行）
                foreach($belonging_users_ids as $i => $belonging_users_id) {
                    $entry_ticket_none = Entry::select('event_id','user_id')
                                            ->where('user_id',$belonging_users_id)
                                            ->where('entry_status','Y')
                                            ->where('ticket_status','N')
                                            ->groupBy('event_id', 'user_id')->get();

                    $event_ticket_none_data_cnt = false;
                    foreach($entry_ticket_none as $j => $entry) {
                        
                        $event = Event::find($entry['event_id']);

                        // 研修開催日
                        $current_dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                        $current_dt7daysafter = $current_dt->addDays(80);
                        $now_dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                        $event_dates = $event->event_dates()->get();
                                    
                        foreach($event_dates as $date) {
                            $event_date = new Carbon($date['event_date']);
                            if($now_dt <= $event_date && $current_dt7daysafter >= $event_date) {// 研修開催日が現在から2週間以内であれば
                                $data_event_ticket_none[$j] = [
                                    'event_id' => $event->id,
                                    'event_date_id' => $date['id'],
                                    'title' => $event->title,
                                    'event_date' => $event_date,                        
                                ];
                                $event_ticket_none_data_cnt = true;
                            }
                        }
                    }
                    $data['event_ticket_none'] = 
                        ($event_ticket_none_data_cnt === true) 
                            ? $this->getUniqueArray($data_event_ticket_none,'event_date') : [];
                }

            }
        }


        return view('home',compact('authlevel','data'));
    }

    public static function getUniqueArray($array, $column)
    {   
        $tmp = []; 
        $uniqueArray = []; 
        foreach ($array as $value){
            if (!in_array($value[$column], $tmp)) {
                $tmp[] = $value[$column];
                $uniqueArray[] = $value;
            }   
        }   
        return $uniqueArray;    
    }   
}
