<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /*** Allows to return a view that display the theme page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('/backoffice/theme');
    }

    /*** Allows to change a image of the quiz
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeImage(Request $request){
        if($request->file('image')->isValid()){
            $filename = $request->imageName . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('/', $filename, 'quiz');
        }
        return back()->with(['result' => 'success', 'message' => 'Image changée avec succès !']);
    }
}
