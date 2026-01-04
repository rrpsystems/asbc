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
        // Adicionar campos padrão na tabela customers
        Schema::table('customers', function (Blueprint $table) {
            $table->string('proxy_padrao')->nullable()->after('ativo');
            $table->integer('porta_padrao')->nullable()->default(5060)->after('proxy_padrao');
        });

        // Adicionar campos específicos na tabela dids
        Schema::table('dids', function (Blueprint $table) {
            $table->string('proxy')->nullable()->after('carrier_id');
            $table->integer('porta')->nullable()->after('proxy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['proxy_padrao', 'porta_padrao']);
        });

        Schema::table('dids', function (Blueprint $table) {
            $table->dropColumn(['proxy', 'porta']);
        });
    }
};
