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
            $table->string('file_dubbing')->nullable()->after('file_naskah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menkos', function (Blueprint $table) {
            $table->dropColumn('file_dubbing');
        });
    }
};
