<?php

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
Route::controller(\App\Http\Controllers\API\VisitAPIController::class)->group(function (){
    Route::middleware('auth.api')->group(function (){
        Route::get('/pendaftaran/get', 'getData');
        Route::get('/kabupaten', [\App\Http\Controllers\API\VisitAPIController::class,'getKabupaten']);
    });

});

Route::controller(\App\Http\Controllers\API\UserAPIController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
