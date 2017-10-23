<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('home/index', [
            'isEndPromotion' => false,
            'isEndContest' => false,
            'isEndResult' => false,
        ]);
    }
}
