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
        Schema::table('cdrs', function (Blueprint $table) {
            // Campos de SIP Status
            $table->string('sip_code', 10)->nullable()->after('hangup')->comment('Código de status SIP (ex: 200, 404, 486, 503)');
            $table->string('sip_reason', 255)->nullable()->after('sip_code')->comment('Descrição do status SIP (ex: OK, Not Found, Busy Here)');

            // Campos de Q.850/ISDN Cause
            $table->string('q850_cause', 10)->nullable()->after('sip_reason')->comment('Código de causa Q.850/ISDN (ex: 16, 17, 19)');
            $table->string('q850_description', 255)->nullable()->after('q850_cause')->comment('Descrição da causa Q.850 (ex: Normal call clearing, User busy)');

            // Campos auxiliares
            $table->text('reason_header')->nullable()->after('q850_description')->comment('Cabeçalho Reason completo do SIP');
            $table->string('failure_type', 50)->nullable()->after('reason_header')->comment('Tipo de falha: REDIRECT, CLIENT_ERROR, SERVER_ERROR, GLOBAL_FAILURE');

            // Índices para melhorar performance
            $table->index('sip_code', 'idx_cdrs_sip_code');
            $table->index('q850_cause', 'idx_cdrs_q850_cause');
            $table->index('failure_type', 'idx_cdrs_failure_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            // Remove índices primeiro
            $table->dropIndex('idx_cdrs_sip_code');
            $table->dropIndex('idx_cdrs_q850_cause');
            $table->dropIndex('idx_cdrs_failure_type');

            // Remove colunas
            $table->dropColumn([
                'sip_code',
                'sip_reason',
                'q850_cause',
                'q850_description',
                'reason_header',
                'failure_type'
            ]);
        });
    }
};
