<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');
});

Route::post('auth/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'logout'])->middleware('auth')->name('logout');

// Admin
Route::prefix('admin')->as('admin.')->middleware('auth','checkRole:admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // User
    Route::prefix('user')->as('user.')->group(function () {
        Route::controller(\App\Http\Controllers\Admin\User\UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/profile', 'profile')->name('profile');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');

            // Import & Export
            Route::get('/export', 'export')->name('export');
            Route::post('/import', 'import')->name('import');
        });
    });
});

// User
Route::prefix('user')->as('user.')->middleware('auth','checkRole:user')->group(function () {
    Route::get('/', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
});