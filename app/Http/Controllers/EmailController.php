<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Gate;
use Carbon\Carbon;
use App\User;
use App\Profile;
use App\Event;
use App\Entry;
use App\Email;
use App\Group;
use App\Group_user;
use Mail;
use App\Mail\Sendmail;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email_drafts = [];
        DB::table('emails')
        ->where('status','N')
        ->orderBy('created_at','desc')
        ->chunk(100, function ($data) use (&$email_drafts) {
            $email_drafts[] = $data;
        });

        $email_finished = [];
        DB::table('emails')
        ->where('status','Y')
        ->orderBy('updated_at','desc')
        ->chunk(100, function ($data) use (&$email_finished) {
            $email_finished[] = $data;
        });

        return view('mail.index',compact('email_drafts','email_finished'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group = config('const.TO');
        $events = Event::all();
        return view('mail.create',compact('group','events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = New Email;

        $rules = [
            'default_group' => 'required|string',
            'title' => 'required|string',
            'comment' => 'required|string',
        ];
        if($request->default_group == config('const.TO.0')) {
            $rules += [
                'event_group' => 'required|string',
            ];
        }
        $request->validate($rules);

        $action = $request->get('action','下書き保存');        
        $input = $request->except('action');

        $email->default_group = $request->default_group;
        $email->title = $request->title;
        $email->comment = $request->comment;
        $email->group_id = null;
        $email->status = ($action == 'メール送信') ? 'Y' : 'N';

        if($request->default_group == config('const.TO.0')) {
            $event = Event::find($request->event_group);
            $email->event_group = $event->title;
        }

        if($action == 'メール送信') {
            switch($email->default_group) {
                case "全ユーザ（特権ユーザ含む）":
                    $users = User::where('status',1)->get();
                    break;
                case "全ユーザ（特権ユーザ除く）":
                    $users = User::where('role_id','>',1)->get();
                    break;
                case "支部ユーザ":
                    $users = User::where('role_id',2)->get();
                    break;
                case "法人ユーザ":
                    $users = User::where('role_id',3)->get();
                    break;
                case "個人ユーザ":
                    $users = User::where('role_id',4)->get();
                    break;
                case "支部+法人ユーザ":
                    $users = User::where('role_id',2)->orWhere('role_id',3)->get();                
                    break;
                case "支部+個人ユーザ":
                    $users = User::where('role_id',2)->orWhere('role_id',4)->get();                
                    break;
                case "法人+個人ユーザ":
                    $users = User::where('role_id',3)->orWhere('role_id',4)->get();                
                    break;
                case "研修ごとの参加（予定）者":
                    $entrys = Entry::where('event_id',$request->event_group)
                                        ->where('entry_status','Y')
                                        ->distinct()
                                        ->select('user_id')
                                        ->get();

                    foreach($entrys as $entry) {
                        $users[] = User::find($entry->user_id);
                    }
                    $users = collect($users);
                    break;
            }

            //dd($users,$email);

            // Sendgrid Personalizations用に成形
            $personalizations = [];
            $regstr = "/(\W|^)[\w.\-]{0,25}@(example)\.(com|net)(\W|$)/";            
            foreach($users as $user) {
                if(!preg_match($regstr,$user->email)) {//ダミーアドレスを除外（ @example.com | @example.net )
                    $personalizations[]['to'] = [
                        'email' => $user->email
                    ];
                }
            }
            if(count($personalizations) == 0) {
                return redirect()->route('mail.create')
                    ->withInput($input)
                    ->with('attention', '指定した送信先に有効なメールアドレスがないため送信できません。');
            }
            $data = [
                'title' => $request->title,
                'body' => $request->comment,
                'to' => $personalizations,// Sendgrid Personalizations用
            ];
            $emails = new Sendmail($data);
            Mail::send($emails);
            
            $mes ="メール送信を実行しました。";

        } else {
            $mes ="下書き保存しました。";
        }

        $email->save();
        return redirect()->route('mail.index')->with('status',$mes);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = Email::find($id);
        return view('mail.show',compact('email'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = config('const.TO');
        $email = Email::find($id);
        $events = Event::all();
        return view('mail.edit',compact('group','email','events'));
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
        $email = Email::find($id);

        $rules = [
            'default_group' => 'required|string',
            'title' => 'required|string',
            'comment' => 'required|string',
        ];
        if($request->default_group == config('const.TO.0')) {
            $rules += [
                'event_group' => 'not_in:0',
            ];
        } 
        $request->validate($rules);

        $action = $request->get('action','下書き保存');        
        $input = $request->except('action');

        $email->default_group = $request->default_group;
        $email->title = $request->title;
        $email->comment = $request->comment;
        $email->group_id = null;
        $email->status = ($action == 'メール送信') ? 'Y' : 'N';

        if($request->default_group == config('const.TO.0')) {
            $event = Event::find($request->event_group);
            $email->event_group = $event->title;
        } else {
            $email->event_group = null;
        }

        if($action == 'メール送信') {
            switch($email->default_group) {
                case "全ユーザ（特権ユーザ含む）":
                    $users = User::where('status',1)->get();
                    break;
                case "全ユーザ（特権ユーザ除く）":
                    $users = User::where('role_id','>',1)->get();
                    break;
                case "支部ユーザ":
                    $users = User::where('role_id',2)->get();
                    break;
                case "法人ユーザ":
                    $users = User::where('role_id',3)->get();
                    break;
                case "個人ユーザ":
                    $users = User::where('role_id',4)->get();
                    break;
                case "支部+法人ユーザ":
                    $users = User::where('role_id',2)->orWhere('role_id',3)->get();                
                    break;
                case "支部+個人ユーザ":
                    $users = User::where('role_id',2)->orWhere('role_id',4)->get();                
                    break;
                case "法人+個人ユーザ":
                    $users = User::where('role_id',3)->orWhere('role_id',4)->get();                
                    break;
                case "研修ごとの参加（予定）者":
                    $entrys = Entry::where('event_id',$request->event_group)
                                        ->where('entry_status','Y')
                                        ->distinct()
                                        ->select('user_id')
                                        ->get();

                    foreach($entrys as $entry) {
                        $users[] = User::find($entry->user_id);
                    }
                    $users = collect($users);
                    break;
            }

            // Sendgrid Personalizations用に成形
            $personalizations = [];
            $regstr = "/(\W|^)[\w.\-]{0,25}@(example)\.(com|net)(\W|$)/";            
            foreach($users as $user) {
                if(!preg_match($regstr,$user->email)) {//ダミーアドレスを除外（ @example.com | @example.net )
                    $personalizations[]['to'] = [
                        'email' => $user->email
                    ];
                }
            }
            if(count($personalizations) == 0) {
                return redirect()->route('mail.create')
                    ->withInput($input)
                    ->with('attention', '指定した送信先に有効なメールアドレスがないため送信できません。');
            }
            $data = [
                'title' => $request->title,
                'body' => $request->comment,
                'to' => $personalizations,// Sendgrid Personalizations用
            ];
            $emails = new Sendmail($data);
            Mail::send($emails);
            
            $mes ="メールを送信を実行しました。";

        } else {
            $mes ="下書き保存しました。";
        }

        $email->save();
        return redirect()->route('mail.index')->with('status',$mes);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email = Email::find($id);
        if($email->status == 'Y') {
            return redirect()->route('mail.index')->with('attention','指定のメールは送信済のため削除できません。');
        } else {
            $email->delete();
            return redirect()->route('mail.index')->with('status','指定したメールを削除しました。');
        }
    }
}
