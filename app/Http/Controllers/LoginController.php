<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login.index');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:32'
        ], [
            'email.required'    => 'Please enter your email',
            'email.email'       => 'Invalid "Email" format',
            'password.required' => 'You must enter your password',
            'password.min'      => '"Password" must have at least 6 characters',
            'password.max'      => '"Password" cannot longer than 32 characters'
        ]);
        $remember = $request->has('remember') ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            Log::info('Welcome back: '. $request->email. '. Have a good time with us!');
            return redirect()->route('dashboard');
        } else {
            Log::error('Login failed');
            return redirect()->route('login')->with('status_error', 'Login failed, please try again!' );
        }
    }

    public function getLogout() {
        Auth::logout();
        return redirect()->route('login');
    }

}
