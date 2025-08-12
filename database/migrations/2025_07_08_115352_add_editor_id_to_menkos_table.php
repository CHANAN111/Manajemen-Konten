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
        Schema::table('menkos', function (Blueprint $table) {
            Schema::table('menkos', function (Blueprint $table) {
            // Menambahkan kolom foreign key 'editor_id'
            $table->foreignId('editor_id')
                  ->nullable()
                  ->after('status') // Posisi setelah kolom status
                  ->constrained('users')
                  ->onDelete('set null');
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menkos', function (Blueprint $table) {
            Schema::table('menkos', function (Blueprint $table) {
            // Logika untuk membatalkan (rollback) migrasi
            $table->dropForeign(['editor_id']);
            $table->dropColumn('editor_id');
        });
        });
    }
};
