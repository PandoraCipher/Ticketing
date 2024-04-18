<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function logout(){
        Auth::logout();
        return to_route('auth.login');
    }

    public function doLogin(loginRequest $request){
        $credential = $request->validated();

        if(Auth::attempt($credential)){
            $request->session()->regenerate();
            return redirect()->intended(route('tickets.list'));
        }

        return to_route('auth.login')->withErrors([
            'email' => 'email invalide'
        ])->onlyInput('email');
    }
}
