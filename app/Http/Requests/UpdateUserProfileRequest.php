<?php

namespace App\Http\Requests;

use Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => request()->id ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists('users', 'id')],
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'role' => ['sometimes', 'required', 'string', Rule::in(Config::get('constants.roles'))],
        ];
    }
}
