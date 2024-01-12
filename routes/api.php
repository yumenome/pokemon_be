<?php

use App\Http\Controllers\ActiveControlller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Resources\RarityResource;
use App\Http\Resources\TypeResource;
use App\Models\Rarity;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/signup',[AuthController::class,'signup']);
Route::post('/login',[AuthController::class,'login']);



Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return auth()->user();
    });
    Route::apiResource('cards', CardController::class);
    Route::post('/active/{id}',[ActiveControlller::class, 'store']);
    Route::post('/logout',[AuthController::class,'logout']);

});

