<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function getAll(){
        return view('/backoffice/teams_read', ['teams' => Team::with('users')->get()]);
    }

    public function addGetInfos(){
        return view('/backoffice/teams_add');
    }

    public function editGetInfos(Request $request)
    {
        return view('/backoffice/teams_update', ['team' => Team::findOrFail($request->id)->with('users')->get()[0]]);
    }

    public function update(Request $request){
        $request->validate($this->getRules(true));

        $team = Team::find($request->id);
        $team->name = $request->name;

        $result = $team->saveOrFail();
        $message = "L'équipe a bien été modifiée !";

        return back()->with(['result' => $result, 'message' => $message]);
    }

    public function deleteUser(Request $request){
        User::findOrFail($request->id)->get(); //allow to check if the id exists (if not -> send 404)
        $result = DB::table('user_team')->where('user_id', $request->id)->delete();
        $message = "L'utilisateur a bien été retiré de l'équipe";

        return back()->with(['result' => $result, 'message' => $message]);
    }

    public function submit(Request $request){
        $request->validate($this->getRules(false));

        $team = new Team();
        $team->name = $request->name;
        $result = $team->saveOrFail();
        $message = "L'équipe a bien été ajoutée !";

        return back()->with(['result' => $result, 'message' => $message]);
    }

    public function getRules($isEditing){
        return [
          'name' => ['min:3', 'max:15', 'required', 'string', $isEditing ? '' : 'unique:teams,name']
        ];
    }
}
