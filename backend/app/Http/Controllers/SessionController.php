<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use App\Answer;
use App\Events\ChangeQuestion;
use App\Events\FinishGame;
use App\Events\StartSession;
use App\Events\UserRegistred;
use App\Http\Requests\SessionEdit;
use App\Http\Requests\SessionSubmit;
use App\Question;
use App\Session;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{

    //<editor-fold desc="Backoffice"
    /*** Allows to start the session of the quiz
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function startSessionQuiz(Request $request)
    {
        $result = $this->startSession($request);
        broadcast(new StartSession($request->session_id))->toOthers();
        return $result[0] ? redirect("/" . $result[1]->id . "/question") : back()->with(['result' => $result[0]]);
    }

    /*** Allows to return the reading view of the sessions with all sessions
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAll()
    {
        return view('/backoffice/sessions_read')->with(['sessions' => Session::with(['question', 'users', 'answers', 'tag'])->paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_SESSIONS_PER_PAGE'))]);
    }

    /*** Allows to return the view that allows to add session in the backoffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addGetInfos()
    {
        return view('/backoffice/sessions_add')->with(['tags' => Tag::all()]);
    }

    /*** Allows to add a session in the database from the backoffice
     * @param SessionSubmit $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function submit(SessionSubmit $request)
    {
        $tagId = 0;
        if ($request->tag != 0) {
            $tag = Tag::findOrFail($request->tag);
            $tagId = $tag->id;
        }

        $sessionToAdd = new Session();
        $sessionToAdd->label = $request->session_label;
        $sessionToAdd->current_game_question = 0;
        $sessionToAdd->date_of_session = Carbon::now();
        $sessionToAdd->tag_id = $tagId == 0 ? null : $tagId;
        $sessionToAdd->question_id = $tagId == 0 ? $this->pickRandomQuestion() : $this->pickRandomQuestion($tagId);
        $result = $sessionToAdd->saveOrFail();
        $message = $result ? 'La session a bien été ajoutée !' : 'Un problème est survenu lors de l\'insertion de la session, veuillez réessayer.';
        return back()->with(['result' => $result, 'message' => $message]);
    }


    /*** Allows to delete a session from the database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $session = Session::findOrFail($request->id);
        if ($session->status == 'Started') {
            $result = false;
            $message = 'Impossible de supprimer une session en cours';
        } else {
            $result = $session->delete();
            $message = $result ? 'La session a bien été supprimée !' : 'Erreur lors de la suppression de la session, veuillez réessayer';
        }
        return back()->with(['result' => $result ? 'success' : 'error', 'message' => $message]);
    }

    /*** Allows to return the view that allows to edit session in the backoffice
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editGetInfos(Request $request)
    {
        return view('/backoffice/sessions_update')->with(['session' => Session::findOrFail($request->id), 'tags' => Tag::all()]);
    }

    /*** Allows to edit a session from the database
     * @param SessionEdit $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SessionEdit $request)
    {
        $tagId = 0;
        if ($request->tag != 0) {
            $tag = Tag::findOrFail($request->tag);
            $tagId = $tag->id;
        }
        $session = Session::findOrFail($request->id);
        $session->label = $request->session_label;
        $session->tag_id = $tagId == 0 ? null : $tagId;
        $session->question_id = $tagId == 0 ? $this->pickRandomQuestion() : $this->pickRandomQuestion($tagId);
        $result = $session->saveOrFail();
        $message = $result ? 'La session a bien été modifiée' : 'Erreur lors de la modification de la session, veuillez réessayer';
        return back()->with(['result' => $result ? 'success' : 'error', 'message' => $message]);
    }


    /*** Allows to restart a session from the backoffice
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restartSessionBackoffice(Request $request)
    {
        $result = $this->restartSession($request);
        return back()->with(['result' => $result, 'message' => 'La session a bien été redémarrée !']);
    }

    //</editor-fold>

    //<editor-fold desc="API">
    /*** Allows to retrieve the current question of the session
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActualQuestion(Request $request)
    {
        $sessionID = $request->session_id;
        $query = Question::query()
            ->with(['propositions', 'tag', 'type'])
            ->select('sessions.label as session_label', 'questions.*')
            ->join('sessions', 'questions.id', '=', 'sessions.question_id')
            ->where('sessions.id', $sessionID)
            ->get();

        return response()->json(['status' => count($query) == 0 ? 'error' : 'success', 'message' => count($query) == 0 ? 'Impossible de récupérer la question de la session. Veuillez contacter un administrateur.' : 'Question récupérée.', 'data' => count($query) == 0 ? '' : $query[0]], count($query) == 0 ? 422 : 200);
    }

    /*** Allows to go to the next question of the quiz
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function nextQuestion(Request $request)
    {
        $result = false;
        $session = Session::findOrFail($request->session_id);
        $nextQuestion = $session->current_game_question + 1;
        if ($nextQuestion <= Config::get('constants.sessions.NUMBER_OF_ASKED_QUESTION')) {
            $session->current_game_question = $nextQuestion;
            $session->question_id = $session->tag_id != null ? $this->pickRandomQuestion($session->tag_id) : $this->pickRandomQuestion();
            $result = $session->saveOrFail();
            broadcast(new ChangeQuestion($session))->toOthers();
        } else {
            $result = $this->finishSession($request->session_id);
            $session = Session::findOrFail($request->session_id);
        }
        return response()->json(['status' => $result ? 'success' : 'error', 'data' => $session]);
    }

    /*** Allows to end a session
     * @param $sessionId
     * @return bool
     */
    public function finishSession($sessionId)
    {
        $session = Session::findOrFail($sessionId);
        $result = false;
        if ($session->status != 'Ended') {
            $session->status = 'Ended';
            $result = $session->saveOrFail();
            if ($result) {
                broadcast(new FinishGame($sessionId))->toOthers();
            }
        } else
            $result = true;
        return $result;
    }

    /*** Allows to pick a random question for the concerned session
     * @param null $id
     * @return mixed
     */
    public function pickRandomQuestion($id = NULL)
    {

        if ($id != NULL) {
            $questions = DB::table('questions')->where('tag_id', '=', $id)->orderBy('number_of_times_asked', 'asc')->get();
        } else {
            $questions = DB::table('questions')->orderBy('number_of_times_asked', 'asc')->get();
        }

        // /!\ Problem to solve -> when tag id is not correct /!\

        $pickedQuestion = Question::where('id', $questions[0]->id)->firstOrFail();
        $pickedQuestion->number_of_times_asked += 1;
        $pickedQuestion->save();
        return $questions[0]->id;
    }


    /*** Allows to add a session in the database from the API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
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

    /*** Allows to start a session from the session
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function startSessionAPI(Request $request)
    {
        $result = $this->startSession($request);
        broadcast(new StartSession($request->session_id))->toOthers();
        return response()->json([
            'status' => $result[0] ? 'success' : 'error',
            'message' => $result[0] ? 'Partie correctement démarrée' : 'Un problème est survenu, veuillez contacter un administrateur',
            'session' => $result[1]]);
    }

    /*** Allows to retrieves the session data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSessionInfos(Request $request)
    {
        return response()->json(Session::findOrFail($request->session_id));
    }

    /*** Allows to retrieve all session that are not started
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllNotStartedSessions()
    {
        return response()->json([Session::where('status', 'Not started')->get()]);
    }

    /*** Allows to subscribe an user to a game session
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribeUser(Request $request)
    {
        $session = Session::find($request->session_id);
        if($session != null){
            $foundUser = User::find($request->user_id);
            if($foundUser != null) {
                $session->users()->attach($request->user_id);
                $wasCorrectlyInserted = Session::whereHas('users', function ($q) use (&$foundUser) {
                    $q->where('id', $foundUser->id);
                })->first() == null ? false : true;
                if($wasCorrectlyInserted)
                {
                    broadcast(new UserRegistred($foundUser, $request->session_id))->toOthers();
                    $message = "Vous avez bien été inscrit à la partie !";
                }
                else{
                    $message = "Une erreur s'est produite au moment de l'inscription. Veuillez contacter un administrateur.";
                }
            }
            else{
                $message = "L'utilisateur avec lequel vous voulez jouer n'a pas été trouvé. Veuillez contacter un administrateur.";
                $wasCorrectlyInserted = false;
            }
        }
        else{
            $wasCorrectlyInserted = false;
            $message = "La session de jeu sur laquelle vous essayez de jouer n'existe pas. Veuillez contacter un administrateur.";
        }

        return response()->json(['status' => $wasCorrectlyInserted ? 'success' : 'error', 'message' => $message], $wasCorrectlyInserted ? 200 : 422);
    }

    /*** Allows to retrieve the ranking of the session
     * @param Request $request
     * @return array
     */
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
                if ($scores[$i][1] >= $tmp[1]) {
                    if (!in_array($scores[$i], $sortedScores))
                        $tmp = [$scores[$i][0], $scores[$i][1], $scores[$i][2]];
                }

            }
            array_push($sortedScores, $tmp);
        }

        return array_slice($sortedScores, 0, Config::get('constants.sessions.NUMBER_OF_DISPLAYED_USERS'));
    }

    /*** Allows to retrieve the ranking in JSON format
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRankingAPI(Request $request)
    {
        return response()->json($this->getRanking($request));
    }

    /*** Allows to retrieve the ranking of a specific user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserRanking(Request $request)
    {
        $answers = Answer::with(['question', 'proposition', 'user'])
            ->where('session_id', '=', $request->session_id)
            ->where('user_id', '=', $request->user_id)
            ->get();
        $score = 0;
        $numberOfCorrectAnswers = 0;
        $user = null;
        foreach ($answers as $answer) {
            if ($answer->proposition->is_right_answer) {
                $score += $answer->question->points;
                $numberOfCorrectAnswers++;
            }
            $user = $answer->user;
        }
        return response()->json(['user' => $user, 'score' => $score, 'correctAnswers' => $numberOfCorrectAnswers]);
    }

    //</editor-fold>

    /*** Allows to start a session
     * @param Request $request
     * @return array
     */
    public function startSession(Request $request)
    {
        $session = Session::findOrFail($request->session_id);
        $session->status = 'Started';
        $session->current_game_question = 1;
        $result = $session->saveOrFail();

        if ($result) {
            $sessionUsers = User::query()->join('user_session', 'users.id', 'user_session.user_id')->where('session_id', '=', $request->session_id)->get();
            foreach ($sessionUsers as $user) {
                $user->sessions()->updateExistingPivot($request->session_id, ['current_question' => 1]);
            }
        }

        return [$result, $session];
    }

    public static function restartSession(Request $request)
    {
        $session = Session::findOrFail($request->session_id);
        $session->current_game_question = 0;
        $session->status = "Not started";
        $result = $session->saveOrFail();
        $session->users()->detach();
        return $result;
    }


}
