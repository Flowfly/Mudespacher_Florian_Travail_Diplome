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
}
