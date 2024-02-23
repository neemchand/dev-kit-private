<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Frontend values
     |--------------------------------------------------------------------------
     |
     | Here you can specify all values needed for frontend purposes
     |
     */

    'verified_email_success_redirect' => '/account/confirmed',
    'verified_email_fail_redirect' => '/expired/signup-verification',
    'invitation_success_redirect' => '/account/password-create',
    'invitation_fail_redirect' => '/account/signup-verification-expired',
    'password_reset_success_redirect' => '/account/password-reset',
    'password_reset_fail_redirect' => '/expired/password-reset',
];
