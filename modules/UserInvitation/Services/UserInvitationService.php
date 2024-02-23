<?php

namespace Modules\UserInvitation\Services;

use Modules\UserInvitation\Models\UserInvitation;
use App\Notifications\UserInvitationCreated;
use Carbon\Carbon;
use DateTime;
use Spatie\Permission\Models\Role;
use Str;

class UserInvitationService
{
    public function create(array $data): UserInvitation
    {
        UserInvitation::where('email', $data['email'])->delete(); // invalidate previous by SoftDelete

        $expiration = (new DateTime())->modify('+' . config('constants.user.invitation_lifetime') . ' minutes');
        $signature = bin2hex(openssl_random_pseudo_bytes(32));

        $invitation = new UserInvitation([
            'email' => $data['email'],
            'expires_at' => $expiration,
            'signature' => $signature,
        ]);
        $invitation->role_id = Role::where('name', $data['role'])->first()->id;

        $invitation->save();

        $invitation->notify(
            new UserInvitationCreated(
                auth()->user()->fullName,
                Str::headline($data['role'])
            )
        );

        return $invitation;
    }

    public function invalidate(int $id): int
    {
        return UserInvitation::where('id', $id)->delete();
    }

    public function getBySignature(string $signature): ?UserInvitation
    {
        return UserInvitation::where('signature', $signature)
            ->where('expires_at', '>=', Carbon::now())
            ->first();
    }
}
