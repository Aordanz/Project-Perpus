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
            $table->integer('image_scale')->default(100)->nullable()->after('image_position');
            $table->integer('image_x')->default(50)->nullable()->after('image_scale');
            $table->integer('image_y')->default(50)->nullable()->after('image_x');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('information_centers', function (Blueprint $table) {
            $table->dropColumn(['image_scale', 'image_x', 'image_y']);
        });
    }
};
