<?php

namespace Modules\UserInvitation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\UserInvitation\Models\UserInvitation;

class UserInvitationDeleteRequest extends FormRequest
{
    protected function prepareForValidation(): void
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
