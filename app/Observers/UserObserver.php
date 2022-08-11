<?php

namespace App\Observers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $myPassword=Session::get('entered_password');
        $is_client=Session::get('is_client');
        if(isset($is_client) && $is_client==true){
            Session::forget('is_client');
        } else {    
            Session::forget('entered_password');
            $myPassword = md5($myPassword);

            $loginkey = str_random(50);
            $salt = str_random(8);
            $usergroup = 2;
            $regdate =Carbon::now()->timestamp; // Produces something like 1552296328;

            $myPassword = md5(md5($salt).$myPassword);

            $info = array(
               'username' => $user->username,
               'password' => $myPassword,
               'email' => $user->email,
               'receivepms' => 1,
               'pmnotify' => 1,
               'salt' => $salt,
               'loginkey' => $loginkey,
               'usergroup' => $usergroup,
               'regdate' => $regdate,
               'signature' => "",
               'buddylist' => "",
               'ignorelist' => "",
               'pmfolders' => "",
               'notepad' => "",
               'usernotes' => "",
            );
            // echo "<pre>"; print_r($info);die;
            DB::table('mybb_users')->insert($info);
        }    
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
