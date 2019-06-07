<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App\Http\Controllers;

use App\Http\Requests\TeamEdit;
use App\Http\Requests\TeamSubmit;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /*** Allows to return a view that displays all the teams
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAll(){
        return view('/backoffice/teams_read', ['teams' => Team::with('users')->paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_TEAMS_PER_PAGE'))]);
    }

    /*** Allows to return a view that allows to add a team
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addGetInfos(){
        return view('/backoffice/teams_add');
    }

    /*** Allows to return a view that allows to edit a team
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editGetInfos(Request $request)
    {
        return view('/backoffice/teams_update', ['team' => Team::where('id' , '=', $request->id)->with('users')->firstOrFail()]);
    }


    /*** Allows to edit a team from the database
     * @param TeamEdit $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TeamEdit $request){
        $team = Team::find($request->id);
        $team->name = $request->name;

        $result = $team->saveOrFail();
        $message = "L'équipe a bien été modifiée !";

        return back()->with(['result' => $result, 'message' => $message]);
    }

    /*** Allows to make an user leave a team
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(Request $request){
        User::findOrFail($request->id)->get(); //allow to check if the id exists (if not -> send 404)
        $result = DB::table('user_team')->where('user_id', $request->id)->delete();
        $message = "L'utilisateur a bien été retiré de l'équipe";

        return back()->with(['result' => $result, 'message' => $message]);
    }

    /*** Allows to add a team in the database
     * @param TeamSubmit $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function submit(TeamSubmit $request){
        $team = new Team();
        $team->name = $request->name;
        $result = $team->saveOrFail();
        $message = "L'équipe a bien été ajoutée !";

        return back()->with(['result' => $result, 'message' => $message]);
    }

}
