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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('content');
            $table->foreignId('featured_image')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('thumbnail')->nullable()->constrained('media')->nullOnDelete();
            $table->string('video_url')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            
            // Flags
            $table->boolean('breaking_news')->default(false)->index();
            $table->boolean('featured_news')->default(false)->index();
            $table->boolean('trending_news')->default(false)->index();
            $table->boolean('editor_choice')->default(false)->index();
            
            // Status and scheduling
            $table->string('status', 20)->default('draft')->index(); // draft, pending, approved, published, scheduled, rejected, archived
            $table->timestamp('publish_at')->nullable()->index();
            
            $table->unsignedInteger('views')->default(0);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('news_tag', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->primary(['news_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_tag');
        Schema::dropIfExists('news');
    }
};
