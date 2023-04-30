<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontendServices
{
    public function login($email_address, $password, $remember)
    {
        $credentials = ['email_address' => $email_address, 'password' => $password];

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            return $user;
        } else {
            return false;
        }
    }

    public function logout()
    {
        if (Auth()->user()->role == 0) {
            Auth::logout();
        }
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 0,
        ]);

        return $user;
    }
}
