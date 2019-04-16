<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Events\ChangeQuestion;
use App\Events\FinishGame;
use App\Events\StartSession;
use App\Events\UserRegistred;
use App\Question;
use App\Session;
use App\User;
use App\UserSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    const NUMBER_OF_ASKED_QUESTION = 4;

    //<editor-fold desc="Backoffice"
    public function startSessionQuiz(Request $request)
    {
        $result = $this->startSession($request);
        broadcast(new StartSession($request->session_id))->toOthers();
        return $result[0] ? redirect("/" . $result[1]->id . "/question") : back()->with(['result' => $result[0]]);
    }

    public function getAll(){
        return view('/backoffice/sessions_read')->with(['sessions' => Session::with(['question', 'users', 'answers'])->get()]);
    }

    public function addGetInfos(){
        return view('/backoffice/sessions_add');
    }

    public function submit(Request $request){
        $sessionToAdd = new Session();
        $sessionToAdd->label = $request->session_label;
        $sessionToAdd->current_game_question = 0;
        $sessionToAdd->date_of_session = Carbon::now();
        $sessionToAdd->question_id = $this->pickRandomQuestion();
        $result = $sessionToAdd->saveOrFail();
        $message = $result ? 'La session a bien été ajoutée !' : 'Un problème est survenu lors de l\'insertion de la session, veuillez réessayer.';
        return back()->with(['result' => $result, 'message' => $message]);
    }

    public function delete(Request $request)
    {
        $session = Session::findOrFail($request->id);
        if($session->status == 'Started'){
            $result = false;
            $message = 'Impossible de supprimer une session en cours';
        }
        else{
            $result = $session->delete();
            $message = $result ? 'La session a bien été supprimée !' : 'Erreur lors de la suppression de la session, veuillez réessayer';
        }
        return back()->with(['result' => $result ? 'success' : 'error', 'message' => $message]);
    }

    public function editGetInfos(Request $request){
        return view('/backoffice/sessions_update')->with(['session' => Session::findOrFail($request->id)]);
    }

    public function update(Request $request){
        $session = Session::findOrFail($request->id);
        $session->label = $request->session_label;
        $result = $session->saveOrFail();
        $message = $result ? 'La session a bien été modifiée' : 'Erreur lors de la modification de la session, veuillez réessayer';
        return back()->with(['result' => $result ? 'success' : 'error', 'message' => $message]);
    }

    public function restartSession(Request $request){
        $session = Session::findOrFail($request->session_id);
        $session->current_game_question = 0;
        $session->status = "Not started";
        $result = $session->saveOrFail();
        $session->users()->detach();
        return back()->with(['result' => $result, 'message' => 'La session a bien été redémarrée !']);
    }
    //</editor-fold>

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

        return response()->json(['status' => count($query) == 0 ? 'error' : 'success', 'data' => $query[0]]);
    }

    public function nextQuestion(Request $request)
    {
        $result = false;
        $session = Session::findOrFail($request->session_id);
        $nextQuestion = $session->current_game_question + 1;
        if ($nextQuestion <= self::NUMBER_OF_ASKED_QUESTION) {
            $session->current_game_question = $nextQuestion;
            $session->question_id = isset($request->tag_id) ? $this->pickRandomQuestion($request->tag_id) : $this->pickRandomQuestion();
            $result = $session->saveOrFail();
            broadcast(new ChangeQuestion($session))->toOthers();
        } else {
            $result = $this->finishSession($request->session_id);
            $session = Session::findOrFail($request->session_id);
        }
        return response()->json(['status' => $result ? 'success' : 'error', 'data' => $session]);
    }

    public function finishSession($sessionId){
        $session = Session::findOrFail($sessionId);
        $result = false;
        if($session->status != 'Ended')
        {
            $session->status = 'Ended';
            $result = $session->saveOrFail();
            if($result)
            {
                broadcast(new FinishGame($sessionId))->toOthers();
            }
        }
        else
            $result = true;
        return $result;
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

    public function createSession(Request $request)
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

    public function startSessionAPI(Request $request)
    {
        $result = $this->startSession($request);
        broadcast(new StartSession($request->session_id))->toOthers();
        return response()->json([
            'status' => $result[0] ? 'success' : 'error',
            'message' => $result[0] ? 'Partie correctement démarrée' : 'Un problème est survenu, veuillez contacter un administrateur',
            'session' => $result[1]]);
    }

    public function getSessionInfos(Request $request)
    {
        return response()->json(Session::findOrFail($request->session_id));
    }

    public function getAllNotStartedSessions()
    {
        return response()->json([Session::where('status', 'Not started')->get()]);
    }

    public function subscribeUser(Request $request)
    {
        $session = Session::findOrFail($request->session_id);
        $foundUser = User::findOrFail($request->user_id);
        $session->users()->attach($request->user_id);
        $wasCorrectlyInserted = Session::whereHas('users', function ($q) use (&$foundUser) {
            $q->where('id', $foundUser->id);
        })->first() == null ? false : true;
        broadcast(new UserRegistred($foundUser, $request->session_id))->toOthers();
        return response()->json(['status' => $wasCorrectlyInserted ? 'success' : 'error', 'message' => $wasCorrectlyInserted ? "L'utilisateur a été inscrit à la session" : "L'utilisateur n'a pas été inscrit à la session"]);
    }

    public function getRanking(Request $request)
    {
        $sessionAnswers = Answer::where('session_id', $request->session_id)->with(['user', 'question', 'proposition', 'session'])->get();
        $users = [];
        $scores = [];
        foreach ($sessionAnswers as $answer) {
            if (!in_array($answer->user, $users)) {
                array_push($users, $answer->user);
            }
        }
        $count = 0;
        foreach ($users as $user) {

            array_push($scores, [$user->username, 0, 0]);//$scores[$user->username] = [0, 0];
            $userAnswers = Answer::where('session_id', $request->session_id)->where('user_id', $user->id)->with(['question', 'proposition'])->get();
            foreach ($userAnswers as $answer) {
                if ($answer->proposition->is_right_answer) {
                    $scores[$count][1] += $answer->question->points;
                    $scores[$count][2] += 1;
                }
            }
            $count++;
        }
        $sortedScores = [];

        while (count($sortedScores) < count($scores)) {
            $tmp = ['', 0, 0];
            for ($i = 0; $i < count($scores); $i++) {
                if ($scores[$i][1] >= $tmp[1])
                {
                    if(!in_array($scores[$i], $sortedScores))
                        $tmp = [$scores[$i][0], $scores[$i][1], $scores[$i][2]];
                }

            }
            array_push($sortedScores, $tmp);
        }
        return $sortedScores;
    }

    public function getRankingAPI(Request $request)
    {
        return response()->json($this->getRanking($request));
    }

    public function getUserRanking(Request $request){
        $answers = Answer::with(['question', 'proposition', 'user'])
            ->where('session_id', '=', $request->session_id)
            ->where('user_id', '=', $request->user_id)
            ->get();
        $score = 0;
        $numberOfCorrectAnswers = 0;
        $user = null;
        foreach($answers as $answer)
        {
            if($answer->proposition->is_right_answer) {
                $score += $answer->question->points;
                $numberOfCorrectAnswers++;
            }
            $user = $answer->user;
        }
        return response()->json(['user' => $user, 'score' => $score, 'correctAnswers' => $numberOfCorrectAnswers]);
    }
    //</editor-fold>

    public function startSession(Request $request)
    {
        $session = Session::findOrFail($request->session_id);
        $session->status = 'Started';
        $session->current_game_question = 1;
        $result = $session->saveOrFail();

        if($result) {
            $sessionUsers = User::query()->join('user_session', 'users.id', 'user_session.user_id')->where('session_id', '=', $request->session_id)->get();
            foreach($sessionUsers as $user)
            {
                $user->sessions()->updateExistingPivot($request->session_id, ['current_question' => 1]);
            }
        }

        return [$result, $session];
    }
}
