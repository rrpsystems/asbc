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
        Schema::table('rates', function (Blueprint $table) {
            // Índice composto para busca de tarifas (a query mais crítica)
            $table->index(['carrier_id', 'tarifa', 'ativo'], 'idx_carrier_tarifa_ativo');

            // Índice para busca por prefixo (usado no LIKE com LENGTH)
            $table->index(['prefixo', 'ativo'], 'idx_prefixo_ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->dropIndex('idx_carrier_tarifa_ativo');
            $table->dropIndex('idx_prefixo_ativo');
        });
    }
};
