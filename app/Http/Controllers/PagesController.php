<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function afterwithdrawal()
    {
        return view('afterwithdrawal');
    }

    public function greeting()
    {
        return view('greeting');
    }

    public function links()
    {
        return view('links');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function info()
    {
        return view('info');
    }

    public function contact()
    {
        return view('contact');
    }

}
