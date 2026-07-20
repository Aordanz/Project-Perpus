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
        Schema::create('information_centers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->enum('category', ['event', 'announcement', 'maintenance', 'new_collection', 'tips', 'promotion', 'general']);
            $table->string('image_path')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('show_popup')->default(false);
            $table->boolean('show_navbar')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('popup_priority')->default(0);
            $table->integer('sort_order')->default(0);
            $table->integer('view_count')->default(0);
            $table->dateTime('publish_start_at');
            $table->dateTime('publish_end_at')->nullable();
            $table->string('action_button_name')->nullable();
            $table->string('action_button_url')->nullable();
            $table->boolean('is_action_open_in_new_tab')->default(false);
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_centers');
    }
};
