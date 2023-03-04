<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherUpdateController;
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

Route::post('/weather-update', [WeatherUpdateController::class, 'update']);


Route::get('/', function () {
    return response()->json([
        'message' => 'all systems are a go',
        'users' => \App\Models\User::with('weathers')->get(),
    ]);
});
