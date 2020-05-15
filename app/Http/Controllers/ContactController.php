<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Gate;
use Carbon\Carbon;
use App\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $inquirys = [];
        DB::table('contacts')
        ->orderBy('created_at','desc')
        ->chunk(100, function ($data) use (&$inquirys) {
            $inquirys[] = $data;
        });

        return view('inquiry.index',compact('inquirys'));
    }

    public function show($id)
    {
        $inquiry = Contact::find($id);        
        return view('inquiry.show',compact('inquiry'));
    }
}
