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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menko_id')->nullable()->constrained('menkos')->onDelete('set null');

            $table->string('judul_video');
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('Draf');
            $table->dateTime('tanggal_tayang')->nullable(); // Boleh kosong di awal
            $table->string('link_video')->nullable(); // Boleh kosong
            $table->timestamps();

            // $table->foreignId('menko_id')->nullable()->constrained('menkos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
