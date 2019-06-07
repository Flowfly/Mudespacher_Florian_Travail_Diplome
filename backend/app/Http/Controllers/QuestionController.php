<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use App\Http\Requests\QuestionEdit;
use App\Http\Requests\QuestionSubmit;
use App\Proposition;
use App\Question;
use App\Session;
use Illuminate\Support\Facades\Config;
use Validator;
use App\Type;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    //<editor-fold desc="Backoffice">
    /*** Allows to add a question to the database. The propositions of the question are also added here.
     * @param QuestionSubmit $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function submit(QuestionSubmit $request)
    {
        $numberOfTimesAskedAverage = intval(DB::table('questions')->average('number_of_times_asked'));
        if ($request->file('question-file') != null) {
            $filename = date('mdYHis') . uniqid() . '.mp3';
            $request->file('question-file')->storeAs('/', $filename, 'questions_sounds');
        } else {
            $filename = null;
        }
        $questionToAdd = new Question();
        $questionToAdd->label = $request->question_label;
        $questionToAdd->points = $request->question_points;
        $questionToAdd->type_id = $request->question_type;
        $questionToAdd->tag_id = $request->question_tag;
        $questionToAdd->file = $filename;
        $questionToAdd->number_of_times_asked = $numberOfTimesAskedAverage;
        $result = $questionToAdd->saveOrFail();
        if ($result) {
            //Parsing the prop field into the request. The prop field names are all starting with "prop" followed by their ID. Example : "prop-1"
            for ($i = 0; $i < count($request->all()); $i++) {
                $tmp = explode('-', $request->keys()[$i]);
                if ($tmp[0] == 'prop') {
                    //Adding the prop field to the database
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
        return back()->with(['result' => $result, 'message' => $message]);
    }

    /*** Allows to return the question view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAll(Request $request)
    {
        //Allows to return the question view with all the questions of a certain type
        if ($request->route()->getName() == "types_questions")
            $questions = Question::where('type_id', $request->id)->paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_QUESTIONS_PER_PAGE'));
        //Allows to return the question view with all the questions of a certain tag
        else if ($request->route()->getName() == "tags_questions")
            $questions = Question::where('tag_id', $request->id)->paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_QUESTIONS_PER_PAGE'));
        //Allows to return the question view with all the questions
        else
            $questions = Question::with(['type', 'tag', 'propositions'])->paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_QUESTIONS_PER_PAGE'));
        return view('/backoffice/questions_read', ['questions' => $questions]);
    }

    /*** Allows to return the question view with a specific question
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getOne(Request $request)
    {
        return view('/backoffice/questions_read', ['questions' => [Question::findOrFail($request->id)]]);
    }

    /*** Allows to return the adding's question view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addGetInfos()
    {
        $types = Type::all();
        $tags = Tag::all();
        return view('/backoffice/questions_add')->with(['types' => $types, 'tags' => $tags]);
    }

    /*** Allows to return the edit's question view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editGetInfos(Request $request)
    {
        $question = Question::where('id', $request->id)->with(['type', 'tag', 'propositions'])->get();
        $types = Type::all();
        $tags = Tag::all();
        return view('/backoffice/questions_update')->with(['question' => $question[0], 'types' => $types, 'tags' => $tags]);
    }

    /*** Allows to update a question's field into the database
     * @param QuestionEdit $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(QuestionEdit $request)
    {
        $message = "";
        $editedQuestion = Question::where('id', $request->id)->with(['type', 'tag', 'propositions'])->get()[0];
        if ($request->file('question-file') != null) {
            $filename = $editedQuestion->file == null ? date('mdYHis') . uniqid() . '.mp3' : $editedQuestion->file;
            $request->file('question-file')->storeAs('/', $filename, 'questions_sounds');
        }
        else{
            $filename = $editedQuestion->file;
        }
        $editedQuestion->label = $request->question_label;
        $editedQuestion->points = $request->question_points;
        $editedQuestion->file = $filename;
        $editedQuestion->type_id = $request->question_type;
        $editedQuestion->tag_id = $request->question_tag;

        $result = $editedQuestion->saveOrFail();

        if ($result) {
            for ($i = 0; $i < count($request->all()); $i++) {
                $tmp = explode('-', $request->keys()[$i]);

                if ($tmp[0] == 'prop') {
                    if ($tmp[1] == 'add') {
                        $propositionToAdd = new Proposition();
                        $propositionToAdd->label = $request->input($request->keys()[$i]);
                        $propositionToAdd->is_right_answer = $request->isGoodAnswer;
                        $propositionToAdd->question_id = $editedQuestion->id;
                        $result = $propositionToAdd->saveOrFail();
                    } else {
                        $propositionToAdd = Proposition::findOrFail($tmp[1]);
                        $propositionToAdd->label = $request->input($request->keys()[$i]);
                        $propositionToAdd->is_right_answer = $tmp[1] == $request->isGoodAnswer ? 1 : 0;
                        $propositionToAdd->question_id = $editedQuestion->id;
                        $result = $propositionToAdd->saveOrFail();
                    }

                    if (!$result)
                        break;
                }
            }
            $message = "Question modifiée avec succès !";
        }
        return back()->with(['result' => $result, 'message' => $message]);

    }

    /*** Allows to delete a questions from the database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $questionToDelete = Question::where('id', $request->id);
        $message = "";
        $result = 0;
        if (!empty($questionToDelete)) {
            DB::table('propositions')->where('question_id', $request->id)->delete();
            DB::table('questions')->where('id', $request->id)->delete();
            $result = 1;
            $messsage = "Question supprimée avec succès !";
        }

        return back()->with(['result' => $result, 'message' => $messsage]);
    }
    //</editor-fold>

}
