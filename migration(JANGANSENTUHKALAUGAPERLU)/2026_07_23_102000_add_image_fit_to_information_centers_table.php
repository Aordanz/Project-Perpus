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
            $table->string('image_fit')->default('cover')->nullable()->after('image_path');
            $table->string('image_position')->default('center')->nullable()->after('image_fit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('information_centers', function (Blueprint $table) {
            $table->dropColumn(['image_fit', 'image_position']);
        });
    }
};
