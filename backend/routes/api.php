<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\MistralService;

Route::post('/mistral/query', function (Request $request, MistralService $mistral) {
    $request->validate([
        'prompt' => 'required|string|max:2000',
    ]);

    return response()->json([
        'result' => $mistral->generate($request->input('prompt')),
    ]);
});
