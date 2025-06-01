<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RiskController;

Route::get('/', function () {
    return view('welcome');
});

// Routes for Register
Route::get('/staff/register', [RegisterController::class, 'showRegistrationForm'])->name('staff.register');
Route::post('/staff/register', [RegisterController::class, 'register']);

// Routes for Login
Route::get('/staff/login', [LoginController::class, '__invoke'])->name('staff.login');
Route::post('/staff/login', [LoginController::class, '__invoke']);

// Route for Logout
Route::post('/staff/logout', [LoginController::class, 'logout'])->name('staff.logout');

// Role-specific routes
Route::middleware(['auth'])->group(function () {
    // Staff
    Route::get('/staff/staff', [RiskController::class, 'showStaffDashboard'])->name('staff.dashboard');
    Route::post('/staff/staff/report', [RiskController::class, 'reportRisk'])->name('staff.report');

    // Technical
    Route::get('/staff/technical', [RiskController::class, 'showTechnicalDashboard'])->name('technical.dashboard');
    Route::post('/staff/technical/progress/{risk}', [RiskController::class, 'reportProgress'])->name('technical.progress');
    Route::post('/staff/technical/resolve/{risk}', [RiskController::class, 'resolveRisk'])->name('technical.resolve');
    Route::post('/staff/technical/suggest/{risk}', [RiskController::class, 'suggestAlternate'])->name('technical.suggest');

    // Financial
    Route::get('/staff/financial', [RiskController::class, 'showFinancialDashboard'])->name('financial.dashboard');
    Route::post('/staff/financial/progress/{risk}', [RiskController::class, 'reportProgress'])->name('financial.progress');
    Route::post('/staff/financial/resolve/{risk}', [RiskController::class, 'resolveRisk'])->name('financial.resolve');
    Route::post('/staff/financial/suggest/{risk}', [RiskController::class, 'suggestAlternate'])->name('financial.suggest');

    // Academic
    Route::get('/staff/academic', [RiskController::class, 'showAcademicDashboard'])->name('academic.dashboard');
    Route::post('/staff/academic/progress/{risk}', [RiskController::class, 'reportProgress'])->name('academic.progress');
    Route::post('/staff/academic/resolve/{risk}', [RiskController::class, 'resolveRisk'])->name('academic.resolve');
    Route::post('/staff/academic/suggest/{risk}', [RiskController::class, 'suggestAlternate'])->name('academic.suggest');

    // Admin
    Route::get('/staff/admin', [RiskController::class, 'showAdminDashboard'])->name('admin.dashboard');
    Route::post('/staff/admin/add-risk', [RiskController::class, 'adminAddRisk'])->name('admin.add.risk');
    Route::post('/staff/admin/edit-risk/{risk}', [RiskController::class, 'adminEditRisk'])->name('admin.edit.risk');
    Route::delete('/staff/admin/delete-risk/{risk}', [RiskController::class, 'adminDeleteRisk'])->name('admin.delete.risk');
    Route::post('/staff/admin/add-user', [RiskController::class, 'adminAddUser'])->name('admin.add.user');
    Route::post('/staff/admin/edit-user/{user}', [RiskController::class, 'adminEditUser'])->name('admin.edit.user');
    Route::delete('/staff/admin/delete-user/{user}', [RiskController::class, 'adminDeleteUser'])->name('admin.delete.user');
    Route::get('/staff/admin/generate-report', [RiskController::class, 'generateReport'])->name('admin.generate.report');
});