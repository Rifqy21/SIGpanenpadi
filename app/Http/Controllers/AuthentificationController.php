<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthentificationController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/validateRole');
        }

        return back()->with('error', 'Email or Password is wrong');
    }

    public function validateRole()
    {
        // if user role is 'user' then redirect to dashboard
        $user = Auth::user();
        if ($user->role == 'user') {
            return redirect('/user')->with('success', 'Login Success');
        } elseif ($user->role == 'admin') {
            return redirect('/admin')->with('success', 'Login Success');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
