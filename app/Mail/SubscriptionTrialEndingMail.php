<?php

namespace App\Mail;

class SubscriptionTrialEndingMail extends BaseEmail
{
    public $view = 'emails.subscription-trial-ending';

    protected function createSubject()
    {
        $this->subject = __('messages.subscription.trial_ending_subject');
    }
}
