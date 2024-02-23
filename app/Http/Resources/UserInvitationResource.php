<?php

namespace App\Http\Resources;

use App\Models\UserInvitation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin UserInvitation */
class UserInvitationResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'expires_at' => $this->expires_at,
            'role' => $this->role->name,
        ];
    }
}
