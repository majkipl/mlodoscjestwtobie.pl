<?php

namespace App\Http\Controllers;

class PolicyController extends Controller
{
    public function index()
    {
        return view('policy/index', []);
    }
}
