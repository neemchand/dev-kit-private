<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProfileRequest extends FormRequest
{
    protected $errorBag = 'userDeletion';

    public function rules(): array
    {
        return [
            'password' => ['required', 'current_password'],
        ];
    }
}
