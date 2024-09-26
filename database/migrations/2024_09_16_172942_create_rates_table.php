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

        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->string('prefixo')->nullable();
            $table->foreignId('carrier_id')->nullable()->constrained('carriers')->onDelete('set null');
            $table->enum('tarifa', ['Fixo', 'Movel', 'Internacional', 'Entrada', 'Servico', 'Outros', 'Gratuito']);
            $table->string('descricao')->nullable();
            $table->integer('tempoinicial')->default(0);
            $table->integer('tempominimo')->default(30);
            $table->integer('incremento')->default(6);
            $table->decimal('compra', 10, 3)->default(0);
            $table->decimal('venda', 10, 3)->default(0);
            $table->decimal('vconexao', 10, 3)->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->unique(['prefixo', 'carrier_id', 'tarifa']); // Garante um resumo por cliente por mês
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
