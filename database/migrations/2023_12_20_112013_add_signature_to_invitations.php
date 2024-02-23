<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            // 'default' used only for avoiding not-null column errors if records already exist in the DB
            // removed in the next migration
            $table->string('signature', 64)->default(DB::raw('md5(random()::text)'));
        });
    }

    public function down(): void
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            $table->dropColumn('signature');
        });
    }
};
