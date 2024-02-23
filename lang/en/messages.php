<?php

return [
    'user' => [
        'registered' => 'User registered successfully.',
        'updated' => 'User updated successfully.',
        'deleted' => 'User deleted successfully.',
        'logged_in' => 'User logged in successfully.',
        'logged_out' => 'User logged out successfully.',
        'email_verified' => 'User e-mail marked as verified',
        'verification_link_sent' => 'Verification link sent',
        'email_already_verified' => 'User e-mail already marked as verified',
        'email_not_verified' => 'Your email address is not verified.',
        'cannot_remove_yourself' => 'You cannot remove yourself',
        'forgot_password_instruction' => 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
        'remove_account_confirmation' => 'Are you sure you want to delete this account?',
        'remove_account_consequences' => 'Once account is deleted, all of its resources and data will be permanently deleted.',
        'search_error' => 'Search error',
    ],
    'profile' => [
        'updated' => 'Profile updated successfully.',
        'updated_with_email' => 'Profile updated successfully. Check your inbox to verify email',
        'deleted' => 'Profile deleted successfully.',
        'remove_account_confirmation' => 'Are you sure you want to delete your account?',
        'remove_account_consequences' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
        'image' => [
            'accepted' => "Profile image accepted",
            'upload_fail' => "Profile image upload failed",
            'delete_success' => "Profile image deleted successfully",
            'delete_fail' => "Profile image delete failed",
            'notification' => [
                'update_success' => "Notification(s) updated successfully",
                'update_fail' => "Notification update failed",
                'not_set_yet' => 'You haven’t updated your profile picture, login and let other users see what you look like',
                'thank_you' => 'Thank you for using our application!',
                'not_set_yet_title' => 'Kindly request'
            ]
        ]
    ],
    'subscription' => [
        'no_subscription' => 'No subscription',
        'trial_ending_subject' => 'Subscription Trial Ending'
    ],
    'notification' => [
        'success' => 'Success!',
        'successfully_created' => 'Successfully created!',
        'successfully_updated' => 'Successfully updated!',
        'successfully_deleted' => 'Successfully deleted!',
        'fail' => 'Fail!'
    ],
    'error' => [
        'no_rights_to_dashboard' => 'You have no rights to login to Dashboard',
        'check_inbox_and_verify' => 'Check your inbox and verify e-mail',
        'too_many_attempts' => 'Too Many Attempts',
        'access_denied' => 'Access Denied',
    ],
    'mail' => [
        'confidential' => 'This email is confidential. If you have received it in error, please delete it. The contents of this email do not constitute a commitment by Founder and Lightning, unless separately endorsed by an authorised representative of Founder and Lightning. Although Founder and Lightning takes care to protect our systems from electronic virus attacks, we give no warranty that this email message (including any attachments) is free of any virus or other harmful matter and accept no responsibility for loss or damage resulting from the recipient receiving or opening an email from us. If you think that an email purportedly sent by the business is suspicious, please contact Founder and Lightning to verify if the email is legitimate. Founder and Lightning is the trading name of ucreate Limited, a company registered in England and Wales (Company No. 08503849) at Dalton House, 60 Windsor Avenue, London, England, SW19 2RR. Our Privacy Policy may be viewed here',
        'privacy_policy' => 'Privacy Policy'
    ],
    'feature' => [
        'toggle_confirmation' => 'Are you sure you want to change value of this feature flag?',
        'name_cannot_be_empty' => 'Feature name cannot be empty',
        'name_already_exists' => 'Feature with that name already exists',
        'remove_feature_confirmation' => 'Are you sure you want to delete this feature?',
    ],
    'invitation' => [
        'created' => 'Invitation created for :email, active until :expiration.',
        'deleted' => 'Invitation deleted.',
        'invalid_or_expired' => 'The :attribute is invalid or expired.',
        'user_already_exists' => 'The :attribute points to a user that already exists in the database. Invitation will be invalidated.',
        'not_found_for_invalidation' => 'Correct invitation not found for invalidation',
        'mail' => [
            'subject' => 'You are invited to register at :service',
            'content' => ':admin_name has invited you to join :service as a :user_role. Join them to collaborate and reach new productivity peaks.',
            'action' => 'Accept invitation',
        ]
    ],
    'resource' => [
        'deleted' => 'Resource deleted successfully.',
        'not_found' => 'Resource not found.',
        'cannot_delete_self' => 'You cannot delete yourself.',
    ]
];
