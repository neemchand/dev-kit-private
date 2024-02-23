<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class UserCreateCommand extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Create User';

    public function handle(): void
    {
        $email = $this->ask('E-mail', 'admin@founderandlightning.com');
        $firstName = $this->ask('First name', 'Example');
        $lastName = $this->ask('Last name', 'Example');
        $password = $this->secret('Password');
        $superAdmin = config('constants.roles.super_admin');
        $roles = array_values(config('constants.roles'));
        $rolesPrint = join(", ", $roles);
        $role = $this->askWithCompletion("Role (possible: $rolesPrint)", $roles, $superAdmin);
        $validator = Validator::make([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => $password
        ], [
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:' . User::class],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'password' => ['required', Rules\Password::defaults()]
        ]);
        if ($validator->fails()) {
            $this->info('User not created. See error messages below:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }
        User::create([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ])->assignRole($role);
    }
}
