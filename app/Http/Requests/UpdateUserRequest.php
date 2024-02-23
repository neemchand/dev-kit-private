<?php

namespace App\Http\Requests;

use App\Models\User;
use Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        $user = $this->route()->parameter('user');
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['email:rfc,dns', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'role' => ['nullable', 'array'],
            'role.*' => ['string', Rule::in(Config::get('constants.roles'))],
        ];
    }
}
