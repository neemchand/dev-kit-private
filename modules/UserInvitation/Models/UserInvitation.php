<?php

namespace Modules\UserInvitation\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;

class UserInvitation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    use Searchable;

    protected $fillable = [
        'email',
        'signature',
        'expires_at'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function searchableAttributes(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
