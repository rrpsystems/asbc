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
            $table->unsignedBigInteger('revenue_summary_id')->nullable()->after('cobrada');
            $table->foreign('revenue_summary_id')
                  ->references('id')
                  ->on('revenue_summaries')
                  ->onDelete('set null');
            $table->index('revenue_summary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            $table->dropForeign(['revenue_summary_id']);
            $table->dropIndex(['revenue_summary_id']);
            $table->dropColumn('revenue_summary_id');
        });
    }
};
