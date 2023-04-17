<?php

namespace App\Services;

use App\Models\banners;
use App\Models\categories;
use App\Models\products;
use Illuminate\Support\Facades\Auth;

class FrontendServices
{
    public function login($email_address, $password, $remember)
    {
        $credentials = ['email_address' => $email_address, 'password' => $password, 'status' => 1];

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            return $user;
        } else {
            return false;
        }
    }
}
