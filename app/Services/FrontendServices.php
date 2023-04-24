<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

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
        if(Auth()->user()->role == 0){
            Auth::logout();
        }
    }
}
