<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function register(RegisterRequest $request){


        $name = $request->validated('name'); 
        $email = $request->validated('email'); 
        $password = Hash::make( $request->validated('password')); 

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

       $users = User::create($userData);

       if($users){
        $request->session()->regenerate();
        Auth::attempt($userData);
        return  to_route('blog.index');
       }

       return  to_route('auth.register')->with([
        'erreurInscription' => "Une erreur s'est produitre"
    ])->withInput(['email', 'name']);

       

        
    }
}
