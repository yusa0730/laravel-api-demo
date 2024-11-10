<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\Auth\RegisterController;
use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use App\Http\Controllers\API\V1\User\UserController;
use App\Http\Controllers\API\V1\Todo\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::post('auth/register', 'register');
    });

    Route::controller(LoginController::class)->group(function () {
        Route::post('auth/login', 'login');
    });

    Route::controller(LogoutController::class)->group(function () {
        Route::middleware('auth:sanctum')->post('auth/logout', 'logout');
    });

    Route::controller(UserController::class)->group(function () {
        Route::middleware('auth:sanctum')->get('users', 'index');
        Route::middleware(['auth:sanctum', 'check.userId', 'find.user'])->get('users/{userId}', 'show');
    });

    Route::controller(TodoController::class)->group(function () {
        Route::middleware(['auth:sanctum', 'check.userId', 'find.user'])->get('users/{userId}/todos', 'index');
        Route::middleware(['auth:sanctum', 'check.userId', 'find.user'])->post('users/{userId}/todos', 'create');

        Route::middleware([
            'auth:sanctum',
            'check.userId',
            'find.user',
            'check.todoId',
            'find.todo'
        ])->get('users/{userId}/todos/{todoId}', 'show');
        
        Route::middleware([
            'auth:sanctum',
            'check.userId',
            'find.user',
            'check.todoId',
            'find.todo'
        ])->put('users/{userId}/todos/{todoId}', 'update');
        
        Route::middleware([
            'auth:sanctum',
            'check.userId',
            'find.user',
            'check.todoId',
            'find.todo'
        ])->delete('users/{userId}/todos/{todoId}', 'destroy');
    });
});
