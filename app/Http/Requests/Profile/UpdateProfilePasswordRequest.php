<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Auth;

class UpdateProfilePasswordRequest extends FormRequest
{
    protected $errorBag = 'updatePassword';

    protected function prepareForValidation()
    {
        // for new password validation purposes (containing email username)
        $this->merge([
            'email' => Auth::user()->email,
        ]);
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ];
    }
}
