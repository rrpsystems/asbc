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
            // Índice composto otimizado para queries de custo de operadora
            // Cobre: WHERE carrier_id AND calldate (MONTH/YEAR) AND status AND tarifa
            // Usado em: CarrierCostAllocationService
            $table->index(
                ['carrier_id', 'calldate', 'status', 'tarifa'],
                'idx_cdrs_carrier_cost_allocation'
            );

            // Índice para rateio por DID
            // Cobre: WHERE carrier_id AND calldate AND status GROUP BY did_id
            $table->index(
                ['carrier_id', 'calldate', 'status', 'did_id'],
                'idx_cdrs_carrier_did_allocation'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            $table->dropIndex('idx_cdrs_carrier_cost_allocation');
            $table->dropIndex('idx_cdrs_carrier_did_allocation');
        });
    }
};
