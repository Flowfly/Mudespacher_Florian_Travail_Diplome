<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use App\Answer;
use App\Proposition;
use App\Question;
use App\Session;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /*** Allows to register an answer to the database. The function take a request that contains user ID, proposition ID, question ID and session ID
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function answer(Request $request)
    {
        $response = "";
        if (isset($request->user_id) && isset($request->proposition_id) && isset($request->session_id)) {
            $session = Session::find($request->session_id);
            if ($session != null) {
                $user = User::find($request->user_id);
                if ($user != null) {
                    $proposition = Proposition::find($request->proposition_id);
                    if($proposition != null)
                    {
                        $answer = new Answer();
                        $answer->user_id = $request->user_id;
                        $answer->proposition_id = $request->proposition_id;
                        $answer->session_id = $request->session_id;
                        $answer->question_id = $session->question_id;
                        $answer->datetime_answered = Carbon::now();
                        $result = $answer->saveOrFail();

                        if ($result) {
                            $user = User::query()->join('user_session', 'users.id', 'user_session.user_id')->where('user_id', '=', $request->user_id)->firstOrFail();
                            $user->sessions()->updateExistingPivot($request->session_id, ['current_question' => ($user->current_question + 1)]);
                            $result = true;
                            $message = "La réponse a été ajoutée avec succès !";
                            $sessionUsers = User::query()->join('user_session', 'users.id', 'user_session.user_id')->where('session_id', '=', $request->session_id)->get();
                            if ($this->didAllUsersAnswered($request) || count($sessionUsers) == 1) {
                                app('App\Http\Controllers\SessionController')->nextQuestion($request);
                            }
                        } else {
                            $result = false;
                            $message = "Une erreur est survenue, veuillez contacter un administrateur.";
                        }
                    }
                    else{
                        $result = false;
                        $message = "Une erreur est survenue avec la réponse sélectionnée, veuillez contacter un administrateur.";
                    }
                }
                else{
                    $result = false;
                    $message = "Une erreur est survenue avec votre session utilisateur, veuillez contacter un administrateur.";
                }
            }
            else{
                $result = false;
                $message = "La session de jeu où vous essayez de répondre n'existe pas. Veuillez contacter un administrateur.";
            }
        } else {
            $result = false;
            $message = "Paramètres manquants, veuillez contacter un administrateur.";
        }
        return response()->json(['status' => $result ? 'success' : 'error', 'message' => $message], $result ? 200 : 422);
    }

    /*** Allows to know if all the user answered to the current question
     * @param Request $request
     * @return bool
     */
    public function didAllUsersAnswered(Request $request)
    {
        $sessionUsers = User::query()->join('user_session', 'users.id', 'user_session.user_id')->where('session_id', '=', $request->session_id)->get();
        $session = Session::with('question')->findOrFail($request->session_id);

        $result = false;
        foreach ($sessionUsers as $user) {
            if ($user->current_question > $session->current_game_question)
                $result = true;
            else {
                $result = false;
                break;
            }
        }
        return $result;
    }
}
