<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PhotosController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::apiResource('/photos', PhotosController::class);
Route::controller(PhotosController::class)->group(function () {
    Route::get('photos', 'index');
    Route::get('photos/category/{category}', 'showByCategory')->middleware('auth:sanctum');
    Route::get('photos/{id}', 'edit')->middleware('auth:sanctum');
    Route::post('photos', 'store')->middleware('auth:sanctum');
    Route::put('photos/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('photos/{id}', 'destroy')->middleware('auth:sanctum');
    Route::get('photos/{id}', 'show')->middleware('auth:sanctum');
    Route::post('photos/f', 'fkthis')->middleware('auth:sanctum');
    Route::get('filter', 'showByFilter');
});



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});
