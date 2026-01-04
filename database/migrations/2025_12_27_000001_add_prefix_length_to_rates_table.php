<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            // Adiciona coluna prefix_length
            $table->integer('prefix_length')->nullable()->after('prefixo');
        });

        // Popula prefix_length para registros existentes
        DB::statement("UPDATE rates SET prefix_length = LENGTH(COALESCE(prefixo, ''))");

        // Torna NOT NULL após popular
        Schema::table('rates', function (Blueprint $table) {
            $table->integer('prefix_length')->nullable(false)->default(0)->change();
        });

        // Adiciona índice otimizado
        Schema::table('rates', function (Blueprint $table) {
            $table->index(['carrier_id', 'tarifa', 'ativo', 'prefix_length'], 'idx_carrier_tarifa_prefix_len');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->dropIndex('idx_carrier_tarifa_prefix_len');
            $table->dropColumn('prefix_length');
        });
    }
};
