<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

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
    /*** Allows to add a tag in the database
     * @param TagEdit $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function submit(TagEdit $request)
    {
        $tag = new Tag;

        $tag->label = $request->tag_name;
        $result = $tag->saveOrFail();
        $message = "La catégorie a bien été ajoutée !";
        return back()->with(['result'=> $result, 'message' => $message]);
    }

    /*** Allows to return the view that display all the tags
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAll(){
        return view('/backoffice/tags_read')->with('tags', Tag::with('questions')->paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_TAGS_PER_PAGE')));
    }

    /*** Allows to delete a tag from a database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /*** Allows to return a view that allows to edit a tag
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editGetInfos(Request $request){
        return view('/backoffice/tags_update', ['tag' => Tag::where('id', $request->id)->get()[0]]);
    }


    /*** Allows to edit a tag from the database
     * @param TagSubmit $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /*** Allows to return the view that allows to add a tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addGetInfos()
    {
        return view('/backoffice/tags_add');
    }
}
