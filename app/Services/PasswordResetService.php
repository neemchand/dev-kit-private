<?php

namespace App\Services;

use Carbon\Carbon;
use DB;
use Hash;

class PasswordResetService
{
    public function verify(string $email, string $signature)
    {
        $token = DB::table(config('auth.passwords.users.table'))
            ->where('email', $email)
            ->where('created_at', '>=', Carbon::now()->subMinutes(config('auth.passwords.users.expire')))
            ->first();

        return !is_null($token) && Hash::check($signature, $token->token);
    }
}
