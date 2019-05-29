<?php

namespace App\Http\Controllers;

use App\Proposition;
use Illuminate\Http\Request;

class PropositionController extends Controller
{
    public function getAllFromQuestion(Request $request){
        $propositions = Proposition::where('question_id', $request->id)->with(['question'])->get();
        return view('/backoffice/propositions_read', ['propositions' => $propositions]);
    }

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
