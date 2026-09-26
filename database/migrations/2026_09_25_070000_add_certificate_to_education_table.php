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
        Schema::table('education', function (Blueprint $table) {
            if (!Schema::hasColumn('education', 'certificate_url')) {
                $table->string('certificate_url')->nullable()->after('grade_or_score');
            }
            if (!Schema::hasColumn('education', 'location')) {
                $table->string('location')->nullable()->after('institution');
            }
            if (!Schema::hasColumn('education', 'grade_or_score')) {
                $table->string('grade_or_score')->nullable()->after('end_year');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education', function (Blueprint $table) {
            if (Schema::hasColumn('education', 'certificate_url')) {
                $table->dropColumn('certificate_url');
            }
        });
    }
};
