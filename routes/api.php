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

/**
 * User API routes
 */
Route::get('/user', [App\Http\Controller\Api\UserController::class, 'index']);
Route::get('/user/{id}', [App\Http\Controller\Api\UserController::class, 'find']);
Route::get('/user/{id}/posts', [App\Http\Controller\Api\UserController::class, 'findPosts']);


/**
 * Post API routes
 */
Route::get('/post', [App\Http\Controller\Api\PostController::class, 'index']);
Route::get('/post/{id}', [App\Http\Controller\Api\PostController::class, 'find']);
Route::get('/post/{id}/comments', [App\Http\Controller\Api\PostController::class, 'findComments']);
