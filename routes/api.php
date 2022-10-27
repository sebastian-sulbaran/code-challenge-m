<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherRequestController;

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

Route::get('/weather', [WeatherRequestController::class, 'index']); // apply route groups and validate numeric id
Route::post('/weather', [WeatherRequestController::class, 'store']);
Route::get('/weather/{id}', [WeatherRequestController::class, 'show']); // apply route groups and validate numeric id
Route::delete('/weather/{id}', [WeatherRequestController::class, 'destroy']); // apply route groups and validate numeric id
