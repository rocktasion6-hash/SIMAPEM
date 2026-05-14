<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_complaint_histories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained('complaints')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Siapa yang melakukan update status (FO/Kasi/Pelaksana)
            $table->string('status'); // Status yang diupdate
            $table->text('notes')->nullable(); // Tanggapan atau catatan petugas
            $table->string('action_photo_path')->nullable(); // Bukti foto tindakan dari Pelaksana
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_histories');
    }
};