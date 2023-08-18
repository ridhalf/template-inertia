<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\Session;

class AuthController extends Controller
{
    public function login(Request $request){
        $data = [
            'email' => $request->email,
            'password' =>$request->password
        ];
        if (Auth::Attempt($data)) {
            return redirect('/')->with('success','login berhasil');
        }else{
            \Illuminate\Support\Facades\Session::flash('error', 'Email atau Password Salah');
            return redirect('/login');
        }
    }
}
