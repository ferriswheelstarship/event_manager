<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Gate;
use Carbon\Carbon;
use App\Information;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('system-only')){ // 特権ユーザ以外
            return redirect('/event');
        }

        $infos = Information::orderBy('article_date','desc')->get();        
        return view('information.index',compact('infos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('system-only')){ // 特権ユーザ以外
            return redirect('/event');
        }
        return view('information.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('system-only')){ // 特権ユーザ以外
            return redirect('/event');
        }
        $rules = [
            'title' => 'required|string',
            'article_date' => 'required|date_format:Y-m-d',
            'comment' => 'required|string',
        ];
        // dd($request);
        $request->validate($rules);
        
        // information
        $information = New Information;
        $information->fill($request->all())->save();

        return redirect()->route('information.index')->with('status','記事登録が完了しました。');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('system-only')){ // 特権ユーザ以外
            return redirect('/event');
        }
        $information = Information::find($id);
        return view('information.show',compact('information'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('system-only')){ // 特権ユーザ以外
            return redirect('/event');
        }
        $information = Information::find($id);
        return view('information.edit',compact('information'));
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
        if(Gate::denies('system-only')){ // 特権ユーザ以外
            return redirect('/event');
        }
        $rules = [
            'title' => 'required|string',
            'article_date' => 'required|date_format:Y-m-d',
            'comment' => 'required|string',
        ];
        // dd($request);
        $request->validate($rules);

        $information = Information::find($id);
        $information->title = $request->title;
        $information->article_date = $request->article_date;
        $information->comment = $request->comment;
        $information->save();

        return redirect()->route('information.show',['id' => $id])->with('status','記事の変更が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('system-only')){ // 支部、特権ユーザ以外
            return redirect('/event');
        }
        $information = Information::find($id);
        $information->delete();
        return redirect()->route('information.index')->with('attention',"記事を削除しました。");
    }
}
