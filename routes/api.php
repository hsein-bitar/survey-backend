<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ResponseController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1'], function () {

    // AuthController routes
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', [AuthController::class, 'login'])->name("login");
        Route::post('register', [AuthController::class, 'register'])->name("register");
        Route::group(['middleware' => 'role.user'], function () {
            Route::post('logout', [AuthController::class, 'logout'])->name("logout");
        });
    });

    // SurveyController
    Route::group(['prefix' => 'survey'], function ($router) {
        Route::group(['middleware' => 'role.user'], function () {
            Route::post('create', [SurveyController::class, 'create'])->name("create-survey");
            Route::post('respond', [SurveyController::class, 'respond'])->name("respond");
            Route::get('list', [SurveyController::class, 'list'])->name("list");
            Route::post('results', [SurveyController::class, 'results'])->name("results");
        });
        Route::get('show/{id}', [SurveyController::class, 'show'])->name("show-survey");
    });

    // ResponseController //ended up not using this
    Route::group(['prefix' => 'survey'], function ($router) {
        Route::group(['middleware' => 'role.user'], function () {
        });
    });
});
