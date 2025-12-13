<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

// Public routes - Form
Route::get('/', [FormController::class, 'show'])->name('form.index');
Route::get('/form', [FormController::class, 'show'])->name('form.show');

// Form submission dengan rate limiting: 200 request per menit per IP
Route::post('/form/submit', [FormController::class, 'store'])
    ->middleware('throttle:200,1')
    ->name('form.submit');

Route::get('/success', [FormController::class, 'success'])->name('form.success');

// Admin authentication routes
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

// Protected admin routes
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/submissions/{id}/toggle-follow-up', [DashboardController::class, 'toggleFollowUp'])->name('admin.submissions.toggle-follow-up');

    Route::get('/qrcodes', [QrController::class, 'index'])->name('admin.qrcodes');
    Route::post('/qrcodes/generate', [QrController::class, 'generate'])->name('admin.qrcodes.generate');
    Route::get('/qrcodes/{token}/show', [QrController::class, 'show'])->name('admin.qrcodes.show');
    Route::get('/qrcodes/{token}/download', [QrController::class, 'download'])->name('admin.qrcodes.download');

    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('admin.profile.delete-photo');

    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::delete('/settings/logo', [SettingsController::class, 'deleteLogo'])->name('admin.settings.delete-logo');
});
