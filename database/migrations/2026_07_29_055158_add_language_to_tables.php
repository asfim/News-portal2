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
            $table->string('language', 10)->default('bn')->after('id');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('language', 10)->default('bn')->after('id');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('language', 10)->default('bn')->after('id');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->string('language', 10)->default('bn')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('language');
        });
    }
};
