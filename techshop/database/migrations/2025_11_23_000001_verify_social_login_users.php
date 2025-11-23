<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tự động xác thực email cho tất cả user đăng nhập qua Google/Facebook
        DB::table('users')
            ->whereNotNull('provider')
            ->whereIn('provider', ['google', 'facebook'])
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Không cần rollback
    }
};
