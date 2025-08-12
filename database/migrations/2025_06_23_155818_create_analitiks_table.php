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
        Schema::create('analitiks', function (Blueprint $table) {
            $table->id();
            // Ini adalah Foreign Key yang terhubung ke tabel jadwals
            $table->foreignId('jadwal_id')->unique()->constrained('jadwals')->onDelete('cascade');
            
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('likes')->default(0);
            $table->unsignedBigInteger('comments')->default(0);
            $table->text('catatan')->nullable(); // Untuk catatan analisis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analitiks');
    }
};
