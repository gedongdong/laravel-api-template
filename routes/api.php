<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('cors')->group(function () {
    Route::prefix('users')->middleware('user.guard')->group(function () {
        //user路由
        Route::post('', [UserController::class, 'store'])->name('users.store');
        Route::post('login', [UserController::class, 'login'])->name('users.login');
        Route::middleware('api.refresh')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('users.index');
            Route::get('show/{user}', [UserController::class, 'show'])->name('users.show');
            Route::post('logout', [UserController::class, 'logout'])->name('users.logout');
            //当前用户信息
            Route::get('info', [UserController::class, 'info'])->name('users.info');
        });
    });

    Route::prefix('admins')->middleware('admin.guard')->group(function () {
        //admin路由
        Route::post('', [AdminController::class, 'store'])->name('admins.store');
        Route::post('login', [AdminController::class, 'login'])->name('admins.login');
        Route::middleware('api.refresh')->group(function () {
            Route::get('', [AdminController::class, 'index'])->name('admins.index');
            Route::get('show/{user}', [AdminController::class, 'show'])->name('admins.show');
            Route::post('logout', [AdminController::class, 'logout'])->name('admins.logout');
            //当前用户信息
            Route::get('info', [AdminController::class, 'info'])->name('admins.info');
        });
    });
});
