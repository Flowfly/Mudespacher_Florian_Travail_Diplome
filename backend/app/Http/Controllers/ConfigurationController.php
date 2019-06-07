<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /*** Allows to return the configuration  view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('/backoffice/configuration')->with(['configuration' => Configuration::all()]);
    }

    /*** Allows to update the configuration fields located in the database which are used for the quiz
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $result = true;
        $configuration = Configuration::all();
        foreach ($configuration as $item) {
            switch ($item->name) {
                case "minimum_proposition_label_length":
                    $item->value = $request->min_prop_name;
                    break;
                case "maximum_proposition_label_length":
                    $item->value = $request->max_prop_name;
                    break;
                case "minimum_question_label_length":
                    $item->value = $request->min_question_name;
                    break;
                case "maximum_question_label_length":
                    $item->value = $request->max_question_name;
                    break;
                case "minimum_question_points":
                    $item->value = $request->min_question_points;
                    break;
                case "maximum_question_points":
                    $item->value = $request->max_question_points;
                    break;
                case "number_of_asked_question":
                    $item->value = $request->number_of_asked_question;
                    break;
                case "number_of_displayed_users":
                    $item->value = $request->number_of_displayed_users;
                    break;
                case "minimum_username_length":
                    $item->value = $request->min_user_username;
                    break;
                case "maximum_username_length":
                    $item->value = $request->max_user_username;
                    break;
                case "minimum_password_length":
                    $item->value = $request->min_user_password;
                    break;
                case "maximum_password_length":
                    $item->value = $request->max_user_password;
                    break;
                case "minimum_name_length":
                    $item->value = $request->min_user_name;
                    break;
                case "maximum_name_length":
                    $item->value = $request->max_user_name;
                    break;
                case "minimum_surname_length":
                    $item->value = $request->min_user_surname;
                    break;
                case "maximum_surname_length":
                    $item->value = $request->max_user_surname;
                    break;
                case "minimum_session_label_length":
                    $item->value = $request->min_session_name;
                    break;
                case "maximum_session_label_length":
                    $item->value = $request->max_session_name;
                    break;
                case "minimum_tag_name_length":
                    $item->value = $request->min_tag_name;
                    break;
                case "maximum_tag_name_length":
                    $item->value = $request->max_tag_name;
                    break;
                case "minimum_team_name_length":
                    $item->value = $request->min_team_name;
                    break;
                case "maximum_team_name_length":
                    $item->value = $request->max_team_name;
                    break;
                case "minimum_type_name_length":
                    $item->value = $request->min_type_name;
                    break;
                case "maximum_type_name_length":
                    $item->value = $request->max_type_name;
                    break;
            }
            if(!$item->saveOrFail()) {
                $result = false;
                break;
            }
        }
        $message = $result ? 'La configuration a été mise à jour !' : 'Un problème est survenu lors de la mise à jour de la configuration, veuillez réessayer.';
        return back()->with(['result' => $result, 'message' => $message]);;

    }
}
