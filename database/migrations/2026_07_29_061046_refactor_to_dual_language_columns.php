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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->dropColumn('language');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('short_description_en')->nullable()->after('short_description');
            $table->longText('content_en')->nullable()->after('content');
            $table->dropColumn('language');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->longText('content_en')->nullable()->after('content');
            $table->dropColumn('language');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->dropColumn('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->string('language')->default('bn')->after('id');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'short_description_en', 'content_en']);
            $table->string('language')->default('bn')->after('id');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'content_en']);
            $table->string('language')->default('bn')->after('id');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->string('language')->default('bn')->after('id');
        });
    }
};
