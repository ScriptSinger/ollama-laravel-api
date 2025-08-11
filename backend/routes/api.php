<?php

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
