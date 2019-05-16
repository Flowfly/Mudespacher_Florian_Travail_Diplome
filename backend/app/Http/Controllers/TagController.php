<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagEdit;
use App\Http\Requests\TagSubmit;
use App\Question;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function submit(TagEdit $request)
    {
        $tag = new Tag;

        $tag->label = $request->tag_name;
        $result = $tag->saveOrFail();
        $message = "La catégorie a bien été ajoutée !";
        return back()->with(['result'=> $result, 'message' => $message]);
    }

    public function getAll(){
        return view('/backoffice/tags_read')->with('tags', Tag::with('questions')->paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_TAGS_PER_PAGE')));
    }

    public function delete(Request $request){
        $tagToDelete = Tag::where('id', $request->id);
        $message = "";
        $result = 0;
        if(!empty($tagToDelete)) {
            $questionsToDelete = Question::where('tag_id', $request->id)->with('propositions')->get();
            foreach ($questionsToDelete as $question)
            {
                foreach($question->propositions as $proposition)
                {
                    DB::table('propositions')->where('id', $proposition->id)->delete();
                }
            }
            DB::table('questions')->where('tag_id', $request->id)->delete();
            DB::table('tags')->where('id', $request->id)->delete();

            $result = 1;
            $messsage = "Catégorie supprimée avec succès !";
        }

        return back()->with(['result' => $result , 'message' => $messsage]);
    }

    public function editGetInfos(Request $request){
        return view('/backoffice/tags_update', ['tag' => Tag::where('id', $request->id)->get()[0]]);
    }

    public function update(TagSubmit $request)
    {
        $result = 0;
        $message = '';
        $tagToUpdate = Tag::where('id', $request->id)->get()[0];

        if(!empty($tagToUpdate))
        {
            $tagToUpdate->label = $request->tag_name;
            $result = $tagToUpdate->saveOrFail();
            if($result)
                $message = "Catégorie modifiée avec succès !";
        }
        return back()->with(['result' => $result, 'message' => $message]);

    }

    public function addGetInfos()
    {
        return view('/backoffice/tags_add');
    }
}
