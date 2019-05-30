<?php

use Deviate\Users\Client\FetchesUsersClientInterface;
use Illuminate\Http\Request;

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

Route::get('/users/{userId}', function (FetchesUsersClientInterface $users, $userId) {
    return $users->fetchUserById($userId)->toArray();
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
