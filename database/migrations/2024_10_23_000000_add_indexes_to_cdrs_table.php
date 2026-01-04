<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            // Indexes for filtering/reporting
            $table->index('calldate');
            $table->index('customer_id');
            $table->index('carrier_id');
            $table->index('did_id');
            $table->index('status');
            $table->index('tarifa');

            // Compound indexes for common query patterns
            // Example: Filtering by carrier within a date range
            $table->index(['carrier_id', 'calldate']);
            // Example: Filtering by customer within a date range
            $table->index(['customer_id', 'calldate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdrs', function (Blueprint $table) {
            $table->dropIndex(['calldate']);
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['carrier_id']);
            $table->dropIndex(['did_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tarifa']);

            $table->dropIndex(['carrier_id', 'calldate']);
            $table->dropIndex(['customer_id', 'calldate']);
        });
    }
};
