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

        Schema::create('carriers', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->string('operadora');
            $table->integer('canais')->default('30');
            $table->string('dominio')->nullable();
            $table->string('proxy')->nullable();
            $table->string('techprefix')->nullable();
            $table->string('usuario')->nullable();
            $table->string('senha')->nullable();
            $table->integer('porta')->default(5060);
            $table->string('march1')->nullable();
            $table->string('march2')->nullable();
            $table->string('march3')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carriers');
    }
};
