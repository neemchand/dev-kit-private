<?php

namespace App\Http\Requests;

use App\Models\UserInvitation;
use Illuminate\Foundation\Http\FormRequest;

class UserInvitationDeleteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id')]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'int', 'exists:' . UserInvitation::class . ',id,deleted_at,NULL'],
        ];
    }
}
