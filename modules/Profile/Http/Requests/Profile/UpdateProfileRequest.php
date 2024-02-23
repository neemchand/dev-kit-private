<?php

namespace Modules\Profile\Http\Requests\Profile;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date_format:Y-m-d'],
            'email' => ['email:rfc,dns', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
