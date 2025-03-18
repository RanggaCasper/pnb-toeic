<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');

    // Forgot
    Route::get('/forgot', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('forgot');
    Route::post('/forgot', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'store'])->name('forgot.store');
    Route::post('/forgot/send', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'send'])->name('forgot.send');
});

Route::post('auth/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'logout'])->middleware('auth')->name('logout');

// Admin
Route::prefix('admin')->as('admin.')->middleware('auth', 'checkRole:admin|super')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::put('/update/{id}', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/store', [\App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store');

    // User
    Route::prefix('user')->as('user.')->group(function () {
        Route::controller(\App\Http\Controllers\Admin\User\UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
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

    // Question Bank
    Route::prefix('bank')->as('bank.')->group(function () {
        Route::controller(\App\Http\Controllers\Admin\QuestionBank\QuestionBankController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });
    });
    
    // Token
    Route::prefix('token')->as('token.')->group(function () {
        Route::controller(\App\Http\Controllers\Admin\Token\TokenController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });
    });
    
    // Section
    Route::prefix('section')->as('section.')->group(function () {
        // Section
        Route::controller(\App\Http\Controllers\Admin\Section\SectionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            Route::get('/preview/{id}', 'preview')->name('preview');
        });

        // Section Name
        Route::prefix('name')->as('name.')->group(function () {
            Route::controller(\App\Http\Controllers\Admin\Section\SectionNameController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/get', 'get')->name('get');
                Route::post('/', 'store')->name('store');
                Route::get('/get/{id}', 'getById')->name('getById');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });
        });
    });

    // Question
    Route::prefix('question')->as('question.')->group(function () {
        Route::controller(\App\Http\Controllers\Admin\Question\QuestionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            Route::get('/preview/{id}', 'preview')->name('preview');
            Route::post('/preview/{id}', 'checkAnswer')->name('check.store');
        });
    });
});

// User
Route::prefix('user')->as('user.')->middleware('auth', 'checkRole:user')->group(function () {
    Route::get('/', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::put('/update/{id}', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/store', [\App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store');

    // Token
    Route::prefix('token')->as('token.')->group(function () {
        Route::controller(\App\Http\Controllers\User\Token\TokenController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get/{id}', 'getByToken')->name('getByToken');
        });
    });
});

Route::prefix('super')->as('super.')->middleware('auth', 'checkRole:super')->group(function () {
    Route::get('/', [\App\Http\Controllers\super\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::put('/update/{id}', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/store', [\App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store');

    Route::prefix('admin')->as('admin.')->group(function () {
        Route::controller(\App\Http\Controllers\super\admin\AdminController::class)->group(function () {
            Route::get('/', 'index')->name('index');
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
