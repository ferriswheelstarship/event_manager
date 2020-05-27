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
use App\Mail\ApplyConfirmMail;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

            // 研修のステータス
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

            if(Gate::allows('user-only')) {
                $entry = Entry::where('event_id',$event->id)
                                ->where('user_id',$user_self->id)
                                ->first();
                if(!$entry) {
                    $entry_status = "申込なし";
                } else {
                    if($entry->ticket_status == 'Y') {
                        $entry_status = "受講券発行済";
                    } else {
                        if($entry->entry_status == 'Y') {
                            $entry_status = "受講券発行待ち ";
                        } elseif($entry->entry_status == 'YC') {
                            $entry_status = "申込後キャンセル";
                        } elseif($entry->entry_status == 'CW') {
                            $entry_status = "キャンセル待ち申込";
                        } else {
                            $entry_status = "申込なし";
                        }
                    }
                }
            } else {
                $entry_status = null;
            }
                            
            //
            $data[] = [
                'id' => $event->id,
                'title' => $event->title,
                'status' => $status,
                'entry_status' => $entry_status,
                'event_dates' => $event->event_dates()->select('event_date')->get(),
                'capacity' => $event->capacity,
                'entrys_cnt' => $entrys_cnt,
                'deleted_at' => $event->deleted_at,
            ];
        }

        return view('event.index',compact('events','data'));
    }

    public function before()
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

        foreach($events as $key => $event) {

            // 申込数
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where(function($q){
                                $q->where('entry_status','Y')
                                    ->orWhere('entry_status','YC');
                            })->groupBy('user_id')->get()->count();

            // 研修受付ステータス
            $dt = Carbon::today();
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

            // 申込ステータス（個人ユーザのみ）       
            if(Gate::allows('user-only')) {
                $entry = Entry::where('event_id',$event->id)
                                ->where('user_id',$user_self->id)
                                ->first();
                if(!$entry) {
                    $entry_status = "申込なし";
                } else {
                    if($entry->ticket_status == 'Y') {
                        $entry_status = "受講券発行済";
                    } else {
                        if($entry->entry_status == 'Y') {
                            $entry_status = "受講券発行待ち";
                        } elseif($entry->entry_status == 'YC') {
                            $entry_status = "申込後キャンセル";
                        } elseif($entry->entry_status == 'CW') {
                            $entry_status = "キャンセル待ち申込";
                        } else {
                            $entry_status = "申込なし";
                        }
                    }
                }
            } else {
                $entry_status = null;
            }
            
            // 研修開催日フィルタ（開催日前日）
            $event_dates = $event->event_dates()->select('event_date')->get();

            foreach($event_dates as $i => $item) {
                $event_date = new Carbon($item->event_date);
                if($event_date > $dt) {//開催日前
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
                    'entry_status' => $entry_status,
                    'event_dates' => $event_dates,
                    'capacity' => $event->capacity,
                    'entrys_cnt' => $entrys_cnt,
                    'deleted_at' => $event->deleted_at,
                ];
            } 
        }
        $data = isset($data) ? $data : null;

        return view('event.before',compact('events','data'));
    }

    public function finished()
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

        foreach($events as $key => $event) {

            // 申込数
            $entrys_cnt = Entry::select('user_id')
                            ->where('event_id',$event['id'])
                            ->where(function($q){
                                $q->where('entry_status','Y')
                                    ->orWhere('entry_status','YC');
                            })->groupBy('user_id')->get()->count();

            // 申込ステータス（個人ユーザのみ）       
            if(Gate::allows('user-only')) {
                $entry = Entry::where('event_id',$event->id)
                                ->where('user_id',$user_self->id)
                                ->first();
                if(!$entry) {
                    $entry_status = "申込なし";
                } else {
                    if($entry->attend_status == 'Y') {
                        $entry_status = "参加済（参加中）";
                    } else {
                        $entry_status = "不参加";
                    }
                }
            } else {
                $entry_status = null;
            }
            
            // 研修開催日フィルタ（修了分）
            $dt = Carbon::today();
            $event_dates = $event->event_dates()->select('event_date')->get();
            foreach($event_dates as $i => $item) {
                $event_date = new Carbon($item->event_date);
                if($event_date->addDay() < $dt) {//開催日翌日より後
                    $date_frag[$key][$i] = true;                     
                } else {
                    $date_frag[$key][$i] = null;
                }
            }

            $datepassedfrag = false;
            // 開催日経過確認（1研修）
            if(count($event_dates) > 0) {
                foreach($event_dates as $event_date) {
                    if($event_date->event_date < $dt) {
                        $applyfrag = false;
                        $datepassedfrag = true;
                        break;
                    }
                }
            }

            // 開催日翌日以降のイベントデータのみ抽出
            if(in_array(true,$date_frag[$key],true)) {
                $data[] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'entry_status' => $entry_status,
                    'event_dates' => $event_dates,
                    'capacity' => $event->capacity,
                    'entrys_cnt' => $entrys_cnt,
                    'deleted_at' => $event->deleted_at,
                ];
            }

        }
        $data = isset($data) ? $data : null;

        return view('event.finished',compact('events','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }
        
        $general_or_carrerup = config('const.TRAINING_VARIATION');
        $parent_curriculum = config('const.PARENT_CURRICULUM');
        $child_curriculum = config('const.CHILD_CURRICULUM');

        return view('event.create',compact('general_or_carrerup','parent_curriculum','child_curriculum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }

        $rules = [
            'general_or_carrerup' => 'required|string',
            'title' => 'required|string',
            'comment' => 'required|string',
            'event_dates' => 'required|array',
            'event_dates.*' => 'required|date_format:Y-m-d',
            'entry_start_date' => 'required|date_format:Y-m-d H:i',
            'entry_end_date' => 'required|date_format:Y-m-d H:i|after:entry_start_date',
            'view_start_date' => 'required|date_format:Y-m-d H:i',
            'view_end_date' => 'required|date_format:Y-m-d H:i|after:view_start_date|after:entry_end_date',
            'capacity' => 'required',
            'place' => 'required|string',
            'notice' => 'nullable',
            'files.*' => 'nullable|file|mimes:pdf',
        ];

        if($request->general_or_carrerup == 'carrerup') {
            $rules += [
                'carrerup.parent_curriculum' => 'required|array',
                'carrerup.child_curriculum' => 'required|array',
                'carrerup.training_minute' => 'required|array',
                'carrerup.parent_curriculum.*' => 'required',
                'carrerup.child_curriculum.*' => 'required',
                'carrerup.training_minute.*' => 'required|alpha_num',
            ];

        } elseif($request->general_or_carrerup == 'general') {
            $rules += [
                'training_minute' => 'required|alpha_num',
            ];
        }        
        //dd($request);
        $request->validate($rules);


        // event
        $event = New Event;
        $event->user_id = $request->user()->id;
        $event->view_start_date = $request->view_start_date.":00";
        $event->view_end_date = $request->view_end_date.":00";
        $event->entry_start_date = $request->entry_start_date.":00";
        $event->entry_end_date = $request->entry_end_date.":00";
        if($request->general_or_carrerup == 'general') {
            $event->training_minute = $request->training_minute;
        }
        $event->fill($request->all())->save();

        // careerup_curriculum
        if($request->general_or_carrerup == 'carrerup') {
            $data = [];
            foreach ($request['carrerup'] as $key => $item) {
                foreach($item as $i => $val) {
                    $data[$i][$key] = $val;
                }
            }
            foreach ($data as $key => $val) {
                $event->careerup_curriculums()->create([
                    'parent_curriculum' => $val['parent_curriculum'],
                    'child_curriculum' => $val['child_curriculum'],
                    'training_minute' => $val['training_minute'],
                ]);
            }
        }

        // event_dates（開催日）
        foreach ($request->event_dates as $val) {
            $event->event_dates()->create(['event_date' => $val." 00:00:00"]);
        }

        // event_uploads（アップロード）
        if($request->file('files')){
            foreach ($request->file('files') as $index=> $e) {
                $path = $e->store('public/event');
                $event->event_uploads()->create(['path'=> basename($path)]);
            }
        }

        return redirect()->route('event.index')->with('status','研修の登録が完了しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        if($event->id) {
            $careerup_curriculums = $event->careerup_curriculums;
            $event_dates = $event->event_dates;
            $event_uploads = $event->event_uploads;
        } else {
            $careerup_curriculums = null;
            $event_dates = null;
            $event_uploads = null;
        }
        $general_or_carrerup = config('const.TRAINING_VARIATION');

        $entrys_cnt = Entry::select('user_id')
                        ->where('event_id',$id)
                        ->where(function($q){
                            $q->where('entry_status','Y')
                                ->orWhere('entry_status','YC');
                        })->groupBy('user_id')->get()->count();

        $entrys_self = Entry::where('user_id',Auth::id())
                        ->where('event_id',$id)
                        ->where('entry_status','Y')
                        ->first();

        $entrys_self_YC = Entry::where('user_id',Auth::id())
                        ->where('event_id',$id)
                        ->where('entry_status','YC')
                        ->first();
                        
        $entrys_self_CW = Entry::where('user_id',Auth::id())
                        ->where('event_id',$id)
                        ->where('entry_status','CW')
                        ->first();

        if(Gate::allows('admin-only')) { // 法人ユーザのみ所属ユーザ取得

            $user_self = User::find(Auth::id());

            $users = User::where('status',1)
                            ->where('role_id',4)
                            ->where('company_profile_id',$user_self->company_profile_id)
                            ->orderBy('id', 'desc')
                            ->get();

            foreach($users as $user) {
                $entry = Entry::where('event_id',$id)
                                ->where('user_id',$user->id)
                                ->first();
                if(!$entry) {
                    $entry_status = "申込なし";
                } else {
                    if($entry->ticket_status == 'Y') {
                        $entry_status = "受講券発行済";
                    } else {
                        if($entry->entry_status == 'Y') {
                            $entry_status = "受講券発行待ち";
                        } elseif($entry->entry_status == 'YC') {
                            $entry_status = "申込後キャンセル";
                        } elseif($entry->entry_status == 'CW') {
                            $entry_status = "キャンセル待ち申込";
                        } else {
                            $entry_status = "申込なし";
                        }
                    }
                }

                $datas[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'entry_status' => $entry_status,
                ];
            }
        
        } else {
            $datas = null;
        }

        // 申込可否フラグ
        $applyfrag = true;
        $status_mes = null;

        $dt = Carbon::today();
        $entry_start_date = new Carbon($event->entry_start_date);
        $entry_end_date = new Carbon($event->entry_end_date);
        if($entry_start_date > $dt || $entry_end_date < $dt){ // 申込期間外の場合
            $applyfrag = false;
        }
        if($entry_start_date > $dt){
            $status_mes = "申込受付開始前のため申込できません。";
        } elseif($entry_end_date < $dt) {
            $status_mes = "申込受付が終了したため申込できません。";
        }

        $datepassedfrag = false;
        // 開催日経過確認（1研修）
        if(count($event_dates) > 0) {
            foreach($event_dates as $event_date) {
                if($event_date->event_date < $dt) {
                    $applyfrag = false;
                    $datepassedfrag = true;
                    break;
                }
            }
        } 

        // 通常申込 or キャンセル待ち申込み判定
        if($event->capacity == $entrys_cnt){// 申込数が定員に達した場合
            if($entrys_self || $entrys_self_YC || $entrys_self_CW) {
                $capacity_status = null;
            } else {
                $capacity_status = "当研修は申込定員に達したためキャンセル待ちでの申込となります。";
            }
        } else {
            $capacity_status = null;
        }
        
        return view('event.show',
                compact(
                    'event','careerup_curriculums','event_dates','event_uploads','general_or_carrerup',
                    'entrys_cnt','entrys_self','entrys_self_YC','entrys_self_CW','applyfrag','datepassedfrag','status_mes','capacity_status',
                    'datas'
                ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }

        $event = Event::find($id);
        if($event->id) {
            $careerup_curriculums = $event->careerup_curriculums;
            $event_dates = $event->event_dates;
            $event_uploads = $event->event_uploads;
        } else {
            $careerup_curriculums = null;
            $event_dates = null;
            $event_uploads = null;
        }

        $general_or_carrerup = config('const.TRAINING_VARIATION');
        $parent_curriculum = config('const.PARENT_CURRICULUM');
        $child_curriculum = config('const.CHILD_CURRICULUM');

        return view('event.edit',compact('event','careerup_curriculums','event_dates','event_uploads','general_or_carrerup','parent_curriculum','child_curriculum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }

        $rules = [
            'general_or_carrerup' => 'required|string',
            'title' => 'required|string',
            'comment' => 'required|string',
            'event_dates' => 'required|array',
            'event_dates.*' => 'required|date_format:Y-m-d',
            'entry_start_date' => 'required|date_format:Y-m-d H:i',
            'entry_end_date' => 'required|date_format:Y-m-d H:i|after:entry_start_date',
            'view_start_date' => 'required|date_format:Y-m-d H:i',
            'view_end_date' => 'required|date_format:Y-m-d H:i|after:view_start_date|after:entry_end_date',
            'capacity' => 'required',
            'place' => 'required|string',
            'notice' => 'nullable',
            'files.*' => 'nullable|file|mimes:pdf',
        ];

        if($request->general_or_carrerup == 'carrerup') {
            $rules += [
                'carrerup.parent_curriculum' => 'required|array',
                'carrerup.child_curriculum' => 'required|array',
                'carrerup.training_minute' => 'required|array',
                'carrerup.parent_curriculum.*' => 'required',
                'carrerup.child_curriculum.*' => 'required',
                'carrerup.training_minute.*' => 'required|alpha_num',
            ];

        } elseif($request->general_or_carrerup == 'general') {
            $rules += [
                'training_minute' => 'required|alpha_num',
            ];
        }
        $request->validate($rules);

        // event
        $event = Event::find($id);

        // 申込者がすでにいる場合、研修開催日の増減は不可
        $entrys_cnt = Entry::select('user_id')
                        ->where('event_id',$id)
                        ->where(function($q){
                            $q->where('entry_status','Y')
                                ->orWhere('entry_status','YC');
                        })->groupBy('user_id')->get()->count();
        if($entrys_cnt > 0) {
            if(count($request->event_dates) != $event->event_dates()->count() ) {
                return redirect()->route('event.edit',['id' => $id])->with('attention', '申込者がすでにいるため、「研修開催日」の増減はできません。');
            }
        }

        // event
        $event->user_id = $request->user()->id;
        $event->view_start_date = $request->view_start_date.":00";
        $event->view_end_date = $request->view_end_date.":00";
        $event->entry_start_date = $request->entry_start_date.":00";
        $event->entry_end_date = $request->entry_end_date.":00";
        $event->general_or_carrerup = $request->general_or_carrerup;
        $event->title = $request->title;
        $event->comment = $request->comment;
        $event->capacity = $request->capacity;
        $event->place = $request->place;
        $event->notice = $request->notice;
        if($request->general_or_carrerup == 'general') {
            $event->training_minute = $request->training_minute;
        } else {
            $event->training_minute = null;
        }
        $event->save();

        // careerup_curriculum
        if($request->general_or_carrerup == 'carrerup') {
            $event->careerup_curriculums()->delete();

            $data = [];
            foreach ($request['carrerup'] as $key => $item) {
                foreach($item as $i => $val) {
                    $data[$i][$key] = $val;
                }
            }
            foreach ($data as $key => $val) {
                $event->careerup_curriculums()->create([
                    'parent_curriculum' => $val['parent_curriculum'],
                    'child_curriculum' => $val['child_curriculum'],
                    'training_minute' => $val['training_minute'],
                ]);
            }
        } else {
            $event->careerup_curriculums()->delete();
        }

        // event_dates（開催日）
        if(count($request->event_dates) >= $event->event_dates()->count() ){ //　研修開催日増減なし分
            foreach ($event->event_dates as $key => $event_date) {
                $ed_data[] = [
                    'id' => $event_date->id,
                    'event_date' => $request['event_dates'][$key]." 00:00:00",
                ];
            }

            // 既存カラム更新
            $when_then = '';
            $ids = '';
            foreach($ed_data as $key => $item) {
                $when_then .= " WHEN ".$item['id']." THEN '".$item['event_date']."'";
                $ids .=  $item['id'];
                if(end($ed_data) != $item) {
                    $ids .= ',';
                }
            }

            $sql = 'update event_dates set `event_date` =
                            case `id`
                                '.$when_then.'
                            END 
                        WHERE `id` IN('.$ids.')';
            $affected = DB::update($sql);

            if(count($request->event_dates) > $event->event_dates()->count()) { // 研修開催日増えた分
                foreach ($request->event_dates as $key => $val) {
                    if($key >= ($event->event_dates()->count()) ) {// 挿入カラム抽出
                        $ed_insert_data[] = [
                            'event_date' => $val." 00:00:00",
                        ];
                    }
                }
                // 追加挿入
                foreach ($ed_insert_data as $key => $val) {
                    $event->event_dates()->create(['event_date' => $val['event_date']]);
                }                
            }

        } else { // 研修開催日減った分

            foreach ($event->event_dates as $key => $event_date) {
                if($key <= (count($request->event_dates)-1) ) { // 更新カラム抽出
                    $ed_data[] = [
                        'id' => $event_date->id,
                        'event_date' => $request['event_dates'][$key]." 00:00:00",
                    ];
                } else { // 削除カラムid抽出
                    $ed_delete_data[] = $event_date->id;
                }
            }

            // 既存カラム更新
            $when_then = '';
            $ids = '';
            foreach($ed_data as $key => $item) {
                $when_then .= " WHEN ".$item['id']." THEN '".$item['event_date']."'";
                $ids .=  $item['id'];
                if(end($ed_data) != $item) {
                    $ids .= ',';
                }
            }

            $sql = 'update event_dates set `event_date` =
                            case `id`
                                '.$when_then.'
                            END 
                        WHERE `id` IN('.$ids.')';
            $affected = DB::update($sql);

            // 減った分削除
            foreach ($ed_delete_data as $val) {
                $event_dates = Event_date::find($val);
                $event_dates->delete();
            }                

        }

        // event_uploads（アップロード）
        if($request->file('files')){
            foreach ($request->file('files') as $index=> $e) {
                $path = $e->store('public/event');
                $event->event_uploads()->create(['path'=> basename($path)]);
            }
        }

        return redirect()->route('event.show',['id' => $id])->with('status','研修の変更が完了しました。');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }
        //softdelete
        $event = Event::find($id);
        $event->delete();
        return redirect()->route('event.index')->with('attention',"研修を削除しました。");
    }

    public function restore($id) {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }
        $event = Event::onlyTrashed()->find($id);
        $event->restore();
        return redirect()->route('event.index')->with('status','研修を復元しました。');
    }

    public function forceDelete($id) {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }
        $event = Event::onlyTrashed()->find($id);
        $event->forceDelete();
        return redirect()->route('event.index')->with('attention','研修をを完全に削除しました。削除した研修は復元できません。');
    }

    public function fileDelete($id) {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }
        $event_upload = Event_upload::find($id);
        $pathname = storage_path().'/app/public/event/'.$event_upload->path;
        \File::delete($pathname);

        $event = $event_upload->event;
        $event_upload->delete();
        return redirect()->route('event.edit',['id' => $event->id])->with('attention',"アップロードファイルを削除しました。");

    }

    public function apply(Request $request) {
        if(Gate::allows('area-higher')){ // 個人、法人ユーザ以外
            return redirect('/event');
        }
        $event = Event::find($request->event_id);
        $event_dates = $event->event_dates()->get();
        $event_dates_cnt = $event_dates->count();
        $entrys_cnt = Entry::select('user_id')
                        ->where('event_id',$request->event_id)
                        ->where(function($q){
                            $q->where('entry_status','Y')
                                ->orWhere('entry_status','YC');
                        })->groupBy('user_id')->get()->count();
        // 通し番号
        $anumber = Entry::where('event_id',$request->event_id) 
                        ->where(function($q){
                            $q->where('entry_status','Y')
                                ->orWhere('entry_status','YC');
                        })->get();
        
        if($anumber->count() > 0){
            $applynumber = $anumber->max('serial_number');
        } else {
            $applynumber = 0;
        }

        // 定員<-->申込数
        if($event->capacity > $entrys_cnt){
            $entry_status = 'Y'; // 申込枠確保
            $entry_status_replace = '申し込み登録';
            $vmessage = $event->title."への申込が完了しました。";
			$anumber_real = ($applynumber+1); //通し番号
        } else {
            $entry_status = 'CW'; // キャンセル待ち申込み
            $entry_status_replace = 'キャンセル待ち登録';
            $vmessage = $event->title."への申込をキャンセル待ちとして登録完了しました。";
			$anumber_real = null;
        }

        // 申込期間
        $dt = Carbon::now();
        $entry_start_date = new Carbon($event->entry_start_date);
        $entry_end_date = new Carbon($event->entry_end_date);        
        if($entry_start_date > $dt || $entry_end_date < $dt){
            return redirect()->route('event.show',['id' => $request->event_id])->with('attention', '申込期間外のため申込みができません。');
        }

        // キャリアアップ研修のみ保育士かどうか、所属施設の確認
        // if($event->general_or_carrerup == 'carrerup') {
        //     $entrying_user = User::find($request->user_id);
        //     if($entrying_user->profile->job != config('const.JOB.0')) {
        //         return redirect()->route('event.show',['id' => $request->event_id])->with('attention', 'キャリアアップ研修は保育士専用の研修です。該当ユーザの職種が保育士でないため申込みができません。');
        //     } else {
        //         if($entrying_user->company_profile_id == null && !$entrying_user->profile->other_facility_name) {
        //             return redirect()->route('event.show',['id' => $request->event_id])->with('attention', '所属施設が兵庫県外で所属施設名の設定がないため申込みができません。');
        //         }
        //     }
        // }

        $entry = New Entry;
        foreach($event_dates as $key => $item){
            $entry->create([
                'event_id' => $request->event_id,
                'event_date_id' => $item['id'],
                'user_id' => $request->user_id,
                'applying_user_id' => Auth::id(),
                'serial_number' => $anumber_real,
                'entry_status' => $entry_status,
            ]);
        }

        // メール送信
        $user = User::where('id',$request->user_id)->first();
        $data = [
            'username' => $user->name,
            'eventtitle' => $event->title,
            'eventdates' => $event_dates,
            'entrystatus' => $entry_status_replace,
        ];

        $email = new ApplyConfirmMail($data);
        Mail::to($user->email)->send($email);

        return redirect()->route('event.show',['id' => $request->event_id])->with('status',$vmessage);

    }

    public function cancel(Request $request) {
        if(Gate::allows('area-higher')){ // 個人、法人ユーザ以外
            return redirect('/event');
        }
        $event = Event::find($request->event_id);

        // 申込期間
        $dt = Carbon::now();
        $entry_start_date = new Carbon($event->entry_start_date);
        $entry_end_date = new Carbon($event->entry_end_date);        
        if($entry_start_date > $dt || $entry_end_date < $dt){
            return view('event.show',['id' => $request->event_id])->with('attention', '申込期間外のためキャンセルができません。');
        }

        $entrys = Entry::where('user_id',$request->user_id)
                        ->where('event_id',$request->event_id)
                        ->where('entry_status','Y')
                        ->get();

        foreach($entrys as $entry){
            $entry->entry_status = "YC";
            $entry->save();
        }

        return redirect()->route('event.show',['id' => $request->event_id])->with('attention',$event->title."への申込をキャンセルしました。");

    }

}
