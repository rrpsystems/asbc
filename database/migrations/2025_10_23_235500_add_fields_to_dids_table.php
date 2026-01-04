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
        Schema::table('dids', function (Blueprint $table) {
            $table->string('descricao')->nullable()->after('encaminhamento');
            $table->decimal('valor_mensal', 10, 2)->nullable()->after('descricao');
            $table->date('data_ativacao')->nullable()->after('valor_mensal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dids', function (Blueprint $table) {
            $table->dropColumn(['descricao', 'valor_mensal', 'data_ativacao']);
        });
    }
};
