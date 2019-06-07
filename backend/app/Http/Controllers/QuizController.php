<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use App\Question;
use App\Session;
use App\User;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /*** Allows to return the home view of the quiz
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $session = Session::findOrFail($request->session_id);
        if($session->status == 'Started')
            return redirect($request->session_id . '/question');
        else {
            $users = [];
            $query = User::query()->join('user_session', 'users.id', 'user_session.user_id')->get()->where('session_id', '=', $request->session_id);
            foreach($query as $user)
            {
                array_push($users, $user);
            }
            return view('/quiz/home')->with(['users' => $users]);
        }
    }

    /*** Allows to return the question view of the quiz
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /*** Allows to return the end view of the quiz
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function end(Request $request){
        app('App\Http\Controllers\SessionController')->restartSession($request);
        $ranking = app('App\Http\Controllers\SessionController')->getRanking($request);
        return view('/quiz/end')->with(['ranking' => $ranking]);
    }
}
