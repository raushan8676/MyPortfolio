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
        Schema::create('profile_settings', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->default('Raushan Kumar');
            $table->string('first_name')->default('Raushan');
            $table->string('last_name')->default('Kumar');
            $table->string('title')->default('Full Stack Developer');
            $table->string('tagline')->default('Code Build Grow');
            $table->string('greeting')->default("Hello, I'm");
            $table->text('short_bio')->nullable();
            $table->text('about_bio_1')->nullable();
            $table->text('about_bio_2')->nullable();
            $table->string('location')->default('Teghra, Begusarai, Bihar, India');
            $table->string('email')->default('contact@raushankumar.com');
            $table->string('phone')->default('+91 620xxxxxxx');
            $table->string('university')->default('Dr C V Raman University, Vaishali (Bihar)');
            $table->string('degree')->default('B.Tech CSE');
            $table->string('education_period')->default('2023 – 2027');
            $table->string('current_semester')->default('6th Semester');
            $table->string('current_company')->default('DataAegis Software Private Limited');
            $table->string('current_role')->default('Software Developer Trainee');
            $table->string('profile_image')->nullable();
            $table->string('about_image')->nullable();
            $table->string('resume_file')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->timestamps();
        });

        // 2. Skills Table
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('frontend'); // frontend, backend, database, tools
            $table->string('image')->nullable();
            $table->string('cdn_fallback')->nullable();
            $table->string('level')->default('Advanced'); // Expert, Advanced, Intermediate
            $table->string('level_color')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Projects Table
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('category')->default('fullstack'); // fullstack, react, laravel
            $table->string('category_name')->nullable();
            $table->string('icon')->nullable();
            $table->string('icon_bg')->nullable();
            $table->text('fallback_icon')->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->json('tags')->nullable();
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. Experiences Table
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('company');
            $table->string('period')->default('2024 – Present');
            $table->string('type')->default('Full-time / Trainee');
            $table->string('location')->nullable();
            $table->string('logo')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('summary')->nullable();
            $table->json('deliverables')->nullable();
            $table->json('responsibilities')->nullable();
            $table->json('tags')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 5. Education Table
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('degree');
            $table->string('field')->nullable();
            $table->string('institution');
            $table->string('location')->nullable();
            $table->string('period')->default('2023 – 2027');
            $table->string('status')->nullable();
            $table->string('icon_bg')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->json('courses')->nullable();
            $table->json('highlights')->nullable();
            $table->json('tags')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 6. Contact Messages
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('education');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('profile_settings');
    }
};
