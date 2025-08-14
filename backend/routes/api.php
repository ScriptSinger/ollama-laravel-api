<?php

use App\Http\Controllers\Api\AIController;
use App\Http\Controllers\Api\ChatSessionController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// routes/api.php
Route::get('/test', function () {
    return response()->json(['status' => 'ok']);
});


Route::post('/test-post', function (Request $request) {
    $request->validate([
        'prompt' => 'required|string|max:2000',
    ]);

    return response()->json([
        'message' => 'POST-запрос успешно принят',
        'received_prompt' => $request->input('prompt'),
        'status' => 'ok',
    ]);
});


Route::apiResource('users', UserController::class);





Route::apiResource('chat-sessions', ChatSessionController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);


Route::apiResource('messages', MessageController::class)
    ->only(['store', 'show']);


Route::get('settings', [SettingController::class, 'index']);
Route::put('settings', [SettingController::class, 'update']);


Route::post('ai/generate', [AIController::class, 'generate']);
