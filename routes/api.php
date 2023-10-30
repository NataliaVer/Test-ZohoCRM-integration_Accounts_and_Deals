<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\DealController;

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

// Route::group(['namespase' => 'Account', 'prefix' => 'company'], function() {
//     Route::post('/', 'NewController');
// });
Route::post('/account', [AccountController::class, 'store']);

Route::get('/accounts', [AccountController::class, 'index']);

Route::put('/account/{id}', [AccountController::class, 'update']);

Route::delete('/account/{id}', [AccountController::class, 'destroy']);

Route::get('/deals', [DealController::class, 'index']);
Route::post('/deal', [DealController::class, 'store']);
Route::put('/deal/{id}', [DealController::class, 'update']);
Route::delete('/deal/{id}', [DealController::class, 'destroy']);
