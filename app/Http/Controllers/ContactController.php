<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Gate;
use Carbon\Carbon;
use App\Contact;
use App\Registration_request;

class ContactController extends Controller
{
    public function index()
    {
        $inquirys = [];
        Contact::orderBy('created_at','desc')
        ->chunk(100, function ($data) use (&$inquirys) {
            $inquirys[] = $data;
        });

        $registration_requests = [];
        Registration_request::orderBy('created_at','desc')
        ->chunk(100, function ($data) use (&$registration_requests) {
            $registration_requests[] = $data;
        });

        return view('inquiry.index',compact('inquirys','registration_requests'));
    }

    public function show($id)
    {
        $inquiry = Contact::find($id);
        $registration_request = null;

        if(!$inquiry) {
            return redirect()->route('inquiry.index');
        }

        return view('inquiry.show',compact('inquiry','registration_request'));
    }

    public function registration_request_show($id)
    {
        $inquiry = null;
        $registration_request = Registration_request::find($id);

        if(!$registration_request) {
            return redirect()->route('inquiry.index');
        }

        return view('inquiry.show',compact('inquiry','registration_request'));
    }

}
