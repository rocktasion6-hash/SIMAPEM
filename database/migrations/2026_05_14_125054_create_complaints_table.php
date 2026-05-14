<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_complaints_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique(); // Kode unik resi pengaduan
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Relasi ke Pelapor
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete(); // Diisi oleh FO nanti
            $table->string('title');
            $table->text('description');
            $table->string('photo_path')->nullable(); // Bukti foto dari warga
            $table->decimal('latitude', 10, 8)->nullable(); // Koordinat lokasi
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('status')->default(\App\Enums\ComplaintStatus::PENDING->value); // Status default awal
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // Relasi ke Pelaksana yang ditugaskan Kasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};