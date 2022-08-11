<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Auth;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    
    public function render($request, Exception $exception)
    {
        // redirect user to login page if user logs out due to inactivity
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            if($request->getRequestUri()==='/logout'){
             
                auth()->logout();
            
                return redirect()->route('login');
            }
            // if($request->getRequestUri()==='/login'){            
                return redirect()->route('login')->with('error', 'Session Expired. Please Login Again.');
            // }
 
        }

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            // return response()->json(['User do not have permission to access this page.']);
            if(Auth::user()){
            // if user is logged in and do not have permission to access this page 
                abort(404);
            } else {
                // if user is logged out and do not have permission to access this page 
                return redirect('/login');
            }
        }
     
        return parent::render($request, $exception);
    }
}
