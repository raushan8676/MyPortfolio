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
        // 1. Profile Settings
        Schema::table('profile_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('profile_settings', 'bio_summary')) {
                $table->text('bio_summary')->nullable();
            }
            if (!Schema::hasColumn('profile_settings', 'bio_full')) {
                $table->text('bio_full')->nullable();
            }
            if (!Schema::hasColumn('profile_settings', 'avatar_url')) {
                $table->string('avatar_url')->nullable();
            }
            if (!Schema::hasColumn('profile_settings', 'resume_url')) {
                $table->string('resume_url')->nullable();
            }
            if (!Schema::hasColumn('profile_settings', 'years_experience')) {
                $table->integer('years_experience')->default(1);
            }
            if (!Schema::hasColumn('profile_settings', 'projects_completed')) {
                $table->integer('projects_completed')->default(4);
            }
            if (!Schema::hasColumn('profile_settings', 'satisfied_clients')) {
                $table->integer('satisfied_clients')->default(2);
            }
            if (!Schema::hasColumn('profile_settings', 'is_available_for_hire')) {
                $table->boolean('is_available_for_hire')->default(true);
            }
        });

        // 2. Skills
        Schema::table('skills', function (Blueprint $table) {
            if (!Schema::hasColumn('skills', 'proficiency')) {
                $table->integer('proficiency')->default(90);
            }
            if (!Schema::hasColumn('skills', 'icon')) {
                $table->string('icon')->nullable();
            }
            if (!Schema::hasColumn('skills', 'color')) {
                $table->string('color')->nullable();
            }
        });

        // 3. Projects
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'demo_url')) {
                $table->string('demo_url')->nullable();
            }
            if (!Schema::hasColumn('projects', 'image_url')) {
                $table->string('image_url')->nullable();
            }
            if (!Schema::hasColumn('projects', 'technologies')) {
                $table->json('technologies')->nullable();
            }
        });

        // 4. Experiences
        Schema::table('experiences', function (Blueprint $table) {
            if (!Schema::hasColumn('experiences', 'employment_type')) {
                $table->string('employment_type')->nullable();
            }
            if (!Schema::hasColumn('experiences', 'start_date')) {
                $table->string('start_date')->nullable();
            }
            if (!Schema::hasColumn('experiences', 'end_date')) {
                $table->string('end_date')->nullable();
            }
            if (!Schema::hasColumn('experiences', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('experiences', 'technologies')) {
                $table->json('technologies')->nullable();
            }
        });

        // 5. Education
        Schema::table('education', function (Blueprint $table) {
            if (!Schema::hasColumn('education', 'field_of_study')) {
                $table->string('field_of_study')->nullable();
            }
            if (!Schema::hasColumn('education', 'start_year')) {
                $table->string('start_year')->nullable();
            }
            if (!Schema::hasColumn('education', 'end_year')) {
                $table->string('end_year')->nullable();
            }
            if (!Schema::hasColumn('education', 'grade_or_score')) {
                $table->string('grade_or_score')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
