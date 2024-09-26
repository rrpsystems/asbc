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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('did_id')->nullable()->constrained('dids')->onDelete('set null');
            $table->foreignId('carrier_id')->nullable()->constrained('carriers')->onDelete('set null'); // Operadora de terminação
            $table->timestamp('calldate');
            $table->string('origem');
            $table->string('destino');
            $table->string('numero');
            $table->enum('tarifa', ['Fixo', 'Movel', 'Internacional', 'Entrada', 'Servico', 'Outros', 'Gratuito']);
            $table->enum('tipo', ['Entrada', 'Saida'])->nullable();
            $table->string('prefixo');
            $table->integer('tempo_falado')->default(0);
            $table->integer('tempo_cobrado')->default(0);
            $table->decimal('valor_compra', 10, 4)->default(0.00);
            $table->decimal('valor_venda', 10, 4)->default(0.00);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
