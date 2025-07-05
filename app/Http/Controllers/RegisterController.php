<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\SendVerificationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showCustomerForm()
    {
        return view('register.register_customer');
    }

    public function showAdminForm()
    {
        return view('register.register_admin');
    }

    public function registerCustomer(RegisterRequest $request)
    {
        $verification_code = rand(100000, 999999);

        session([
            'temp_user_data_customer' => [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'role'       => 'customer',
                'verification_code' => $verification_code,
            ]
        ]);

        Mail::to($request->email)->send(new SendVerificationCode($verification_code));

        return view('register.verify_otp');

    }

    public function registerAdmin(RegisterRequest $request)
    {
        $verification_code = rand(100000, 999999);

        session([
            'temp_user_data_admin' => [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'role'       => 'admin',
                'verification_code' => $verification_code,
            ]
        ]);

        Mail::to($request->email)->send(new SendVerificationCode($verification_code));

        return view('register.verify_otp');
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->input('otp');
        $tempData = session('temp_user_data_customer') ?? session('temp_user_data_admin');

        $tempData = session('temp_user_data_customer') ?? session('temp_user_data_admin');
        $sessionKey = session('temp_user_data_customer') ? 'temp_user_data_customer' : 'temp_user_data_admin';

        if (!$tempData || $otp != $tempData['verification_code']) {
            return redirect()->back()->with('error', 'Invalid OTP.');
        }

        User::create([
            'first_name'         => $tempData['first_name'],
            'last_name'          => $tempData['last_name'],
            'email'              => $tempData['email'],
            'password'           => $tempData['password'],
            'role'               => $tempData['role'],
            'verification_code'  => $tempData['verification_code'],
            'email_verified_at'  => now(),
        ]);

        session()->forget($sessionKey);

        $role = ucfirst($tempData['role']);

        if ($role === 'admin') {
            return redirect()->route('register.admin')->with('success', 'Admin registered successfully.');
        } else {
            return redirect()->route('register.customer')->with('success', 'Customer registered successfully.');
        }
    }

}
