<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeEdit;
use App\Http\Requests\TypeSubmit;
use App\Type;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    public function submit(TypeSubmit $request){
        $type = new Type();
        $type->label = $request->name;

        $result = $type->saveOrFail();
        if($result)
            $message = "Le type a été ajouté avec succès !";

        return back()->with(['result' => $result , 'message' => $message]);
    }

    public function addGetInfos(){
        return view('/backoffice/types_add');
    }

    public function editGetInfos(Request $request){
        return view('/backoffice/types_update', ['type' => Type::where('id', $request->id)->get()[0]]);
    }

    public function update(TypeEdit $request)
    {
        $result = 0;
        $message = '';
        $typeToUpdate = Type::where('id', $request->id)->get()[0];

        if(!empty($typeToUpdate))
        {
            $typeToUpdate->label = $request->name;
            $result = $typeToUpdate->saveOrFail();
            if($result)
                $message = "Type modifié avec succès !";
        }
        return back()->with(['result' => $result, 'message' => $message]);
    }

    public function getAll(){
        return view('/backoffice/types_read', ['types' => Type::with('questions')->get()]);
    }

    public function delete(Request $request){
        $typeToDelete = Type::where('id', $request->id);
        $message = "";
        $result = 0;
        if(!empty($typeToDelete)) {
            $questionsToDelete = Question::where('type_id', $request->id)->with('propositions')->get();
            foreach ($questionsToDelete as $question)
            {
                foreach($question->propositions as $proposition)
                {
                    DB::table('propositions')->where('id', $proposition->id)->delete();
                }
            }
            DB::table('questions')->where('type_id', $request->id)->delete();
            DB::table('types')->where('id', $request->id)->delete();

            $result = 1;
            $messsage = "Type supprimé avec succès !";
        }

        return back()->with(['result' => $result , 'message' => $messsage]);
    }
}
