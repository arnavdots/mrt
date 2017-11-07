<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\MrtModels\User;
use Modules\Branch\Entities\Branch;
use Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;
    protected $redirectTo = 'admin/home';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
	
	 /**
     * Use for show login form
     *
     * @return void
     */
    public function showLoginForm()
    {        
        if (auth()->guard('admin')->user()) return redirect()->route('admin.dashboard');
        return view('admin.auth.login');
    }
     /**
     * Log in user in the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $this->validateLogin($request);        
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        //return $request->only($this->username(), 'password');
        $credentials = $request->only($this->username(), 'password');
        $credentials['is_active'] = 1;
        //$credentials['is_deleted'] = 0;
        $credentials['deleted_at'] = NULL;
        return $credentials;
    }


    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();
        // Check if user was successfully loaded, that the password matches
        // and is_active is not 1. If so, override the default error message.
        // User ip to check branch ip
//        $ip = $request->ip();
        $ip = $request->ip();
        $brancheIps = Branch::pluck('branch_ip')->toArray();
        
        if ($ip && in_array($ip, $brancheIps)) {
            $errors = [$this->username() => trans('auth.notaccip')];
        }else if ($user && \Hash::check($request->password, $user->password) && $user->is_active != 1) {
            $errors = [$this->username() => trans('auth.notactivated')];
        }else if($user && \Hash::check($request->password, $user->password) && $user->deleted_at != NULL){  //  && $user->is_deleted != 0
            $errors = [$this->username() => trans('auth.accdeleted')];
        } 
        
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

}
