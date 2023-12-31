<?php

use App\Http\Controllers\API\V1\Admin\Management\PermissionController;
use App\Http\Controllers\API\V1\Admin\Management\RoleController;
use App\Http\Controllers\API\V1\Admin\Management\UserController;
use App\Http\Controllers\API\V1\Auth\AuthenticationController;
use App\Http\Controllers\API\V1\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix("v1")->name("v1.")->group(function () {
    Route::prefix("auth")->name("auth.")->controller(AuthenticationController::class)->group(function () {
        Route::post("", "authenticate")->name("authenticate");
        Route::post("logout", "logout")->name("logout")->middleware("auth.jwt:access");
        Route::post("refresh", "refresh")->name("refresh")->middleware("auth.jwt:refresh");
    });

    Route::middleware("auth.jwt")->group(function () {
        Route::prefix("admin")->name("admin.")->group(function () {
            Route::prefix("management")->name("management.")->group(function () {
                Route::prefix("users")->name("users.")->controller(UserController::class)->group(function () {
                    Route::get("", "index")->name("index");
                });

                Route::prefix("permissions")->name("permissions.")->controller(PermissionController::class)->group(function () {
                    Route::get("", "index")->name("index");
                });

                Route::prefix("roles")->name("roles.")->controller(RoleController::class)->group(function () {
                    Route::get("", "index")->name("index");
                    Route::get("{id}", "show")->name("show");
                    Route::post("", "store")->name("store");
                    Route::patch("{id}", "update")->name("update");
                });
            });
        });

        Route::prefix("profiles")->name("profile.")->controller(ProfileController::class)->group(function () {
            Route::get("", "show")->name("show");
            Route::patch("", "update")->name("update");
            Route::patch("password", "updatePassword")->name("update.password");
        });
    });


    Route::prefix("master")->name("master.")->group(function () {
        Route::get("roles", \App\Http\Controllers\API\V1\Master\RoleController::class);
        Route::get("permissions", \App\Http\Controllers\API\V1\Master\PermissionController::class);
    });
});

