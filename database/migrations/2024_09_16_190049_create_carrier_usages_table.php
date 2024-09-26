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
        Schema::create('carrier_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrier_id')->nullable()->constrained('carriers')->onDelete('set null');
            $table->integer('mes'); // Mês do resumo (1-12)
            $table->integer('ano'); // Ano do resumo
            $table->integer('franquia_minutos')->default(0);
            $table->integer('minutos_utilizados')->default(0); // Minutos consumidos
            $table->decimal('valor_plano', 10, 2)->default(0.00);
            $table->decimal('custo_total', 10, 2)->default(0.00); // Custo total do cliente no mês (incluindo excedente)
            $table->boolean('fechado')->default(false); // Indicador de se o resumo foi fechado e faturado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_usages');
    }
};
