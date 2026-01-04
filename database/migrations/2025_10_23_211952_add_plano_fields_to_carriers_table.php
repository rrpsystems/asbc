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
            $table->decimal('valor_plano_mensal', 10, 2)->default(0)->after('ativo')->comment('Valor fixo mensal do plano');
            $table->integer('dids_inclusos')->default(0)->after('valor_plano_mensal')->comment('Quantidade de DIDs inclusos no plano');
            $table->integer('franquia_minutos_fixo')->default(0)->after('dids_inclusos')->comment('Minutos de franquia para fixo');
            $table->integer('franquia_minutos_movel')->default(0)->after('franquia_minutos_fixo')->comment('Minutos de franquia para móvel');
            $table->integer('franquia_minutos_nacional')->default(0)->after('franquia_minutos_movel')->comment('Minutos de franquia nacional (fixo+móvel)');
            $table->boolean('franquia_compartilhada')->default(true)->after('franquia_minutos_nacional')->comment('Se a franquia é compartilhada entre fixo e móvel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carriers', function (Blueprint $table) {
            $table->dropColumn([
                'valor_plano_mensal',
                'dids_inclusos',
                'franquia_minutos_fixo',
                'franquia_minutos_movel',
                'franquia_minutos_nacional',
                'franquia_compartilhada',
            ]);
        });
    }
};
