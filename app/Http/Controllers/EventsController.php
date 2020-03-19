<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Gate;
use Carbon\Carbon;
use App\Event;
use App\User;
use App\Careerup_curriculum;
use App\Event_date;
use App\Event_upload;

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

            if($event->deleted_at) {
                $status = "削除済";
            } else {
                if($entry_start_date > $dt){
                    $status = "申込開始前";
                } elseif($entry_end_date < $dt) {
                    $status = "申込受付終了";
                } else {
                    $status = "申込受付中";
                } 
            }

            // 申込数
            
            //
            $data[] = [
                'id' => $event->id,
                'title' => $event->title,
                'status' => $status,
                'event_dates' => $event->event_dates()->select('event_date')->get(),
                'deleted_at' => $event->deleted_at,
            ];
        }

        return view('event.index',compact('events','data'));
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
        return view('event.show',compact('event','careerup_curriculums','event_dates','event_uploads','general_or_carrerup'));
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
        foreach ($request->event_dates as $val) {
            $event->event_dates()->delete();
            $event->event_dates()->create(['event_date' => $val." 00:00:00"]);
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
        $user = Event::onlyTrashed()->find($id);
        $user->restore();
        return redirect()->route('event.index')->with('status','研修を復元しました。');
    }

    public function forceDelete($id) {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }
        $user = Event::onlyTrashed()->find($id);
        $user->forceDelete();
        return redirect()->route('event.index')->with('attention','研修をを完全に削除しました。削除した研修は復元できません。');
    }

    public function fileDelete($id) {
        if(Gate::denies('area-higher')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }
        $event_upload = Event_upload::find($id);
        $event = $event_upload->event;
        $event_upload->delete();
        return redirect()->route('event.edit',['id' => $event->id])->with('attention',"アップロードファイルを削除しました。");

    }

}
