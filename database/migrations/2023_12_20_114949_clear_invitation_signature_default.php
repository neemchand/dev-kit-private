<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            $table->string('signature', 64)->nullable(false)->default(null)->change();
        });
    }

    public function down(): void
    {
        // for some reason, change() doesn't accept expressions as default value, hence DB raw statement instead
        DB::statement("ALTER TABLE user_invitations ALTER COLUMN signature SET DEFAULT md5(random()::text)");
    }
};
