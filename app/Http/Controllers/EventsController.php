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

        if(Gate::allows('area-only')) { //支部ユーザのみ
            $events = Event::where('user_id',$user_self)->orderBy('id', 'desc')->paginate(10);
        } else {
            $events = Event::orderBy('id', 'desc')->paginate(10);
        }

        foreach($events as $event) {

            // 研修のステータス
            $dt = Carbon::now();
            $entry_start_date = new Carbon($event['entry_start_date']);
            $entry_end_date = new Carbon($event['entry_end_date']);

            if($entry_start_date > $dt){
                $status = "申込開始前";
            } elseif($entry_end_date < $dt) {
                $status = "申込受付終了";
            } else {
                $status = "申込受付中";
            } 

            // 申込数
            
            //
            $data[] = [
                'id' => $event->id,
                'title' => $event->title,
                'status' => $status,
                'event_dates' => $event->event_dates()->select('event_date')->get(),
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
        $general_or_carrerup = config('const.TRAINING_VARIATION');

        return view('event.create',compact('general_or_carrerup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'general_or_carrerup' => 'not_in:0',
            'title' => 'required|string',
            'comment' => 'required|string',
            'event_dates' => 'required|array',
            'event_dates.*' => 'date_format:Y-m-d',
            'entry_start_date' => 'required|date_format:Y-m-d H:i',
            'entry_end_date' => 'required|date_format:Y-m-d H:i|after:entry_start_date',
            'view_start_date' => 'required|date_format:Y-m-d H:i',
            'view_end_date' => 'required|date_format:Y-m-d H:i|after:view_start_date|after:entry_end_date',
            'capacity' => 'alpha_num|not_in:0',
            'place' => 'required|string',
            'notice' => 'nullable',
            'files.*' => 'file|mimes:pdf',
        ];
        $request->validate($rules);

        // event
        $event = New Event;
        $event->user_id = $request->user()->id;
        $event->view_start_date = $request->view_start_date.":00";
        $event->view_end_date = $request->view_end_date.":00";
        $event->entry_start_date = $request->entry_start_date.":00";
        $event->entry_end_date = $request->entry_end_date.":00";
        $event->fill($request->all())->save();
        
        // event_dates（開催日）
        foreach ($request->event_dates as $val) {
            $event->event_dates()->create(['event_date' => $val." 00:00:00"]);
        }

        // event_uploads（アップロード）
        foreach ($request->file('files') as $index=> $e) {
            $path = $e->store('public/event');
            $event->event_uploads()->create(['path'=> basename($path)]);
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
        $event_dates = $event->event_dates;
        $event_uploads = $event->event_uploads;
        $general_or_carrerup = config('const.TRAINING_VARIATION');
        return view('event.show',compact('event','event_dates','event_uploads','general_or_carrerup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
