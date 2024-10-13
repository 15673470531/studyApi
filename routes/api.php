<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VersionController;
use App\Http\Controllers\Api\WxOpenapiController;
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

Route::middleware(['cross','parseToken'])->group(function (){
    Route::get('article/getArticle/{articleId}', [ArticleController::class, 'getArticle']);
    Route::get('article/getArticleList/{userid}', [ArticleController::class, 'getArticleList']);
    Route::get('article/getArticleListByTermId/{termId}', [ArticleController::class, 'getArticleListByTermId']);
    Route::get('term/list', [TermController::class, 'getTermList']);
    Route::get('openapi/validateCode', [UserController::class, 'getUserToken']);
    Route::post('feedback/submit', [FeedbackController::class, 'submit']);
    Route::get('version/getList', [VersionController::class, 'getVersionList']);


});

