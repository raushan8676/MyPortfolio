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
        Schema::table('profile_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('profile_settings', 'about_image_url')) {
                $table->string('about_image_url')->nullable()->after('avatar_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_settings', function (Blueprint $table) {
            if (Schema::hasColumn('profile_settings', 'about_image_url')) {
                $table->dropColumn('about_image_url');
            }
        });
    }
};
