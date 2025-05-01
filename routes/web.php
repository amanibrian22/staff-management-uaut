<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RiskController;

Route::get('/', function () {
    return view ('welcome');
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
    Route::post('/staff/technical/resolve/{risk}', [RiskController::class, 'resolveRisk'])->name('technical.resolve');

    // Financial
    Route::get('/staff/financial', [RiskController::class, 'showFinancialDashboard'])->name('financial.dashboard');
    Route::post('/staff/financial/resolve/{risk}', [RiskController::class, 'resolveRisk'])->name('financial.resolve');

    // Academic
    Route::get('/staff/academic', [RiskController::class, 'showAcademicDashboard'])->name('academic.dashboard');
    Route::post('/staff/academic/resolve/{risk}', [RiskController::class, 'resolveRisk'])->name('academic.resolve');

    // Admin
    Route::get('/staff/admin', [RiskController::class, 'showAdminDashboard'])->name('admin.dashboard');
    Route::post('/staff/admin/add-risk', [RiskController::class, 'adminAddRisk'])->name('admin.add.risk');
    Route::post('/staff/admin/edit-risk/{risk}', [RiskController::class, 'adminEditRisk'])->name('admin.edit.risk');
    Route::post('/staff/admin/delete-risk/{risk}', [RiskController::class, 'adminDeleteRisk'])->name('admin.delete.risk');
    Route::post('/staff/admin/add-user', [RiskController::class, 'adminAddUser'])->name('admin.add.user');
});