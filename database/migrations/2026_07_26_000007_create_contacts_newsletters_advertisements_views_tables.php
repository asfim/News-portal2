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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('status', 20)->default('active')->index();
            $table->timestamps();
        });

        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->text('html_code')->nullable();
            $table->string('position', 30)->index(); // top_banner, header_banner, details_banner, sidebar_banner, inside_content, footer_banner, popup, sticky_bottom
            $table->date('start_date')->nullable()->index();
            $table->date('end_date')->nullable()->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->date('viewed_date')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('views');
        Schema::dropIfExists('advertisements');
        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('contacts');
    }
};
