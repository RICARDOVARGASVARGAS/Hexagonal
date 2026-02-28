<?php

declare(strict_types=1);

use App\Academy\Infrastructure\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;

// Route::prefix('academy')->group(function () {
//     Route::apiResource('schools', SchoolController::class);
// });

Route::prefix('academy')->group(function () {
    Route::get('schools',      [SchoolController::class, 'index']);
    Route::post('schools',      [SchoolController::class, 'store']);
    Route::get('schools/{id}', [SchoolController::class, 'show']);
    Route::put('schools/{id}', [SchoolController::class, 'update']);
    Route::delete('schools/{id}', [SchoolController::class, 'destroy']);
});
