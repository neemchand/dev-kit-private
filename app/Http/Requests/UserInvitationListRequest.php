<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserInvitationListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sortBy' => ['sometimes', Rule::in(['id', 'email', 'created_at', 'expires_at'])],
            'orderBy' => ['sometimes', Rule::in(['asc', 'desc'])],
            'perPage' => ['sometimes', 'integer'],
            'search' => ['sometimes', 'string', 'nullable']
        ];
    }
}
