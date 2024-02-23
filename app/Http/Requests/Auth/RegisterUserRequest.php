<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Services\UserInvitationService;
use Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisterUserRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower($this->email),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'invitation_key' => [
                'required_without:email',
                'string',
                'size:64',
                function ($attribute, $value, $fail) {
                    $invitation = (new UserInvitationService())->getBySignature($value);

                    if (is_null($invitation)) {
                        $fail(__('messages.invitation.invalid_or_expired', ['attribute' => $attribute]));
                        return;
                    }

                    $user = User::where('email', $invitation->email)->first();
                    if (!is_null($user)) {
                        $invitation->delete();
                        $fail(__('messages.invitation.user_already_exists', ['attribute' => $attribute]));
                    }
                }
            ],
            'email' => [
                'required_without:invitation_key',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:' . User::class
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'array'],
            'role.*' => ['string', Rule::in(Config::get('constants.roles'))],
        ];
    }
}
