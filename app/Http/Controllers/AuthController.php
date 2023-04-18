<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function formLogin(){
        return view('auth.loginForm');
    }

    public function login(LoginRequest $request) {

        $creadentials = $request->validated();

       if(Auth::attempt($creadentials)) 

        {
            $request->session()->regenerate();

            return redirect()->intended(route('blog.index'));
        }
        

        return to_route('auth.login')->withErrors([
            'email' => "Identifiants incorrects"
        ])->onlyInput('email');
    }

    public function logout() {
        Auth::logout();

        return to_route('auth.login');
    }

    public function formRegister(){

        return view('auth.formRegister');
    }
}
