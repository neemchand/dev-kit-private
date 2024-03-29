<?php

namespace Modules\Profile\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['uuid', 'exists:notifications,id,notifiable_id, ' . auth()->user()->id]
        ];
    }
}
