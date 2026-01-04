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
            // Valor final cobrado do cliente (com markup de revenda se aplicável)
            $table->decimal('valor_venda_final', 10, 4)
                ->nullable()
                ->after('valor_venda')
                ->comment('Valor final cobrado (com markup revenda). NULL = usar valor_venda');

            // Valor do markup aplicado (para facilitar relatórios)
            $table->decimal('valor_markup', 10, 4)
                ->nullable()
                ->after('valor_venda_final')
                ->comment('Diferença entre valor_venda_final e valor_venda (lucro da revenda)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            $table->dropColumn(['valor_venda_final', 'valor_markup']);
        });
    }
};
