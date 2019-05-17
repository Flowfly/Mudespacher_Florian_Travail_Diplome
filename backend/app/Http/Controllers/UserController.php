<?php

namespace App\Http\Controllers;

use App\AnswerUser;
use App\Http\Requests\UserEdit;
use App\Http\Requests\UserSubmit;
use App\User;
use App\Team;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    const NUMBER_OF_DISPLAYED_USERS_PER_PAGE = 10;
    //<editor-fold desc="Backoffice">
    public function getAll(Request $request)
    {
        return view('/backoffice/users_read', ['users' => isset($request->id) ? DB::table('teams')->select('users.*')->join('users', 'teams.id', 'users.id')->where('teams.id', '=', $request->id)->paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_USERS_PER_PAGE')) : User::paginate(Config::get('constants.backoffice.NUMBER_OF_DISPLAYED_USERS_PER_PAGE'))]);

    }

    public function editGetInfos(Request $request)
    {
        return view('/backoffice/users_update', ['user' => User::where('id', $request->id)->get()[0]]);
    }

    public function addGetInfos()
    {
        return view('/backoffice/users_add');
    }

    public function update(UserEdit $request)
    {
        $user = User::findOrFail($request->id);
        if (!empty($user)) {
            $user->username = isset($request->username) ? $request->username : $user->username;
            $user->password = isset($request->password) ? bcrypt($request->password) : $user->password;
            $user->email = isset($request->email) ? $request->email : $user->email;
            $user->phone_number = isset($request->phone) ? $request->phone : $user->phone;
            $user->name = isset($request->name) ? $request->name : $user->name;
            $user->surname = isset($request->surname) ? $request->surname : $user->surname;
            $user->date_of_birth = isset($request->date) ? $request->date : $user->date_of_birth;
            $result = $user->saveorFail();
            $message = "L'utilisateur a été modifié avec succès !";
            return back()->with(['result' => $result, 'message' => $message]);
        }
        return back()->withErrors(['user' => 'Utilisateur introuvable']);
    }

    public function delete(Request $request)
    {
        $result = $this->deleteUser($request);
        $message = $result ? "L'utilisateur a bien été supprimé !" : "Un problème est survenu, veuillez réessayer";

        return back()->with(['result' => $result, 'message' => $message]);
    }

    public function getUserInfos(Request $request)
    {
        return view('/backoffice/user_read')->with(['user' => User::where('id', $request->id)->with('teams')->firstOrFail()]);
    }



    public function submit(UserSubmit $request)
    {
        $userAdded = $this->addUser($request);
        return back()->with(['result' => $userAdded[0], 'message' => $userAdded[1]]);
    }

    public function generate()
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->username = "test$i";
            $user->password = bcrypt("Super");
            $user->email = "test$i@gmail.com";
            $user->phone_number = $i;
            $user->name = "test$i";
            $user->surname = "test$i";
            $user->date_of_birth = Carbon::today();
            $user->save();
        }
    }

    public function pdfCanvas()
    {
        return view('/backoffice/users_pdf', ['users' => User::all()]);
    }

    public function createPDF()
    {
        $data = ['users' => User::all()];
        $datetime = Carbon::now();
        $filename = $datetime->year . $datetime->month . $datetime->day . "_" . $datetime->hour . $datetime->minute . $datetime->second . $datetime->millisecond . "_user_list_.pdf";
        return PDF::loadView('/backoffice/users_pdf', $data)->setPaper('a4', 'landscape')->download($filename);
    }

    //</editor-fold>
    public function submitAPI(UserSubmit $request)
    {
        $userAdded = $this->addUser($request);
        $result = $userAdded[0];
        $message = $userAdded[1];
        $user = $userAdded[2];
        return response()->json(['status' => $result ? 'success' : 'error', 'message' => $result ? ['user' => [$message]] : $message, 'user' => $result ? $user : '']);
    }

    public function deleteAPI(Request $request){
        $result = $this->deleteUser($request);
        return response()->json(['status' => $result ? 'success': 'error', 'message' => $result ? "L'utilisateur a bien été supprimé !" : "Une erreur s'est produite lors de la suppression de l'utilisateur."], $result ? 200 : 422);
    }

    private function addUser(UserSubmit $request): array
    {
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email = isset($request->email) ? $request->email : null;
        $user->phone_number = isset($request->phone) ? $request->phone : null;
        $user->name = isset($request->name) ? $request->name : null;
        $user->surname = isset($request->surname) ? $request->surname : null;
        $user->date_of_birth = isset($request->date) ? $request->date : null;
        $result = $user->saveorFail();
        $message = "L'utilisateur a été ajouté avec succès !";
        return [$result, $message, $user];
    }
    private function deleteUser(Request $request){
        $userToDelete = User::findOrFail($request->id);
        $result = $userToDelete->delete();
        return $result;
    }

}
