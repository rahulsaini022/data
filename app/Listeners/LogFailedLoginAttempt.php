<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Userloginreport;
class LogFailedLoginAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        if($event->user){
            $event->user->last_failed_login= now();
            $event->user->save();
            $user_login=array(
                'user_id' => $event->user->id,
                'last_failed_login' => now(),
            );
            Userloginreport::create($user_login);
        }
    }
}
