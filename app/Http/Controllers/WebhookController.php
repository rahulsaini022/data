<?php
namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as StripeWebhookController;
use App\User;

class WebhookController extends StripeWebhookController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $user->subscriptions->filter(function ($subscription) use ($payload) {
                return $subscription->stripe_id === $payload['data']['object']['id'];
            })->each(function ($subscription) use ($user) {
                $subscription->markAsCancelled();
                // to make user inactive once subscription cancelled
                if($subscription->name=='main'){
                    // $updateuser = User::find($subscription->user_id);
                    $updateuser=$user;
                    if($updateuser && $subscription->name=='main'){
                        $updateuser->active='0';
                        $updateuser->save();
                    }
                }
            });
        }

        return $this->successMethod();
    }
}