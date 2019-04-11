<?php

namespace App\Http\Controllers;

use App\AnswerUser;
use App\Question;
use App\Session;
use App\User;
use App\UserSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    const NUMBER_OF_ASKED_QUESTION = 4;

    //<editor-fold desc="API">
    public function getActualQuestion(Request $request)
    {
        $sessionID = $request->session_id;
        $query = Question::query()
            ->with(['propositions', 'tag', 'type'])
            ->select('sessions.label as session_label', 'questions.*')
            ->join('sessions', 'questions.id', '=', 'sessions.question_id')
            ->where('sessions.id', $sessionID)
            ->get();

        return response()->json(['status' => count($query) == 0 ? 'error' : 'success', 'data' => $query]);
    }

    public function nextQuestion(Request $request)
    {
        $result = false;
        $session = Session::findOrFail($request->session_id)->first();
        $nextQuestion = $session->current_game_question + 1;
        if ($nextQuestion <= self::NUMBER_OF_ASKED_QUESTION) {
            $session->current_game_question = $nextQuestion;
            $session->question_id = isset($request->tag_id) ? $this->pickRandomQuestion($request->tag_id) : $this->pickRandomQuestion();
            $result = $session->saveOrFail();
        } else {
            //game finished
        }
        return response()->json(['status' => $result ? 'success' : 'error', 'data' => $session]);
    }

    public function pickRandomQuestion($id = NULL)
    {
        if ($id != NULL) {
            $questions = Question::query()
                ->where('id', '!=', 8)
                ->where('tag_id', $id)
                ->get();
        } else {
            $questions = Question::where('id', '!=', 8)->get();
        }
        // /!\ Problem to solve -> when tag id is not correct /!\
        $random = mt_rand(0, count($questions) - 1);

        return $questions[$random]->id;
    }

    public function answer(Request $request)
    {
        $response = "";
        if (isset($request->user_id) && isset($request->proposition_id) && isset($request->session_id)) {
            $session = Session::findOrFail($request->session_id);

            $answer = new AnswerUser();
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

    public function startSession(Request $request)
    {
        $response = "";
        if (isset($request->label)) {
            $session = new Session();
            $session->label = $request->label;
            $session->current_game_question = 0;
            $session->question_id = isset($request->tag_id) ? $this->pickRandomQuestion($request->tag_id) : $this->pickRandomQuestion();
            $session->date_of_session = Carbon::now();
            $result = $session->saveOrFail();
            if ($result)
                $response = ['status' => 'success', 'session_id' => $session->id];
            else
                $response = ['status' => 'error', 'message' => 'An error occurred, please contact an administrator'];

        } else {
            $response = ['status' => 'error', 'message' => 'Missing arguments keys'];
        }

        return response()->json($response);
    }

    public function getSessionInfos(Request $request){
        return response()->json(Session::findOrFail($request->session_id));
    }

    public function getAllNotStartedSessions(){
        return response()->json([Session::where('status', 'Not started')->get()]);
    }

    public function subscribeUser(Request $request){
        $session = Session::findOrFail($request->session_id);
        $foundUser = User::findOrFail($request->user_id);
        $session->users()->attach($request->user_id);
        //dump(UserSession::with('users')->whereUserId(1)->first());
        $wasCorrectlyInserted = Session::whereHas('users', function($q) use (&$foundUser){
            $q->where('id', $foundUser->id);
        })->first() == null ? false : true;
        return response()->json(['status' => $wasCorrectlyInserted ? 'success' : 'error', 'message' => $wasCorrectlyInserted ? "L'utilisateur a été inscrit à la session" : "L'utilisateur n'a pas été inscrit à la session"]);
    }
    //</editor-fold>
}
