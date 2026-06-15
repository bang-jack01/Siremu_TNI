<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pakai try-catch agar jika PostgreSQL mendeteksi duplikat, errornya diabaikan dan migrasi tetap lanjut
        try {
            if (!Schema::hasColumn('users', 'role')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('role')->default('user');
                });
            }
        } catch (\Exception $e) {
            // Biarkan kosong agar sistem tidak crash
        }
    }

    public function down(): void
    {
        try {
            if (Schema::hasColumn('users', 'role')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('role');
                });
            }
        } catch (\Exception $e) {
            // Biarkan kosong
        }
    }
};