<?php

namespace App\Http\Controllers;

use App\BackofficeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackofficeUserController extends Controller
{
    public function homeLogin(){
        if(\auth()->check())
            return redirect('/backoffice/');

        return view('backoffice/login');
    }
    public function homeRegister()
    {
        if(\auth()->check())
            return redirect('/backoffice/');

        return view('/backoffice/register');
    }

    public function register(Request $request){
        $request->validate($this->getRules(false));

        $user = new BackofficeUser();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role_id = 3;
        $result = $user->saveOrFail();

        if($result){
            auth()->attempt([
                'username' => $request->username,
                'password' => $request->password,
            ]);
                return redirect('/backoffice/');
        }

    }

    public function login(Request $request)
    {
        $request->validate($this->getRules(true));
        $auth = auth()->attempt([
           'username' => $request->username,
           'password' => $request->password,
        ]);
        if($auth)
            return redirect('/backoffice');
        else
            return redirect('/backoffice/login')->withInput()->withErrors([
                'username' => 'Identifiants incorrects'
            ]);
    }

    public function logout(){
        auth()->logout();
        return redirect('/backoffice/login');
    }

    public function myAccount(){
        return view('/backoffice/account');
    }

    public function changeTheme(Request $request)
    {
        switch ($request->theme)
        {
            case 1:
                $theme = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css";
                $integrity = "sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T";
                break;
            case 2:
                $theme = "https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/darkly/bootstrap.min.css";
                $integrity = "sha384-w+8Gqjk9Cuo6XH9HKHG5t5I1VR4YBNdPt/29vwgfZR485eoEJZ8rJRbm3TR32P6k";
                break;
            case 3:
                $theme = "https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/flatly/bootstrap.min.css";
                $integrity = "sha384-T5jhQKMh96HMkXwqVMSjF3CmLcL1nT9//tCqu9By5XSdj7CwR0r+F3LTzUdfkkQf";
                break;
            case 4:
                $theme = "https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/slate/bootstrap.min.css";
                $integrity = "sha384-FBPbZPVh+7ks5JJ70RJmIaqyGnvMbeJ5JQfEbW0Ac6ErfvEg9yG56JQJuMNptWsH";
        }
        $request->session()->put('theme', $theme);
        $request->session()->put('integrity', $integrity);
        return back();
    }

    public function changePassword(Request $request){
        $request->validate($this->getRules(false));
        $user = \auth()->user();
        $user->password = bcrypt($request->password);
        $result = $user->saveOrFail();
        $message = "Mot de passe modifié avec succès !";
        return back()->with(['result' => $result, 'message' => $message]);
    }

    public function getRules($isTryingToLogIn)
    {
        return [
            'username' => ['min:4', 'max:15', auth()->check() ? '' : 'required', 'string', $isTryingToLogIn ? '' : 'unique:backoffice_users,username'],
            'password' => ['min:5', 'max:20', 'required', $isTryingToLogIn ? '' : 'confirmed'],
            'password_confirmation' => $isTryingToLogIn ? '' : ['required'],
        ];
    }
}
