<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('message');           // isi pesan notifikasi
            $table->boolean('is_read')->default(false); // status sudah dibaca/belum
            $table->timestamps();                // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
