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
        Schema::create('resellers', function (Blueprint $table) {
            $table->id();

            // Informações básicas
            $table->string('nome');
            $table->string('razao_social')->nullable();
            $table->string('cnpj', 18)->nullable()->unique();
            $table->string('email')->unique();
            $table->string('telefone', 20)->nullable();

            // Endereço
            $table->string('endereco')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('cep', 10)->nullable();

            // Markup por tipo de serviço (percentual)
            $table->decimal('markup_chamadas', 5, 2)->default(0.00)->comment('Markup % sobre chamadas');
            $table->decimal('markup_produtos', 5, 2)->default(0.00)->comment('Markup % sobre produtos/serviços');
            $table->decimal('markup_planos', 5, 2)->default(0.00)->comment('Markup % sobre planos mensais');
            $table->decimal('markup_dids', 5, 2)->default(0.00)->comment('Markup % sobre DIDs');

            // Valores fixos (opcional - sobrescreve o percentual)
            $table->decimal('valor_fixo_chamada', 10, 4)->nullable()->comment('Valor fixo R$/min - sobrescreve markup_%');
            $table->decimal('valor_fixo_produto', 10, 2)->nullable()->comment('Valor fixo R$ - sobrescreve markup_%');
            $table->decimal('valor_fixo_plano', 10, 2)->nullable()->comment('Valor fixo R$ - sobrescreve markup_%');
            $table->decimal('valor_fixo_did', 10, 2)->nullable()->comment('Valor fixo R$ - sobrescreve markup_%');

            // Controle
            $table->boolean('ativo')->default(true);
            $table->date('data_cadastro')->default(now());
            $table->text('observacoes')->nullable();

            $table->timestamps();

            // Índices para performance
            $table->index('ativo');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resellers');
    }
};
