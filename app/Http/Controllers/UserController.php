<?php

namespace App\Http\Controllers;

use App\AnswerUser;
use App\Session;
use App\User;
use App\Team;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //<editor-fold desc="Backoffice">
    public function getAll(Request $request)
    {
        return view('/backoffice/users_read', ['users' => isset($request->id) ? Team::where('id', $request->id)->with('users')->firstOrFail()->users : User::all()]);

    }

    public function editGetInfos(Request $request)
    {
        return view('/backoffice/users_update', ['user' => User::where('id', $request->id)->get()[0]]);
    }

    public function addGetInfos()
    {
        return view('/backoffice/users_add');
    }

    public function update(Request $request)
    {
        //dd($this->getRules(true));
        $user = User::where('id', $request->id)->get()[0];
        if (!empty($user)) {
            $request->validate($this->getRules(true));
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

    public function getUserInfos(Request $request)
    {
        return view('/backoffice/user_read')->with(['user' => User::where('id', $request->id)->with('teams')->firstOrFail()]);
    }

    public function submit(Request $request)
    {
        $request->validate($this->getRules(false));

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
        return
            $request->route()->getName() == 'backoffice_user_add' ? back()->with(['result' => $result, 'message' => $message])
                : response()->json(['status' => $result ? 'success' : 'error', 'message' => $message]);
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

    public function getRules($isEditing)
    {
        return [
            'username' => ['required', 'min:4', 'max:15', 'string', $isEditing ? '' : 'unique:users,username'],
            'password' => ['nullable', 'min:5', 'max:20', 'confirmed'],
            'email' => ['email', $isEditing ? '' : 'unique:users,email', 'nullable'],
            'phone' => ['string', 'nullable'],
            'name' => ['min:2', 'max:30', 'string', 'nullable'],
            'surname' => ['min:2', 'max:30', 'string', 'nullable'],
            'date' => ['date', 'nullable']
        ];
    }
    //</editor-fold>

}
