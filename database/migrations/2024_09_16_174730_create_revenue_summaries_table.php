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
        Schema::create('revenue_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->integer('mes'); // Mês do resumo (1-12)
            $table->integer('ano'); // Ano do resumo
            $table->integer('franquia_minutos')->default(0); // Franquia mensal de minutos
            $table->integer('minutos_fixo')->default(0); // Minutos consumidos no mês
            $table->integer('minutos_movel')->default(0); // Minutos consumidos no mês
            $table->integer('minutos_internacional')->default(0); // Minutos consumidos no mês
            $table->integer('minutos_usados'); // Minutos utilizados no mês
            $table->integer('minutos_excedentes')->default(0); // Minutos que excederam a franquia
            $table->integer('minutos_excedentes_fixo')->default(0); // Minutos que excederam a franquia
            $table->integer('minutos_excedentes_movel')->default(0); // Minutos que excederam a franquia
            $table->integer('minutos_excedentes_internacional')->default(0); // Minutos que excederam a franquia
            $table->integer('minutos_total')->default(0); // Minutos consumidos no mês
            $table->decimal('valor_plano', 10, 2)->default(0.00);  // Valor do plano
            $table->decimal('excedente_fixo', 10, 2)->default(0.00); // Custo do uso excedente
            $table->decimal('excedente_movel', 10, 2)->default(0.00); // Custo do uso excedente
            $table->decimal('excedente_internacional', 10, 2)->default(0.00); // Custo do uso excedente
            $table->decimal('excedente_total', 10, 2)->default(0.00); // Custo do uso excedente
            $table->decimal('custo_excedente', 10, 2)->default(0); // Custo do uso excedente
            $table->decimal('custo_total', 10, 2); // Custo total do cliente no mês (incluindo excedente)
            $table->boolean('fechado')->default(false); // Indicador de se o resumo foi fechado e faturado
            $table->timestamps();

            $table->unique(['customer_id', 'mes', 'ano']); // Garante um resumo por cliente por mês
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_summaries');
    }
};
