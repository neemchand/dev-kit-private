<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityLogListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sortBy' => ['sometimes', Rule::in(['id', 'causer_id', 'subject_id'])],
            'orderBy' => ['sometimes', Rule::in(['asc', 'desc'])]
        ];
    }
}
