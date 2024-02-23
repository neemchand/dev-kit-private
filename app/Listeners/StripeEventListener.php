<?php

namespace App\Listeners;

use App\Mail\SubscriptionTrialEndingMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    public function handle(WebhookReceived $event): void
    {
        $data = $event->payload['data']['object'];
        if ($event->payload['type'] === 'customer.created') {
            $customerId = $data['id'];
            $email = $data['email'];
            $user = User::where(['email' => $email])->first();
            if ($user) {
                $user->stripe_id = $customerId;
                $user->save();
            }
        }

        if ($event->payload['type'] === 'customer.subscription.trial_will_end') {
            $user = Cashier::findBillable($data['customer']);
            if ($user) {
                $data = [
                    'name' => $user->first_name,
                    'trial_ending_date' => $user->trialEndsAt()->format('d/m/Y')
                ];
                Mail::to($user['email'])->send(new SubscriptionTrialEndingMail($data));
            }
        }
    }
}
