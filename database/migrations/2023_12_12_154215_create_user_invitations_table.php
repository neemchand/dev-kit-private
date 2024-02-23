<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_invitations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('email', 255);
            $table->dateTime('expires_at');
            $table->foreignIdFor(Role::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_invitations');
    }
};
