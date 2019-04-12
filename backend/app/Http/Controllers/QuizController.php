<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return view('/quiz/home');
    }

    public function question(Request $request){
        $sessionID = $request->session_id;
        $currentQuestion = Question::query()
            ->with(['propositions', 'tag', 'type'])
            ->select('sessions.label as session_label', 'questions.*')
            ->join('sessions', 'questions.id', '=', 'sessions.question_id')
            ->where('sessions.id', $sessionID)
            ->firstOrFail();
        return view('/quiz/question')->with(['question' => $currentQuestion]);
    }

    public function end(Request $request){
        $ranking = app('App\Http\Controllers\SessionController')->getRanking($request);
        return view('/quiz/end')->with(['ranking' => $ranking]);
    }
}
