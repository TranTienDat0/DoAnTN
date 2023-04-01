<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthServices;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    //use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function ViewForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }
   
    public function sendResetLinkEmail(Request $request, AuthServices $AuthServices)
    {
        //$this->validateEmail($request);

        $sent = $AuthServices->sendResetLinkEmail($request->email);

        if ($sent) {
            return back()->with('status', 'We have emailed your password reset link!');
        } else {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }
    }
}
