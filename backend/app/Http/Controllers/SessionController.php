<?php

namespace App\Http\Controllers;

use App\Answer;
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

    public function startSessionQuiz(Request $request)
    {
        $result = $this->startSession($request);
        return $result[0] ? redirect("/" . $result[1]->id . "/end") : back()->with(['result' => $result[0]]);
    }

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

    //</editor-fold>

    public function startSession(Request $request)
    {
        $session = Session::findOrFail($request->session_id);
        $session->status = 'Started';
        $result = $session->saveOrFail();

        return [$result, $session];
    }
}
