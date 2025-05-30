<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::post('/store', [LoginController::class, 'store'])->name('login.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('school-year')->group(function () {
        Route::get('/', [SchoolYearController::class, 'index'])->name('school-year.index');
        Route::post('/datatable', [SchoolYearController::class, 'datatable']);
        Route::post('/store', [SchoolYearController::class, 'store'])->name('school-year.store');
        Route::get('/{schoolYear:slug}/show', [SchoolYearController::class, 'show'])->name('school-year.show');
        Route::put('/{schoolYear:slug}/update', [SchoolYearController::class, 'update'])->name('school-year.update');
    });

    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::post('/datatable', [StudentController::class, 'datatable']);
        Route::post('/store', [StudentController::class, 'store'])->name('student.store');
        Route::get('/{student:username}/show', [StudentController::class, 'show'])->name('student.show');
        Route::put('/{student:username}/update', [StudentController::class, 'update']);
    });
});
