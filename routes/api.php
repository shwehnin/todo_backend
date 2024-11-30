<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\TodoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function() {
    Route::get('/todo', [TodoController::class, 'list']);
    Route::get('/todo/{todo}', [TodoController::class, 'show']);
    Route::post('/todo', [TodoController::class, 'create']);
    Route::put('/todo/{todo}', [TodoController::class, 'update']);
    Route::delete('/todo/{todo}', [TodoController::class, 'destroy']);
});

