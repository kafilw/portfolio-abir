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
    Route::get('photos/category/{category}', 'showByCategory');
    Route::get('photos/{id}', 'edit');
    Route::post('photos', 'store');
    Route::put('photos/{id}', 'update');
    Route::delete('photos/{id}', 'destroy');
    Route::get('photos/{id}', 'show');
    Route::post('photos/f', 'fkthis');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});
