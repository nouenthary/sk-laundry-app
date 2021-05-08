<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login.index');
    }

    public function login(Request $request){

        $user = array(
            'username' => $request->get('username') ,
            'password' => $request->get('password')
        );

        if (Auth::attempt($user))
        {
            return redirect('/');
        }
        else
        {
            return redirect()->back();
        }
    }
}
