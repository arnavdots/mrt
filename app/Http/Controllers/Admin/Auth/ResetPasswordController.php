<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
    
    //Show form to seller where they can save new password
    public function showResetForm(Request $request, $token = null)
    {
       return view('admin.auth.passwords.reset-password')->with(
            ['token' =>$token, 'email' => $request->email]
        );
    }
    
    //returns Password broker of seller
    public function broker()
    {
        return Password::broker('admins');
    }

    //returns authentication guard of seller
    protected function guard()
    {
        return Auth::guard('admin');
    }
	
}
