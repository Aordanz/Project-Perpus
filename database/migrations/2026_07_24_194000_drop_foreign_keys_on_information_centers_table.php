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
        Schema::table('information_centers', function (Blueprint $table) {
            // Drop foreign key constraints pointing to the legacy 'users' table
            try {
                $table->dropForeign('information_centers_created_by_foreign');
            } catch (\Exception $e) {
                // Ignore if constraint doesn't exist
            }

            try {
                $table->dropForeign('information_centers_updated_by_foreign');
            } catch (\Exception $e) {
                // Ignore if constraint doesn't exist
            }
        });

        // Drop foreign keys if using DB statement directly for safety in MySQL
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE information_centers DROP FOREIGN KEY information_centers_created_by_foreign");
        } catch (\Exception $e) {}

        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE information_centers DROP FOREIGN KEY information_centers_updated_by_foreign");
        } catch (\Exception $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed for rollback
    }
};
