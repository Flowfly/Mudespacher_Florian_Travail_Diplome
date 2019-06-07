<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use App\Http\Requests\TypeEdit;
use App\Http\Requests\TypeSubmit;
use App\Type;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    /*** Allows to add a type in the database
     * @param TypeSubmit $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function submit(TypeSubmit $request){
        $type = new Type();
        $type->label = $request->name;

        $result = $type->saveOrFail();
        if($result)
            $message = "Le type a été ajouté avec succès !";

        return back()->with(['result' => $result , 'message' => $message]);
    }

    /*** Allows to return the view that allows to add types
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addGetInfos(){
        return view('/backoffice/types_add');
    }

    /*** llows to return the view that allows to edit types
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editGetInfos(Request $request){
        return view('/backoffice/types_update', ['type' => Type::where('id', $request->id)->get()[0]]);
    }

    /*** Allows to edit a type from the database
     * @param TypeEdit $request
     * @return \Illuminate\Http\RedirectResponse
     */
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


    /*** Allows to return a view that display all the types
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAll(){
        return view('/backoffice/types_read', ['types' => Type::with('questions')->get()]);
    }

    /*** Allows to delete a type from the database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
