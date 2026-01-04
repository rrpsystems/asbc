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
            // Índice composto para queries do dashboard (data + filtros)
            $table->index(['calldate', 'disposition'], 'idx_calldate_disposition');

            // Índice para filtros por customer
            $table->index(['customer_id', 'calldate'], 'idx_customer_calldate');

            // Índice para filtros por carrier
            $table->index(['carrier_id', 'calldate'], 'idx_carrier_calldate');

            // Índice para busca de tarifas por número
            $table->index(['numero', 'tarifa'], 'idx_numero_tarifa');

            // Índice para agregações por tarifa
            $table->index(['tarifa', 'disposition', 'calldate'], 'idx_tarifa_disposition_calldate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            $table->dropIndex('idx_calldate_disposition');
            $table->dropIndex('idx_customer_calldate');
            $table->dropIndex('idx_carrier_calldate');
            $table->dropIndex('idx_numero_tarifa');
            $table->dropIndex('idx_tarifa_disposition_calldate');
        });
    }
};
