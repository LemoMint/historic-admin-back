<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\DocumentCategoryController;
// use App\Http\Controllers\Api\AuthController;
// use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\PublishingHouseController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/v1')
    ->group(function () {
        // Route::post('/auth/login', [AuthController::class, 'loginUser'])->name('login');
        //todo роли, юзеры - только супер админы
        //todo категории, печатные дома, редактирование документов - админы
        // Route::middleware('auth:sanctum')->group(function() {
            //auth
            // Route::get('/auth/logout', [AuthController::class, 'logoutUser'])->name('logout');
            // Route::post('/auth/register', [AuthController::class, 'createUser'])->name('register');
            // Route::post('/auth/get-profile', [AuthController::class, 'getUser'])->name('get-current-user');

            Route::middleware('admin')->group(function() {
                Route::apiResource('authors', AuthorController::class);//->middleware(['admin']);
                Route::apiResource('roles', RoleController::class);//->middleware(['admin']);
                Route::apiResource('publication', PublicationController::class);
            });

            Route::middleware('super-admin')->group(function() {
                // Route::apiResource('users', UserController::class);//->middleware(['admin']);
            });
            // Route::apiResource('document-categories', DocumentCategoryController::class);
            // Route::post('/publication/publication-file/{id}', [PublicationController::class, 'getDocument'])->name('publication_file');
            // Route::apiResource('authors', AuthorController::class);
            // Route::apiResource('users', UserController::class);
            // Route::apiResource('publishing-houses', PublishingHouseController::class);
        // });

    //    Route::apiResource('roles', RoleController::class)->middleware(['auth:sanctum', 'super-admin']);

});
