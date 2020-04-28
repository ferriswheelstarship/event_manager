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
        $inquirys = Contact::orderBy('created_at','desc')->get();        
        return view('inquiry.index',compact('inquirys'));
    }

    public function show($id)
    {
        $inquiry = Contact::find($id);        
        return view('inquiry.show',compact('inquiry'));
    }
}
