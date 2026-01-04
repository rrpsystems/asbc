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
        Schema::table('revenue_summaries', function (Blueprint $table) {
            $table->decimal('produtos_receita', 10, 2)->default(0)->after('custo_total');
            $table->decimal('produtos_custo', 10, 2)->default(0)->after('produtos_receita');
            $table->decimal('receita_total', 10, 2)->default(0)->after('produtos_custo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revenue_summaries', function (Blueprint $table) {
            $table->dropColumn(['produtos_receita', 'produtos_custo', 'receita_total']);
        });
    }
};
