<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('message_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_phone'); // Nomor tujuan
            $table->string('message_type');    // Reminder, Morning Huddle, atau Friday Funday
            $table->text('content');           // Isi pesan yang dikirim
            $table->string('status');          // 'success' atau 'failed'
            $table->text('response_gateway')->nullable(); // Balasan dari API (untuk debug jika error)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_logs');
    }
};
