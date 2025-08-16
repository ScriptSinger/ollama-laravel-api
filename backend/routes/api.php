<?php

use App\Http\Controllers\Api\AIController;
use App\Http\Controllers\Api\ChatSessionController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::apiResource('users', UserController::class);





Route::apiResource('chat-sessions', ChatSessionController::class);



Route::apiResource('messages', MessageController::class);
// ->only(['store', 'show']);


Route::get('settings', [SettingController::class, 'index']);
Route::put('settings', [SettingController::class, 'update']);


Route::post('ai/generate', [AIController::class, 'generate']);
