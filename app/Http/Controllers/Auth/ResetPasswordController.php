<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
       
       if($user->active == 1)
       {
            $this->guard()->login($user);
       }
       else{
        return redirect()->back();
       }
        
    }
//     public function reset(Request $request)
// {
//     $this->validate($request, $this->rules(), $this->validationErrorMessages());

//     // Here we will attempt to reset the user's password. If it is successful we
//     // will update the password on an actual user model and persist it to the
//     // database. Otherwise we will parse the error and return the response.
//     $response = $this->broker()->reset(
//         $this->credentials($request), function ($user, $password) {
//             $this->resetPassword($user, $password);
//         }
//     );
// dd($request);
    
//     return redirect()->back()->with('success','Your password changed successfully.Continue to login ');
// }
}
