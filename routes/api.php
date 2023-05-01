<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
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

Route::middleware(['auth:sanctum', 'admin'])->group(function(){
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //article
    Route::apiResource('articles', ArticleController::class);
    Route::post('/isExistArticle', [ArticleController::class, 'isExistArticle']);
    Route::post('/articleItems', [ArticleController::class, 'deleteItems']);
    //article categoires
    Route::get('/articleCategories', [ArticleCategoryController::class, 'index']);
    Route::post('/articleCategory', [ArticleCategoryController::class, 'store']);
    Route::delete('/articleCategory/{id}', [ArticleCategoryController::class, 'destroy']);
    Route::post('/articleCategoryItems', [ArticleCategoryController::class, 'deleteItems']);

});

Route::post('/login', [AuthController::class, 'login']);