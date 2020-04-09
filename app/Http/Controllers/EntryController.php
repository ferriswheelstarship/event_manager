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
                    $status = "キャンセル待申込のみ可";
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

        // 申込完了者
        $entrys_y = Entry::where('event_id',$id)
                        ->where('entry_status','Y')
                        ->distinct('user_id')
                        ->get();
        //dd($entrys_y);

        if($entrys_y->count() > 0){
            foreach($entrys_y as $entry) {
                
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
                if($entry['ticket_status'] == 'Y') {
                    $status = "受講券発行済";
                } else {
                    $status = "未入金";
                }

                $entrys_y_view[] = [
                    'user_id' => $entry['user_id'],
                    'user_name' => $user->name,
                    'user_ruby' => $user->ruby,
                    'company_name' => $company_name,
                    'created' => $entry['created_at'],
                    'status' => $status,
                ];
            }
        } else {
            $entrys_y_view = [];
        }

        // 申込後キャンセル者
        $entrys_yc = Entry::distinct('user_id')
                        ->where('event_id',$id)
                        ->where('entry_status','YC')
                        ->get();
        
        if($entrys_yc->count() > 0){
            foreach($entrys_yc as $entry) {
                
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
                if($entry['ticket_status'] == 'Y') {
                    $status = "受講券発行済";
                } else {
                    $status = "未入金";
                }

                $entrys_yc_view[] = [
                    'user_id' => $entry['user_id'],
                    'user_name' => $user->name,
                    'user_ruby' => $user->ruby,
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
        $entrys_cw = Entry::distinct('user_id')
                        ->where('event_id',$id)
                        ->where('entry_status','CW')
                        ->get();

        if($entrys_cw->count() > 0){
            foreach($entrys_cw as $entry_cw) {
                
                // ユーザ名
                $user = User::find($entry_cw->user_id);
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
                    'general_or_carrerup',
                    'entrys_y_view','entrys_yc_view','entrys_cw_view'
                ));
    }
}
