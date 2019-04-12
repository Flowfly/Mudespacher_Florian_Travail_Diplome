<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return view('/quiz/home');
    }

    public function question(){
        return view('/quiz/home');
    }

    public function end(Request $request){
        $ranking = app('App\Http\Controllers\SessionController')->getRanking($request);
        return view('/quiz/end')->with(['ranking' => $ranking]);
    }
}
