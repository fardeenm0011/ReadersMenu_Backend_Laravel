<?php

use App\Http\Controllers\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\PostsController;
use App\Http\Controllers\User\BaseSettingController;
use App\Http\Controllers\User\CommentsController;
use App\Http\Controllers\User\LikesController;

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

Route::post('/user/signin', [AuthController::class, 'signin']);
Route::post('/user/signup', [AuthController::class, 'signup']);
Route::post('/user/forgotPassword', [AuthController::class, 'forgotPassword']);
Route::middleware('auth:sanctum')->get('/user/signinWithToken', [AuthController::class, 'signinWithToken']);

Route::post('/user/verify-email', [AuthController::class, 'verifyEmail']);

Route::get('/user/allCategories', [CategoryController::class, 'getAllCategories']);
Route::get('/user/categories', [CategoryController::class, 'index']);
Route::get('/user/subcategory', [CategoryController::class, 'getSubCategory']);
Route::get('/user/homePagecategories', [CategoryController::class, 'homePagecategories']);
Route::get('/user/posts', [CategoryController::class, 'getPostsById']);
Route::get('/user/pagenationPosts', [CategoryController::class, 'getPagenationPosts']);
Route::get('/user/homePosts', [CategoryController::class, 'getHomepagePosts']);
Route::get('/user/findPost', [CategoryController::class, 'getFindPost']);
Route::get('/user/popularPosts', [CategoryController::class, 'getPopularPosts']);
Route::get('/user/relatedPost', [CategoryController::class, 'getRelatedPost']);
Route::get('/user/seoCategory', [CategoryController::class, 'getSeoCategory']);
Route::get('/user/getSeoKey', [CategoryController::class, 'getSeokey']);
Route::post('/user/checkBreadcrumb', [CategoryController::class, 'checkBreadcrumb']);

Route::get('/user/spotlight', [PostsController::class, 'getSpotlight']);
Route::get('/user/pagenationSpotlightPosts', [PostsController::class, 'getSpotlightPosts']);
Route::get('/user/pagenationTrendingPosts', [PostsController::class, 'getTrendingPosts']);
Route::get('/user/seoPost', [PostsController::class, 'getSeoPost']);
Route::get('/user/allPosts', [PostsController::class, 'getAllPosts']);

Route::get('/user/allNewsPostsSeo', [PostsController::class, 'getAllNewsPostsSeo']);
Route::get('/user/allArticlePostsSeo', [PostsController::class, 'getAllArticlePostsSeo']);
Route::get('/user/setting', [BaseSettingController::class, 'index']);

Route::post('/user/getComments', [CommentsController::class, 'getCommentByPostId']);
Route::post('/user/saveComment', [CommentsController::class, 'saveComment']);

Route::get('/user/getLikesByUser', [LikesController::class, 'getLikesByUser']);
Route::post('/user/updateLikes', [LikesController::class, 'updateLikes']);



Route::get('/user/findPostById', [CategoryController::class, 'getFindPostById']);


