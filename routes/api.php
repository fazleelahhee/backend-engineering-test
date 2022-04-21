<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(["namespace" => "App\Http\Controllers\Api"], function () {
    //API route for register new user
    Route::post('/register', "AuthController@register");
    //API route for login user
    Route::post('/login', "AuthController@login");

    Route::group(["middleware" => "auth:sanctum"], function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::resource("movies", "MovieController", ['only' => ['index']]);

        // API route for logout user
        Route::post('/logout', "AuthController@logout");
    });
});
