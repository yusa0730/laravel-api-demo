<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Todo\TodoController;

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

Route::controller(RegisterController::class)->group(function () {
    Route::post('auth/register', 'register');
});

Route::controller(LoginController::class)->group(function () {
    Route::post('auth/login', 'login');
});

Route::controller(LogoutController::class)->group(function () {
    Route::post('auth/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->group(function () {
    Route::get('users', 'index')->middleware('auth:sanctum');
    Route::get('users/{userId}', 'show')->middleware('auth:sanctum');
});

Route::controller(TodoController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->get('users/{userId}/todos', 'index');
    Route::middleware(['auth:sanctum'])->post('users/{userId}/todos', 'create');

    Route::middleware(['auth:sanctum'])->get('users/{userId}/todos/{todoId}', 'show');
    Route::middleware(['auth:sanctum'])->put('users/{userId}/todos/{todoId}', 'update');
    Route::middleware(['auth:sanctum'])->delete('users/{userId}/todos/{todoId}', 'destroy');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->group( function () {
//     // ユーザー関連のルート
//     Route::get('users', [UserController::class, 'index']);
//     Route::get('users/{userId}', [UserController::class, 'show']);

//     // ユーザーのTodo関連のルート
//     Route::get('users/{userId}/todos', [TodoController::class, 'index']);
//     Route::post('users/{userId}/todos', [TodoController::class, 'store']);
//     Route::get('users/{userId}/todos/{todoId}', [TodoController::class, 'show']);
//     Route::put('users/{userId}/todos/{todoId}', [TodoController::class, 'update']);
//     Route::delete('users/{userId}/todos/{todoId}', [TodoController::class, 'destroy']);
// });
