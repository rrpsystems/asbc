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
            $table->boolean('bloqueio_entrada')->default(false)->after('ativo');
            $table->boolean('bloqueio_saida')->default(false)->after('bloqueio_entrada');
            $table->text('motivo_bloqueio')->nullable()->after('bloqueio_saida');
            $table->timestamp('data_bloqueio')->nullable()->after('motivo_bloqueio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['bloqueio_entrada', 'bloqueio_saida', 'motivo_bloqueio', 'data_bloqueio']);
        });
    }
};
