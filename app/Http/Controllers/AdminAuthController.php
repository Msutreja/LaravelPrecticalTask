<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->first();

        if ($user->role !== 'admin') {
            return back()->with('error', 'You are not allowed to login from here.');
        }

        if (is_null($user->email_verified_at)) {
            return back()->with('error', 'Please verify your email before logging in.');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Access denied.');
        }

        return view('admin.dashboard');
    }

}
