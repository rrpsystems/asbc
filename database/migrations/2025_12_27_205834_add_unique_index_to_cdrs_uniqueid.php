<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adiciona índice único em uniqueid para permitir UPSERT eficiente
     */
    public function up(): void
    {
        // Remove duplicados antes de criar o índice único (se houver)
        DB::statement("
            DELETE FROM cdrs a USING cdrs b
            WHERE a.id > b.id
            AND a.uniqueid = b.uniqueid
            AND a.uniqueid IS NOT NULL
        ");

        // Cria índice único
        Schema::table('cdrs', function (Blueprint $table) {
            $table->unique('uniqueid', 'cdrs_uniqueid_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            $table->dropUnique('cdrs_uniqueid_unique');
        });
    }
};
