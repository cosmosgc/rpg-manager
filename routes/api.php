<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PartyController;
use App\Http\Controllers\Api\CharacterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('characters', CharacterController::class);
Route::apiResource('parties', PartyController::class);
Route::post('/parties/reorder', [PartyController::class, 'reorder']);

