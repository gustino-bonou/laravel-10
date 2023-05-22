<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Hash;

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

            return redirect()->intended(route('home'));
        }
        

        return to_route('auth.login')->withErrors([
            'email' => "Identifiants incorrects"
        ])->onlyInput('email');
    }

    public function register()
    {
        return view('auth.formRegister');
    }
    public function doRegister(RegisterRequest $request)
    {

        $data = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ];
        User::create($data);

        return view('auth.loginForm');
    }

    public function logout() {
        Auth::logout();

        return to_route('auth.login');
    }

    public function formRegister(){

        return view('auth.formRegister');
    }
}
