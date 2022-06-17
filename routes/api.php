<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
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
    Route::group(['prefix' => 'users'], function ($router) {
        Route::post('login', [UserController::class, 'login'])->name("login");
        Route::post('register', [UserController::class, 'register'])->name("register");
        Route::group(['middleware' => 'role.user'], function () {
            Route::post('logout', [UserController::class, 'logout'])->name("logout");
        });
    });


    // UserController routes
    Route::group(['prefix' => 'users'], function ($router) {
        // accessible to all
        // for all signed in users, including admins
        Route::group(['middleware' => 'role.user'], function () {
            // Route::post('refresh', [UserController::class, 'refresh'])->name("refresh");
            Route::post('update', [UserController::class, 'update'])->name("update");
        });
        // only for signed in admins
        Route::group(['middleware' => 'role.admin'], function () {
            Route::get('/', [UserController::class, 'index'])->name("get-all-users");
            Route::post('upgrade', [UserController::class, 'upgrade'])->name("upgrade-user");
        });
    });

    // ItemController
    Route::group(['prefix' => 'items'], function ($router) {
        // for all signed in users, including admins
        Route::group(['middleware' => 'role.user'], function () {
            Route::post('/', [ItemController::class, 'index'])->name("get-all-items");
            // Route::get('/favorites', [ItemController::class, 'favorites'])->name("get-favorites");
            Route::get('/{id}', [ItemController::class, 'show'])->name("get-item");
        });
        // only for signed in admins
        Route::group(['middleware' => 'role.admin'], function () {
            Route::post('/create', [ItemController::class, 'create'])->name("create-item");
        });
    });

    // ReviewController
    Route::group(['prefix' => 'reviews'], function ($router) {
        // for all signed in users, including admins
        Route::group(['middleware' => 'role.user'], function () {
            Route::post('/create', [ReviewController::class, 'create'])->name("create-review");
        });
        // only for signed in admins
        Route::group(['middleware' => 'role.admin'], function () {
            Route::get('/', [ReviewController::class, 'index'])->name("get-inactive-reviews");
            Route::post('/activate', [ReviewController::class, 'activate'])->name("activate-review");
        });
    });

    // LikeController
    Route::group(['prefix' => 'likes'], function ($router) {
        // for all signed in users, including admins
        Route::group(['middleware' => 'role.user'], function () {
            Route::post('/toggle', [LikeController::class, 'toggle'])->name("toggle-like");
        });
    });

    // ImageController
    Route::group(['prefix' => 'images'], function ($router) {
        // only for signed in admins
        Route::group(['middleware' => 'role.admin'], function () {
            Route::post('/add', [ImageController::class, 'add'])->name("add-images");
        });
    });

    // CategoryController
    Route::group(['prefix' => 'categories'], function ($router) {
        // for all signed in users, including admins
        Route::group(['middleware' => 'role.user'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name("get-all-categories");
        });
        // only for signed in admins
        Route::group(['middleware' => 'role.admin'], function () {
            Route::post('/add', [CategoryController::class, 'add'])->name("add-category");
        });
    });
});
