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
        Schema::table('revenue_summaries', function (Blueprint $table) {
            // Índice composto otimizado para firstOrCreate e queries por período
            $table->index(['customer_id', 'mes', 'ano'], 'idx_revenue_customer_period');

            // Índice para queries de franquia e alertas
            $table->index(['customer_id', 'mes', 'ano', 'minutos_usados'], 'idx_revenue_franquia_usage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revenue_summaries', function (Blueprint $table) {
            $table->dropIndex('idx_revenue_customer_period');
            $table->dropIndex('idx_revenue_franquia_usage');
        });
    }
};
