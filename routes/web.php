<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UrlController as UrlControllerV1;
use App\Http\Controllers\Api\V2\UrlController as UrlControllerV2;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('v1')->group(function () {
    Route::get('/{shortCode}', [UrlControllerV1::class, 'redirect']);
});

Route::prefix('v2')->group(function () {
    Route::get('/{shortCode}', [UrlControllerV2::class, 'redirect']);
});