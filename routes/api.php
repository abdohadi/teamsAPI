<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
	Route::middleware(['scope:manage-team'])->group(function() {
		Route::post('/teams', [TeamController::class, 'store']);
		Route::get('/teams', [TeamController::class, 'index']);
		Route::get('/teams/rankings', [TeamController::class, 'rankings']);
	});

	Route::post('/matches', [MatchController::class, 'store'])->middleware(['scope:create-match']);
});

Route::post('oauth/token', [\Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);


