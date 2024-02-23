<?php

use App\Mail\SubscriptionTrialEndingMail;

test('Subscription trial ending mail', function () {
    $user = createRawUser();
    $user->trial_ends_at = now()->addDay();
    $user->save();
    $data = [
        'name' => $user->first_name,
        'trial_ending_date' => $user->trialEndsAt()->format('d/m/Y')
    ];
    (new SubscriptionTrialEndingMail($data))->to(fake()->email)
        ->assertFrom(config('mail.from.address'), config('mail.from.name'))
        ->assertHasSubject(__('messages.subscription.trial_ending_subject'))
        ->assertSeeInHtml($user->first_name)
        ->assertSeeInHtml($user->trialEndsAt()->format('d/m/Y'));
});
