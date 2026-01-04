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
        Schema::table('users', function (Blueprint $table) {
            // Adiciona relacionamento com reseller
            $table->foreignId('reseller_id')
                ->nullable()
                ->after('customer_id')
                ->constrained('resellers')
                ->onDelete('cascade')
                ->comment('Revenda à qual o usuário pertence (se rule = reseller)');

            // Índice para performance
            $table->index('reseller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['reseller_id']);
            $table->dropIndex(['reseller_id']);
            $table->dropColumn('reseller_id');
        });
    }
};
