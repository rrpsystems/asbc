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
        Schema::create('customer_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('tipo_produto'); // ramal_pabx, link_dedicado, servidor_voip, etc
            $table->string('descricao')->nullable(); // Descrição adicional do produto
            $table->integer('quantidade')->default(1); // Quantidade contratada
            $table->decimal('valor_custo_unitario', 10, 2)->default(0); // Quanto você paga
            $table->decimal('valor_venda_unitario', 10, 2)->default(0); // Quanto cobra do cliente
            $table->boolean('ativo')->default(true);
            $table->date('data_ativacao')->nullable();
            $table->date('data_cancelamento')->nullable();
            $table->timestamps();

            // Índices para performance
            $table->index(['customer_id', 'ativo']);
            $table->index('tipo_produto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_products');
    }
};
