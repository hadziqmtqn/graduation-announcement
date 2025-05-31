<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestScoreController;
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

    Route::get('select-school-year', [SchoolYearController::class, 'select']);

    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::post('/datatable', [StudentController::class, 'datatable']);
        Route::post('/store', [StudentController::class, 'store'])->name('student.store');
        Route::post('/import', [StudentController::class, 'import'])->name('student.import');
        Route::get('/{student:username}/show', [StudentController::class, 'show'])->name('student.show');
        Route::put('/{student:username}/update', [StudentController::class, 'update']);
        Route::delete('/{student:username}/delete', [StudentController::class, 'destroy']);
    });

    Route::prefix('course')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('course.index');
        Route::post('/datatable', [CourseController::class, 'datatable']);
        Route::post('/store', [CourseController::class, 'store'])->name('course.store');
        Route::put('/{course:slug}/update', [CourseController::class, 'update']);
        Route::delete('/{course:slug}/delete', [CourseController::class, 'destroy']);
    });

    Route::prefix('test-score')->group(function () {
        Route::get('/', [TestScoreController::class, 'index'])->name('test-score.index');
        Route::get('/{schoolYear:slug}', [TestScoreController::class, 'create'])->name('test-score.create');
        Route::post('/{schoolYear:slug}', [TestScoreController::class, 'store'])->name('test-score.store');
    });
});
