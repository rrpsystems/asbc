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
        Schema::table('customers', function (Blueprint $table) {
            // Adiciona relacionamento com reseller
            $table->foreignId('reseller_id')
                ->nullable()
                ->after('id')
                ->constrained('resellers')
                ->onDelete('set null')
                ->comment('Revenda responsável por este cliente');

            // Índice para performance
            $table->index('reseller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['reseller_id']);
            $table->dropIndex(['reseller_id']);
            $table->dropColumn('reseller_id');
        });
    }
};
