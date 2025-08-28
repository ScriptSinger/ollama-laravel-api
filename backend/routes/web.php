<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__ . '/auth.php';

Route::get('/redis-test', function () {
    Cache::put('foo', 'bar', 10);
    return Cache::get('foo'); // должно вернуть "bar"
});
