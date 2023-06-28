<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\PublishingHouseController;

Route::prefix('/v1')
    ->middleware(['cors'])
    ->group(function () {
        Route::post('/auth/login', [AuthController::class, 'loginUser'])->name('login');
        Route::post('/auth/confirm-password', [AuthController::class, 'confirmPassord'])->name('confirm-passord');

        Route::middleware(['auth:sanctum'])->group(function() {
            Route::get('/auth/logout', [AuthController::class, 'logoutUser'])->name('logout');
            Route::post('/auth/get-profile', [AuthController::class, 'getUser'])->name('get-current-user');
            Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
            Route::post('/auth/update-my-profile', [AuthController::class, 'updateProfile'])->name('update-my-profile');
            Route::get('/auth/get-profile-avatar', [AuthController::class, 'getProfileAvatar'])->name('get-profile-avatar');

            Route::apiResource('roles', RoleController::class);

            Route::controller(PublicationController::class)->group(function () {
                Route::post('/publications/add-bookmark/{id}', 'addBookmark')->can('update', 'publication');
                Route::get('/publications/get-document-origin/{id}', 'getDocumentOrigin');
                Route::get('/publications/get-document-text/{id}', 'getDocumentText');
            });
            Route::apiResource('publications', PublicationController::class);

            Route::apiResource('categories', CategoryController::class);

            Route::middleware('admin')->group(function() {
                Route::apiResource('authors', AuthorController::class);
                Route::apiResource('publishing-houses', PublishingHouseController::class);
            });
            Route::controller(AuthorController::class)->group(function () {
                Route::get('/authors', 'index');
                Route::get('/authors/{id}', 'show');
                Route::post('/authors', 'store');

            });
            Route::controller(PublishingHouseController::class)->group(function () {
                Route::get('/publishing-houses', 'index');
                Route::get('/publishing-houses/{id}', 'show');
                Route::post('/publishing-houses', 'store');
            });

            Route::middleware('super-admin')->group(function() {
                Route::controller(UserController::class)->group(function () {
                    Route::get('/users/{id}/block', 'block');
                });

                Route::apiResource('users', UserController::class);
            });
        });
    });
