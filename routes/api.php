<?php

use App\Http\Controllers\Api\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Subscription;
use App\Http\Controllers\Api\Message;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('/register', [AuthController::class, 'register']);
    });

    Route::group(['middleware' => ['jwt.verify']], function ($router) {
        Route::group(['prefix' => 'auth'], function ($router) {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/user-profile', [AuthController::class, 'userProfile']);
        });
            Route::post('/topic', [Topic::class, 'topic']);
            Route::post('/subscribe/{topic}', [Subscription::class, 'subscribe']);
            Route::post('/publish/{topic}', [Message::class, 'publish']);
    });
