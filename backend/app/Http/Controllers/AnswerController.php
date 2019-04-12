<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function answer(Request $request){
        $response = "";
        if (isset($request->user_id) && isset($request->proposition_id) && isset($request->session_id)) {
            $session = Session::findOrFail($request->session_id);

            $answer = new Answer();
            $answer->user_id = $request->user_id;
            $answer->proposition_id = $request->proposition_id;
            $answer->session_id = $request->session_id;
            $answer->question_id = $session->question_id;
            $answer->datetime_answered = Carbon::now();
            $result = $answer->saveOrFail();
            if ($result)
                $response = ['status' => 'success', 'message' => 'Answer correctly added'];
            else
                $response = ['status' => 'error', 'message' => 'Error occurred. Please contact an administrator.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Missing arguments keys'];
        }
        return response()->json($response);
    }
}
