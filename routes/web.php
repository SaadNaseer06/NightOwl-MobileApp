<?php

use App\Http\Controllers\BarTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate; // Import the middleware class

Route::group(['middleware' => 'admin'], function () {
    // Protected routes that require authentication
    Route::get('/', [UserController::class, 'index']);

    Route::get('/add-user', function () {
        return view('admin.addusers');
    });

    Route::post('/user', [UserController::class, 'register'])->name('user.create');
    Route::get('/users', [UserController::class, 'fetchUsers']);
    Route::delete('/users/{id}', [UserController::class, 'userDelete'])->name('users.destroy');
    Route::get('/edit/{id}', [UserController::class, 'editUser'])->name('edit.user');
    Route::post('/user/{user}/update', [UserController::class, 'userUpdate'])->name('user.update');

    Route::get('/add-bars', function () {
        return view('admin.addbars');
    });
    Route::post('/add-bar', [BarTypeController::class, 'add'])->name('add.bar');
    Route::get('/bars', [UserController::class, 'fetchBars']);
    Route::delete('/delete-bar/{id}', [UserController::class, 'barDelete'])->name('bar.delete');
    Route::post('/appoint/{id}', [UserController::class, 'roleAppoint'])->name('role.appoint');
    Route::get('/bars/{id}/edit', [BarTypeController::class, 'barEdit'])->name('edit.bar');
    Route::put('/bars/{id}', [BarTypeController::class, 'update'])->name('bar.update');
    Route::get('/inactive', [BarTypeController::class, 'inactiveBars']);
    Route::post('/activate-bar/{id}', [BarTypeController::class, 'barActive'])->name('bar.activate');
    Route::post('/delete-bar/{id}', [BarTypeController::class, 'inactiveDelete'])->name('inactive.delete');
});

Route::post('/login', [UserController::class, 'admin'])->name('login');
// Unprotected routes (e.g., login)
Route::get('/login', function () {
    return view('admin.login');
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/view-bar/{id}', [BarTypeController::class, 'viewBar'])->name('view.bar');