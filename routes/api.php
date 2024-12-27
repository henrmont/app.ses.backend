<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('create', [AuthController::class, 'create']);
    Route::post('resend', [AuthController::class, 'resend']);
    Route::post('verification', [AuthController::class, 'verification']);
    Route::post('recover', [AuthController::class, 'recover']);
    Route::post('reset', [AuthController::class, 'reset']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('permission', [AuthController::class, 'permission']);

});

Route::group(['middleware' => 'api', 'prefix' => 'notification'], function ($router) {

    Route::get('get/notifications/user', [NotificationController::class, 'getNotificationsUser']);
    Route::get('get/count/unread/notifications/user', [NotificationController::class, 'getCountUnreadNotificationsUser']);
    Route::put('set/unread/notifications/user', [NotificationController::class, 'setUnreadNotificationsUser']);
    Route::delete('remove/notification/{id}', [NotificationController::class, 'removeNotification']);

});

Route::group(['middleware' => 'api', 'prefix' => 'profile'], function ($router) {

    Route::get('get/profile', [ProfileController::class, 'getProfile']);
    Route::put('set/profile/info', [ProfileController::class, 'setProfileInfo']);
    Route::put('set/profile/picture', [ProfileController::class, 'setProfilePicture']);

});

Route::group(['middleware' => 'api', 'prefix' => 'article'], function ($router) {

    Route::get('get/articles', [ArticleController::class, 'getArticles']);

});

Route::group(['middleware' => 'api', 'prefix' => 'chat'], function ($router) {

    Route::get('get/chats', [ChatController::class, 'getChats']);
    Route::get('get/chat/{id}', [ChatController::class, 'getChat']);
    Route::get('get/pending/chats', [ChatController::class, 'getPendingChats']);
    Route::post('register/message', [ChatController::class, 'registerMessage']);

});
