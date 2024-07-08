<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\BarTypeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::middleware('auth:api')->post('/profile_upload', [UserController::class, 'uploadImage']);
Route::post('/forget-password', [ForgetPasswordController::class, 'forgotPassword']);
Route::post('/password-reset', [ForgetPasswordController::class, 'resetPassword']);
Route::middleware('auth:api')->post('/update-profile', [UserController::class, 'updateProfile']);
Route::middleware('auth:api')->post('/edit-profile', [UserController::class, 'EditProfile']);
Route::middleware('auth:api')->get('/fetch-profile', [UserController::class, 'fetchProfile']);
Route::middleware('auth:api')->post('/delete-profile', [UserController::class, 'deleteProfile']);
Route::middleware('auth:api')->post('/add-bar', [BarTypeController::class, 'store']);
Route::middleware('auth:api')->post('/edit-bars', [BarTypeController::class, 'EditBar']);
Route::middleware('auth:api')->post('/review', [RatingController::class, 'reviews']);
Route::middleware('auth:api')->post('/delete-bar', [BarTypeController::class, 'deleteBar']);
Route::get('/bars' , [BarTypeController::class, 'getBars']);
Route::middleware('auth:api')->post('/bookmark', [RatingController::class, 'bookmark']);
Route::middleware('auth:api')->post('/delete/bookmark', [RatingController::class, 'deleteBookmark']);
Route::get('/rating', [RatingController::class, 'getBarRatings']);
//Route::get('/bars', [BarTypeController::class, 'allBars']);
Route::get('/recommended', [BarTypeController::class, 'recommendedBars']);
Route::get('/nearest', [BarTypeController::class, 'nearestBar']);
Route::post('/visited-bars', [BarTypeController::class, 'visitedBar']);
Route::get('/visited-bars', [BarTypeController::class, 'getVisitedBarsByType']);

Route::get('/get-bar-by-type', [BarTypeController::class, 'getBarByType']);
Route::get('/bookmarks', [BarTypeController::class, 'getBookmark']);
Route::post('/social', [UserController::class, 'socialLogin']);

Route::get('/bookmarks/user', [RatingController::class, 'getBookmarksByUserId']);
Route::get('/search', [BarTypeController::class, 'search']);