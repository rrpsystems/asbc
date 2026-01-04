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
        Schema::table('carrier_usages', function (Blueprint $table) {
            $table->string('tipo_servico')->default('Todos')->after('carrier_id');

            // Adiciona índice composto para busca por operadora + mês + ano + tipo
            $table->index(['carrier_id', 'mes', 'ano', 'tipo_servico'], 'idx_carrier_mes_ano_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrier_usages', function (Blueprint $table) {
            $table->dropIndex('idx_carrier_mes_ano_tipo');
            $table->dropColumn('tipo_servico');
        });
    }
};
