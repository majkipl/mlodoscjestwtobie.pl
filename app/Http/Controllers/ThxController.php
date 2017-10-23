<?php

namespace App\Http\Controllers;

class ThxController extends Controller
{
    public function promotion()
    {
        return view('thx/promotion');
    }

    public function contest()
    {
        return view('thx/contest');
    }

    public function form()
    {
        return view('thx/form');
    }
}
