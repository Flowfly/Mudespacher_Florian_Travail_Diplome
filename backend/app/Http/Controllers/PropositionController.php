<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use App\Proposition;
use Illuminate\Http\Request;

class PropositionController extends Controller
{
    /*** Allows to return the proposition's view with all the proposition fields
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllFromQuestion(Request $request){
        $propositions = Proposition::where('question_id', $request->id)->with(['question'])->get();
        return view('/backoffice/propositions_read', ['propositions' => $propositions]);
    }

    /*** Allows to delete a proposition from the database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $result = false;
        $message = "";
        $propositionToDelete = Proposition::findOrFail($request->id);
        $result = $propositionToDelete->delete();
        if($result){
            $result = 1;
            $message = "La proposition a été supprimée avec succès !";
        }
        else{
            $result = 0;
            $message = "Une erreur est survenue lors de la suppression de la proposition. Veuillez réessayer plus tard.";
        }
        return back()->with(['result' => $result, 'message' => $message]);
    }
}
