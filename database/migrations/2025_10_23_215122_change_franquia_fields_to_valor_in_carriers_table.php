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
        Schema::table('carriers', function (Blueprint $table) {
            // Remove os campos de franquia em minutos
            $table->dropColumn([
                'franquia_minutos_fixo',
                'franquia_minutos_movel',
                'franquia_minutos_nacional',
            ]);

            // Adiciona campos de franquia em valor (reais)
            $table->decimal('franquia_valor_fixo', 10, 2)->default(0)->after('dids_inclusos');
            $table->decimal('franquia_valor_movel', 10, 2)->default(0)->after('franquia_valor_fixo');
            $table->decimal('franquia_valor_nacional', 10, 2)->default(0)->after('franquia_valor_movel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carriers', function (Blueprint $table) {
            // Remove os campos de franquia em valor
            $table->dropColumn([
                'franquia_valor_fixo',
                'franquia_valor_movel',
                'franquia_valor_nacional',
            ]);

            // Restaura os campos de franquia em minutos
            $table->integer('franquia_minutos_fixo')->default(0)->after('dids_inclusos');
            $table->integer('franquia_minutos_movel')->default(0)->after('franquia_minutos_fixo');
            $table->integer('franquia_minutos_nacional')->default(0)->after('franquia_minutos_movel');
        });
    }
};
