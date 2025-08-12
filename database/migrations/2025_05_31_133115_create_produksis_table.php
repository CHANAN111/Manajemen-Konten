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
        Schema::create('produksis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Ide', 'Scripting', 'Shooting', 'Editing', 'Publish'])->default('Ide');
            $table->date('deadline')->nullable();
            $table->json('tugas')->nullable(); // bisa dipakai untuk menyimpan pembagian tugas
            $table->json('resource')->nullable(); // bisa simpan path thumbnail, musik, dsb.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};
