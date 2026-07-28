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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->renameColumn('position', 'placement_key');
            $table->renameColumn('image', 'image_path');
            $table->renameColumn('link', 'redirect_url');
            $table->renameColumn('html_code', 'script_code');
            $table->string('type', 20)->default('image')->after('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->renameColumn('placement_key', 'position');
            $table->renameColumn('image_path', 'image');
            $table->renameColumn('redirect_url', 'link');
            $table->renameColumn('script_code', 'html_code');
            $table->dropColumn('type');
        });
    }
};
