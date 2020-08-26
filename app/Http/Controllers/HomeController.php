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
use App\Updated_history;

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
        $updated_item_arr = config('const.UPDATED_ITEM');
        
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
                            ->whereNotNull('name')
                            ->get()
                            ->count();

            $data['general_users_later'] = User::where('status',1)
                            ->where('role_id',4)
                            ->whereNotNull('name')
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

            
            //法人ユーザ更新情報（直近一週間分）
            $to = Carbon::now();
            $from = Carbon::now()->subDay(7);

            $data['updated_history'] = Updated_history::distinct()
                                            ->select('history_group_id','user_id','created_at')
                                            ->whereBetween('created_at', [$from, $to])
                                            ->latest('created_at')
                                            ->get();

            if(count($data['updated_history']) > 0 ) {
                foreach($data['updated_history'] as $key => $item) {
                    $data['updated_history'][$key]['mixed_history'] = 
                        Updated_history::where('history_group_id',$item['history_group_id'])
                                            ->get();
                }
            }


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

                $data_event_ticket_sended = [];
                foreach($entry_ticket_sended as $i => $entry) {

                    $event = Event::find($entry['event_id']);

                    // 研修開催日
                    $dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                    $dt7daysafter = $dt->addDays(14);
                    $nowdt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                    $event_dates = $event->event_dates()->get();

                    foreach($event_dates as $j => $date) {
                        $event_date = new Carbon($date['event_date']);
                        if($nowdt <= $event_date && $dt7daysafter >= $event_date) {// 研修開催日が現在から2週間以内であれば
                            $data_event_ticket_sended[$i][$j] = [
                                'event_id' => $event->id,
                                'event_date_id' => $date['id'],
                                'title' => $event->title,
                                'event_date' => $event_date,                        
                            ];
                        }
                    }
                }
                $data['event_ticket_sended'] = 
                    (count($data_event_ticket_sended) > 0) 
                        ? $this->getUniqueArray($data_event_ticket_sended,'event_date') : [];


                // 開催間近の研修（受講券未発行）
                $entry_ticket_none = Entry::select('event_id','user_id')
                                        ->where('user_id',Auth::id())
                                        ->where('entry_status','Y')
                                        ->where('ticket_status','N')
                                        ->groupBy('event_id', 'user_id')->get();

                $data_event_ticket_none = [];
                foreach($entry_ticket_none as $i => $entry) {
                    
                    $event = Event::find($entry['event_id']);

                    // 研修開催日
                    $current_dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                    $current_dt7daysafter = $current_dt->addDays(14);
                    $now_dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                    $event_dates = $event->event_dates()->get();
                                
                    foreach($event_dates as $j => $date) {
                        $event_date = new Carbon($date['event_date']);
                        if($now_dt <= $event_date && $current_dt7daysafter >= $event_date) {// 研修開催日が現在から2週間以内であれば
                            $data_event_ticket_none[$i][$j] = [
                                'event_id' => $event->id,
                                'event_date_id' => $date['id'],
                                'title' => $event->title,
                                'event_date' => $event_date,                        
                            ];
                        }
                    }
                }
                $data['event_ticket_none'] = 
                    (count($data_event_ticket_none) > 0) 
                        ? $this->getUniqueArray($data_event_ticket_none,'event_date') : [];

            } elseif(Gate::allows('admin-only')) {

                $belonging_users_ids = null;

                // 所属ユーザ
                $belonging_users = User::where('status',1)
                                ->where('role_id',4)
                                ->where('company_profile_id',$user->company_profile_id)
                                ->orderBy('id', 'desc')
                                ->get();
                foreach($belonging_users as $item) {
                    $belonging_users_ids[] = $item->id;                    
                }

                if(isset($belonging_users_ids) && count($belonging_users_ids) > 0) {

                    // 開催間近の研修（受講券発行済）
                    $data_event_ticket_sended = [];
                    
                    foreach($belonging_users_ids as $belonging_users_id) {
                        $entry_ticket_sended = Entry::select('event_id','user_id')
                                                ->where('user_id',$belonging_users_id)
                                                ->where('entry_status','Y')
                                                ->where('ticket_status','Y')
                                                ->groupBy('event_id', 'user_id')->get();

                        foreach($entry_ticket_sended as $i => $entry) {

                            $event = Event::find($entry['event_id']);

                            // 研修開催日
                            $dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                            $dt7daysafter = $dt->addDays(14);
                            $nowdt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                            $event_dates = ($event) ? $event->event_dates()->get() : null;

                            if($event_dates) {
                                foreach($event_dates as $j => $date) {
                                    $event_date = new Carbon($date['event_date']);
                                    if($nowdt <= $event_date && $dt7daysafter >= $event_date) {// 研修開催日が現在から2週間以内であれば
                                        $data_event_ticket_sended[$i][$j] = [
                                            'event_id' => $event->id,
                                            'event_date_id' => $date['id'],
                                            'title' => $event->title,
                                            'event_date' => $event_date,                        
                                        ];
                                    }
                                }
                            } 
                        }
                    }
                    $data['event_ticket_sended'] = 
                        (count($data_event_ticket_sended) > 0) 
                            ? $this->getUniqueArray($data_event_ticket_sended,'event_date') : [];

                    // 開催間近の研修（受講券未発行）
                    $data_event_ticket_none = [];
                    foreach($belonging_users_ids as $belonging_users_id) {
                        $entry_ticket_none = Entry::select('event_id','user_id')
                                                ->where('user_id',$belonging_users_id)
                                                ->where('entry_status','Y')
                                                ->where('ticket_status','N')
                                                ->groupBy('event_id', 'user_id')->get();
                                                
                        foreach($entry_ticket_none as $i => $entry) {
                            
                            $event = Event::find($entry['event_id']);

                            // 研修開催日
                            $current_dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                            $current_dt7daysafter = $current_dt->addDays(14);
                            $now_dt = new Carbon(date('Y').'-'.date('m').'-'.date('d'));
                            $event_dates = ($event) ? $event->event_dates()->get() : null;
                            
                            if($event_dates) {
                                foreach($event_dates as $j => $date) {
                                    $event_date = new Carbon($date['event_date']);
                                    if($now_dt <= $event_date && $current_dt7daysafter >= $event_date) {// 研修開催日が現在から2週間以内であれば
                                        $data_event_ticket_none[$i][$j] = [
                                            'event_id' => $event->id,
                                            'event_date_id' => $date['id'],
                                            'title' => $event->title,
                                            'event_date' => $event_date,                        
                                        ];
                                    }
                                }
                            }
                        }
                    }
                    $data['event_ticket_none'] = 
                        (count($data_event_ticket_none) > 0) 
                            ? $this->getUniqueArray($data_event_ticket_none,'event_date') : [];

                } else {
                    $data['event_ticket_sended'] = [];
                    $data['event_ticket_none'] = [];
                }

            }
            //dd($data_event_ticket_sended,$data['event_ticket_sended']);
            //dd($data_event_ticket_none,$data['event_ticket_none']);
        }

        return view('home',compact('authlevel','data','updated_item_arr'));
    }

    public static function getUniqueArray($array, $column)
    {   
        $tmp = []; 
        $uniqueArray = []; 
        foreach ($array as $i => $item){
            foreach($item as $value) {
                $tmp[] = $value[$column];
                $uniqueArray[$i] = $value;
            }
        }   
        return $uniqueArray;
    }   
}
