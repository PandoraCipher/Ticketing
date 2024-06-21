<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Department;
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

    public function doLogin(LoginRequest $request){
        $credential = $request->validated();

        if(Auth::attempt($credential)){
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return to_route('auth.login')->withErrors([
            'email' => 'email or password invalide'
        ])->onlyInput('email');
    }

    public function showSignupForm()
    {
        $departments = Department::all();
        
        return view('auth.signup', ['departments' => $departments]);
    }
}
