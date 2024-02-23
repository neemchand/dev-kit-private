<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('UPDATE users SET email=LOWER(email)');
    }

    // no "down", data manipulation migration
};
