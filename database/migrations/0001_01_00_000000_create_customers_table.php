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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('cnpj', 14);
            $table->string('razaosocial');
            $table->string('nomefantasia')->nullable();
            $table->string('endereco');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('cidade');
            $table->string('uf', 2);
            $table->string('cep', 9);
            $table->integer('canais')->default(3);
            $table->decimal('valor_plano', 10, 2)->default(0.00);
            $table->integer('franquia_minutos')->default(1000); // Franquia mensal de minutos
            $table->decimal('valor_excedente', 10, 2)->default(0.00); // Valor por minuto excedente
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('senha');
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->unique(['id', 'cnpj']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
