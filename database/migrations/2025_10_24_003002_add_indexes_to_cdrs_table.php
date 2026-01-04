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
        Schema::table('cdrs', function (Blueprint $table) {
            // Índice composto para a busca mais comum (data + filtros)
            $table->index(['calldate', 'customer_id', 'carrier_id'], 'idx_cdrs_calldate_customer_carrier');

            // Índices individuais para filtros específicos
            $table->index('tarifa', 'idx_cdrs_tarifa');
            $table->index('status', 'idx_cdrs_status');
            $table->index('desligamento', 'idx_cdrs_desligamento');
            $table->index('did_id', 'idx_cdrs_did_id');

            // Índices para buscas parciais (LIKE)
            $table->index('numero', 'idx_cdrs_numero');
            $table->index('ramal', 'idx_cdrs_ramal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            $table->dropIndex('idx_cdrs_calldate_customer_carrier');
            $table->dropIndex('idx_cdrs_tarifa');
            $table->dropIndex('idx_cdrs_status');
            $table->dropIndex('idx_cdrs_desligamento');
            $table->dropIndex('idx_cdrs_did_id');
            $table->dropIndex('idx_cdrs_numero');
            $table->dropIndex('idx_cdrs_ramal');
        });
    }
};
