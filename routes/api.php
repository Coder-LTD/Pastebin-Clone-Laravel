<?php

use App\Http\Controllers\Api\PasteController as ApiPasteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public endpoints — no authentication required
    Route::get('/pastes', [ApiPasteController::class, 'index']);
    Route::post('/pastes', [ApiPasteController::class, 'store']);
    Route::get('/pastes/{slug}', [ApiPasteController::class, 'show']);
});

// User info endpoint (provided by Sanctum)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
