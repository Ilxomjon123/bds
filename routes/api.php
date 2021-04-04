<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ElectionTypeController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

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

/* Route::post('/auth/register', [AuthController::class, 'register']); */

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/not-auth', [AuthController::class, 'notAuth'])->name('not-auth');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'faculty'], function () {
        Route::get('/one', [FacultyController::class, 'getOne']);
        Route::get('/all', [FacultyController::class, 'getAll']);
        Route::post('/store', [FacultyController::class, 'store']);
        Route::post('/update', [FacultyController::class, 'update']);
        Route::post('/delete', [FacultyController::class, 'delete']);
    });

    Route::group(['prefix' => 'election'], function () {
        Route::get('/one', [ElectionController::class, 'getOne']);
        Route::get('/all', [ElectionController::class, 'getAll']);
        Route::post('/store', [ElectionController::class, 'store']);
        Route::post('/update', [ElectionController::class, 'update']);
        Route::post('/delete', [ElectionController::class, 'delete']);
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/one', [RoleController::class, 'getOne']);
        Route::get('/all', [RoleController::class, 'getAll']);
        Route::post('/store', [RoleController::class, 'store']);
        Route::post('/update', [RoleController::class, 'update']);
        Route::post('/delete', [RoleController::class, 'delete']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/one', [UserController::class, 'getOne']);
        Route::get('/all', [UserController::class, 'getAll']);
        Route::post('/store', [UserController::class, 'store']);
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/delete', [UserController::class, 'delete']);
    });

    Route::group(['prefix' => 'election-type'], function () {
        Route::get('/one', [ElectionTypeController::class, 'getOne']);
        Route::get('/all', [ElectionTypeController::class, 'getAll']);
        Route::post('/store', [ElectionTypeController::class, 'store']);
        Route::post('/update', [ElectionTypeController::class, 'update']);
        Route::post('/delete', [ElectionTypeController::class, 'delete']);
    });

    Route::group(['prefix' => 'vote'], function () {
        Route::get('/one', [VoteController::class, 'getOne']);
        Route::get('/all', [VoteController::class, 'getAll']);
        Route::post('/store', [VoteController::class, 'store']);
        Route::post('/update', [VoteController::class, 'update']);
    });
});
