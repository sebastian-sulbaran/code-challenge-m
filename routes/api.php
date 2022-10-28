<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/weather', [WeatherRequestController::class, 'index']); // apply route groups and validate numeric id
Route::middleware('auth:sanctum')->post('/weather', [WeatherRequestController::class, 'store']);
Route::middleware('auth:sanctum')->get('/weather/{id}', [WeatherRequestController::class, 'show']); // apply route groups and validate numeric id
Route::middleware('auth:sanctum')->delete('/weather/{id}', [WeatherRequestController::class, 'destroy']); // apply route groups and validate numeric id

Route::post('/register', [UserController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);

Route::middleware('auth:sanctum')->post('/weather/{id}/comments', [CommentController::class, 'store']);
Route::middleware('auth:sanctum')->get('/weather/{id}/comments', [CommentController::class, 'index']);
Route::middleware('auth:sanctum')->delete('/comments/{id}', [CommentController::class, 'destroy']);


