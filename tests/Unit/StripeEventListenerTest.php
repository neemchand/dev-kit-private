<?php

use App\Listeners\StripeEventListener;
use App\Mail\SubscriptionTrialEndingMail;
use Laravel\Cashier\Events\WebhookReceived;

test('Customer created event', function () {
    $user = createRawUser();
    $event = new WebhookReceived([
        'type' => 'customer.created',
        'data' => [
            'object' => [
                'id' => fake()->uuid,
                'email' => $user->email,
            ],
        ],
    ]);
    $listener = new StripeEventListener();
    $listener->handle($event);
    $user->refresh();
    expect($user)->stripe_id->not->toBeNull();
});


test('Customer subscription trial will end event', function () {
    Mail::fake();
    $user = createRawUser();
    $stripe_id = fake()->uuid;
    $user->stripe_id = $stripe_id;
    $user->trial_ends_at = now()->addDay();
    $user->save();

    $event = new WebhookReceived([
        'type' => 'customer.subscription.trial_will_end',
        'data' => [
            'object' => [
                'customer' => $stripe_id
            ],
        ],
    ]);
    $listener = new StripeEventListener();
    $listener->handle($event);
    $user->refresh();
    Mail::assertQueued(SubscriptionTrialEndingMail::class);
});
