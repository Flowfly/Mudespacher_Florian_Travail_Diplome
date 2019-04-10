<?php

namespace App\Http\Controllers;

use App\Proposition;
use App\Question;
use App\Session;
use App\Type;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    const MINIMUM_QUESTION_LABEL_LENGTH = 5;
    const MAXIMUM_QUESTION_LABEL_LENGTH = 70;
    const MINIMUM_PROPOSITION_LABEL_LENGTH = 1;
    const MAXIMUM_PROPOSITION_LABEL_LENGTH = 20;

    //<editor-fold desc="Backoffice">

    public function submit(Request $request)
    {
        $rules = $this->getRules($request, false);
        $request->validate($rules);
        $questionToAdd = new Question();
        $questionToAdd->label = $request->question_label;
        $questionToAdd->points = $request->question_points;
        $questionToAdd->type_id = $request->question_type;
        $questionToAdd->tag_id = $request->question_tag;
        $result = $questionToAdd->saveOrFail();
        if ($result) {
            for ($i = 0; $i < count($request->all()); $i++) {
                $tmp = explode('-', $request->keys()[$i]);
                if ($tmp[0] == 'prop') {
                    $propositionToAdd = new Proposition();
                    $propositionToAdd->label = $request->input($request->keys()[$i]);
                    $propositionToAdd->is_right_answer = $tmp[1] == $request->isGoodAnswer ? 1 : 0;
                    $propositionToAdd->question_id = $questionToAdd->id;
                    $result = $propositionToAdd->saveOrFail();
                    if (!$result)
                        break;
                }

            }
        }
        $message = "Question ajoutée avec succès !";
        return back()->with(['result'=> $result, 'message'=> $message]);
    }

    public function getAll(Request $request)
    {
        if($request->route()->getName() == "types_questions")
            $questions = Type::where('id', $request->id)->with('questions')->firstOrFail()->questions;
        else if($request->route()->getName() == "tags_questions")
            $questions = Tag::where('id', $request->id)->with('questions')->firstOrFail()->questions;
        else
            $questions = Question::with(['type', 'tag', 'propositions'])->get();
        return view('/backoffice/questions_read', ['questions' => $questions]);
    }

    public function addGetInfos(){
        $types = Type::all();
        $tags = Tag::all();
        return view('/backoffice/questions_add')->with(['types' => $types , 'tags'=> $tags]);
    }

    public function editGetInfos(Request $request)
    {
        $question = Question::where('id', $request->id)->with(['type', 'tag', 'propositions'])->get();
        $types = Type::all();
        $tags = Tag::all();
        return view('/backoffice/questions_update')->with(['question' => $question[0] , 'types' => $types , 'tags'=> $tags]);
    }

    public function update(Request $request)
    {
        $message = "";
        $rules = $this->getRules($request, true);
        $request->validate($rules);
        $editedQuestion = Question::where('id', $request->id)->with(['type', 'tag', 'propositions'])->get()[0];
        $editedQuestion->label = $request->question_label;
        $editedQuestion->points = $request->question_points;
        $editedQuestion->type_id = $request->question_type;
        $editedQuestion->tag_id = $request->question_tag;

        $result = $editedQuestion->saveOrFail();

        if($result)
        {
            for ($i = 0; $i < count($request->all()); $i++) {
                $tmp = explode('-', $request->keys()[$i]);

                if ($tmp[0] == 'prop') {

                    $propositionToAdd = Proposition::where('id', $tmp[1])->get()[0];
                    $propositionToAdd->label = $request->input($request->keys()[$i]);
                    $propositionToAdd->is_right_answer = $tmp[1] == $request->isGoodAnswer ? 1 : 0;
                    $propositionToAdd->question_id = $editedQuestion->id;
                    $result = $propositionToAdd->saveOrFail();
                    if (!$result)
                        break;
                }

            }
            $message = "Question modifiée avec succès !";
        }
        return back()->with(['result'=> $result, 'message' => $message]);

    }

    public function delete(Request $request){
        $questionToDelete = Question::where('id', $request->id);
        $message = "";
        $result = 0;
        if(!empty($questionToDelete))
        {
            DB::table('propositions')->where('question_id', $request->id)->delete();
            DB::table('questions')->where('id', $request->id)->delete();
            $result = 1;
            $messsage = "Question supprimée avec succès !";
        }

        return back()->with(['result' => $result , 'message' => $messsage]);
    }

    public function getRules(Request $request, $isEditing)
    {

        $rules = [
            'question_label' => ['min:' . self::MINIMUM_QUESTION_LABEL_LENGTH, 'max:' . self::MAXIMUM_QUESTION_LABEL_LENGTH, 'required', 'string', 'filled'],
            'question_points' => ['required', 'numeric', 'between:0,100'],
            'question_type' => ['required', 'numeric'],
            'question_tag' => ['required', 'numeric'],
            'isGoodAnswer' => [$isEditing == true ? '' : 'required', 'numeric'],
        ];

        for ($i = 0; $i < count($request->all()); $i++) {
            $tmp = explode('-', $request->keys()[$i])[0];
            if ($tmp == 'prop') {
                $rules[$request->keys()[$i]] = ['min:' . self::MINIMUM_PROPOSITION_LABEL_LENGTH, 'max:' . self::MAXIMUM_PROPOSITION_LABEL_LENGTH, 'required', 'string', 'filled'];
            }

        }
        return $rules;

    }
    //</editor-fold>

}
