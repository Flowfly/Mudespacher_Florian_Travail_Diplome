<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Session;
use App\User;
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

            if($result) {
                $user = User::query()->join('user_session', 'users.id', 'user_session.user_id')->where('user_id', '=', $request->user_id)->firstOrFail();
                $user->sessions()->updateExistingPivot($request->session_id, ['current_question' => ($user->current_question + 1)]);
                $response = ['status' => 'success', 'message' => 'Answer correctly added'];
            }
            else
                $response = ['status' => 'error', 'message' => 'Error occurred. Please contact an administrator.'];
            if($this->didAllUsersAnswered($request))
            {
                app('App\Http\Controllers\SessionController')->nextQuestion($request);
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Missing arguments keys'];
        }
        return response()->json($response);
    }

    public function didAllUsersAnswered(Request $request)
    {
        $sessionUsers = User::query()->join('user_session', 'users.id', 'user_session.user_id')->where('session_id', '=', $request->session_id)->get();
        $session = Session::with('question')->findOrFail($request->session_id);

        $result = false;
        foreach($sessionUsers as $user)
        {
            if($user->current_question > $session->current_game_question)
                $result = true;
            else
            {
                $result = false;
                break;
            }
        }
        return $result;
    }
}
