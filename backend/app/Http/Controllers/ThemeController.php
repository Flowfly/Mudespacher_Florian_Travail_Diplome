<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        return view('/backoffice/theme');
    }

    public function changeImage(Request $request){
        if($request->file('image')->isValid()){
            $filename = $request->imageName . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('/', $filename, 'quiz');
        }
        return back()->with(['result' => 'success', 'message' => 'Image changée avec succès !']);
    }
}
