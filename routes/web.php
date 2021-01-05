<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\InternalUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicUserController;
use App\Http\Middleware\ShareVariableViewMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->middleware([ShareVariableViewMiddleware::class]);

Route::get('admin/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('admin/login', [AuthController::class, 'login']);

Auth::routes(['login' => true, 'verify' => true]);

Route::view('forgot-password', 'auth.passwords.email')
    ->middleware([
        ShareVariableViewMiddleware::class
    ])
    ->name('password.request');

Route::middleware(['auth', 'verified', ShareVariableViewMiddleware::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [ProfileController::class, 'index']);
    Route::post('profile', [ProfileController::class, 'update']);
    Route::post('profile/password', [ProfileController::class, 'updatePassword']);

    Route::resource('blog', BlogController::class)->middleware(['role:administrator|editor']);

    Route::resource('income', IncomeController::class)->middleware(['role:administrator|finance']);

    Route::resource('expense', ExpenseController::class)->middleware(['role:administrator|finance']);

    Route::resource('public-user', PublicUserController::class)->middleware(['role:administrator']);

    Route::resource('internal-user', InternalUserController::class)->middleware(['role:administrator']);
});
Route::get('logout', [AuthController::class, 'logout']);

Route::redirect('/home', '/')->name('home');
