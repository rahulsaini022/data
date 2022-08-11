<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        return '/';
    }

    // following function checks if user is active then login user
    protected function credentials(Request $request)
    {
        $field = $this->field($request);
        return [ $field => $request->{$this->username()}, 'password' => $request->password, 'active' => '1'];
        // return ['email' => $request->{$this->username()}, 'password' => $request->password, 'active' => '1'];
    }

    /**
     * Determine if the request field is email or username.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function field(Request $request)
    {
        $email = $this->username();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    // following function shows custom message to inactive users.
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        $field = $this->field($request);
        // Load user from database
        $user = User::where($field, $request->{$this->username()})->first();
        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && Hash::check($request->password, $user->password) && $user->active != 1) {
            $errors = [$this->username() => trans('auth.inactive',['user'=> $user->roles->pluck('name')[0]]), 'user_id' => $user->id, 'role'=> $user->roles->pluck('name')];
        }
        
        if($user && !Hash::check($request->password, $user->password)) {
            $errors = ['password' => trans('auth.invalid_password'), 'user_id' => $user->id, 'role'=> $user->roles->pluck('name')];
        }
    

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    // following function is used to redirect user based on role
    protected function authenticated($request, $user){
        if($user->hasRole('admin|super admin')){
            // return redirect('/admin');
            return redirect()->intended('/admin');
        } else {
            // return redirect('/');
            return redirect()->intended('/');
        }
    }

}
