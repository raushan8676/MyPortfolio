<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Portfolio Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/about', [PortfolioController::class, 'about'])->name('about');
Route::get('/skills', [PortfolioController::class, 'skills'])->name('skills');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/experience', [PortfolioController::class, 'experience'])->name('experience');
Route::get('/education', [PortfolioController::class, 'education'])->name('education');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [PortfolioController::class, 'submitContact'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Admin CMS Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Settings
    Route::post('/admin/profile/update', [DashboardController::class, 'updateProfile'])->name('admin.profile.update');

    // Skills CRUD
    Route::post('/admin/skills', [DashboardController::class, 'storeSkill'])->name('admin.skills.store');
    Route::put('/admin/skills/{skill}', [DashboardController::class, 'updateSkill'])->name('admin.skills.update');
    Route::delete('/admin/skills/{skill}', [DashboardController::class, 'destroySkill'])->name('admin.skills.destroy');

    // Projects CRUD
    Route::post('/admin/projects', [DashboardController::class, 'storeProject'])->name('admin.projects.store');
    Route::put('/admin/projects/{project}', [DashboardController::class, 'updateProject'])->name('admin.projects.update');
    Route::delete('/admin/projects/{project}', [DashboardController::class, 'destroyProject'])->name('admin.projects.destroy');

    // Experience CRUD
    Route::post('/admin/experience', [DashboardController::class, 'storeExperience'])->name('admin.experience.store');
    Route::put('/admin/experience/{experience}', [DashboardController::class, 'updateExperience'])->name('admin.experience.update');
    Route::delete('/admin/experience/{experience}', [DashboardController::class, 'destroyExperience'])->name('admin.experience.destroy');

    // Education CRUD
    Route::post('/admin/education', [DashboardController::class, 'storeEducation'])->name('admin.education.store');
    Route::put('/admin/education/{education}', [DashboardController::class, 'updateEducation'])->name('admin.education.update');
    Route::delete('/admin/education/{education}', [DashboardController::class, 'destroyEducation'])->name('admin.education.destroy');

    // Contact Messages
    Route::patch('/admin/messages/{message}/toggle-read', [DashboardController::class, 'toggleMessageRead'])->name('admin.messages.toggle');
    Route::delete('/admin/messages/{message}', [DashboardController::class, 'destroyMessage'])->name('admin.messages.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

