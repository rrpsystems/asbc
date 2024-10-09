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
        Schema::create('cdrs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('calldate');
            $table->string('clid');
            $table->string('src');
            $table->string('dst');
            $table->string('dcontext')->nullable();
            $table->string('channel')->nullable();
            $table->string('dstchannel')->nullable();
            $table->string('lastapp')->nullable();
            $table->string('lastdata')->nullable();
            $table->integer('duration')->default(0);
            $table->integer('billsec')->default(0);
            $table->string('disposition')->nullable();
            $table->string('amaflags')->nullable();
            $table->string('accountcode')->nullable();
            $table->string('uniqueid')->nullable();
            $table->string('userfield')->nullable();
            $table->string('prefixo')->nullable();
            $table->string('numero')->nullable();
            $table->string('numero_discado')->nullable();
            $table->string('numero_convertido')->nullable();
            $table->string('ramal')->nullable();
            $table->string('recordingfile')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('carrier_id')->nullable();
            $table->bigInteger('did_id')->nullable();
            $table->string('cnpj')->nullable();
            $table->integer('tempo_falado')->default(0);
            $table->integer('tempo_cobrado')->default(0);
            $table->decimal('valor_compra', 10, 4)->default(0.00);
            $table->decimal('valor_venda', 10, 4)->default(0.00);
            $table->enum('tarifa', ['Fixo', 'Movel', 'Internacional', 'Entrada', 'Servico', 'Outros', 'Gratuito']);
            $table->enum('tipo', ['Entrada', 'Saida'])->nullable();
            $table->string('carrier_channels')->nullable();
            $table->string('customer_channels')->nullable();
            $table->string('channel_source')->nullable();
            $table->string('hangup_source')->nullable();
            $table->string('desligamento')->nullable();
            $table->decimal('mes_tx', 10, 2)->nullable();
            $table->decimal('mes_rx', 10, 2)->nullable();
            $table->string('ip_src')->nullable();
            $table->string('ip_dst')->nullable();
            $table->string('ip_rtp_src')->nullable();
            $table->string('ip_rtp_dst')->nullable();
            $table->string('codec_nativo')->nullable();
            $table->string('codec_in')->nullable();
            $table->string('codec_out')->nullable();
            $table->string('hangup')->nullable();
            $table->string('status')->default('Pendente');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdrs');
    }
};
