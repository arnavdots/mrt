<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//Trait
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
//Password Broker Facade
use Illuminate\Support\Facades\Password;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /*
	*	show forgot password form
	*   @return void
	*/
	
	public function showForgotForm(){
		return view('admin.auth.passwords.forgot-password');
	}
	
	/*
	*	change default forgot pasword function 
	*   @return void
	*/
	protected function broker(){
		return Password::broker('admins');
	}
}
