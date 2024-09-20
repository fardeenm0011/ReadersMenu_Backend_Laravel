<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\BaseSettingController;
use App\Http\Controllers\Admin\MpeoplesContactController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/signin', [AuthController::class, 'authenticate']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/signout', [AuthController::class, 'signout']);
Route::post('/changePassword', [AuthController::class, 'changePassword']);
Route::post('/updateProfile', [AuthController::class, 'updateProfile']);
Route::get('/getRoleList', [AuthController::class, 'getRoleList']);


Route::get('/category', [CategoryController::class, 'getCategory']);
Route::post('/getMainCategories', [CategoryController::class, 'getMainCategories']);
Route::get('/getAllMainCategories', [CategoryController::class, 'getAllMainCategories']);
Route::get('/getMainCategory', [CategoryController::class, 'getMainCategory']);
Route::post('/addMainCategory', [CategoryController::class, 'add']);
Route::post('/updateMainCategory', [CategoryController::class, 'updateCategory']);
Route::delete('/deleteMainCategory', [CategoryController::class, 'deleteCategory']);
Route::post('/getMainCategoryTotalPage', [CategoryController::class, 'getMainCategoryTotalPage']);
Route::post('/getSubcategories', [CategoryController::class, 'getSubcategories']);
Route::get('/getSubCategory', [CategoryController::class, 'getSubCategory']);
Route::post('/addSubCategory', [CategoryController::class, 'add']);
Route::post('/updateSubCategory', [CategoryController::class, 'updateCategory']);
Route::delete('/deleteSubCategory', [CategoryController::class, 'deleteCategory']);
Route::post('/getSubCategoryTotalPage', [CategoryController::class, 'getSubCategoryTotalPage']);


Route::post('/getPosts', [PostsController::class, 'getPosts']);
Route::get('/getPost', [PostsController::class, 'getPost']);
Route::post('/updateIsActive', [PostsController::class, 'updateIsActive']);
Route::post('/updateIsBreaking', [PostsController::class, 'updateIsBreakingStatus']);
Route::delete('/deletePost', [PostsController::class, 'deletePost']);
Route::post('/savePost', [PostsController::class, 'savePost']);
Route::post('/getPostTotalPage', [PostsController::class, 'getPostTotalPage']);
Route::get('/getPostsCount', [PostsController::class, 'getPostsCount']);


Route::post('/getEmployees', [EmployeeController::class, 'getEmployees']);
Route::get('/getEmployee', [EmployeeController::class, 'getEmployee']);
Route::post('/addEmployee', [EmployeeController::class, 'addEmployee']);
Route::post('/updateEmployee', [EmployeeController::class, 'updateEmployee']);
Route::post('/updateEmployeePassword', [EmployeeController::class, 'updateEmployeePassword']);
Route::delete('/deleteEmployee', [EmployeeController::class, 'deleteEmployee']);
Route::get('/getEmployeeCount', [EmployeeController::class, 'getEmployeeCount']);
Route::post('/getEmployeeTotalPage', [EmployeeController::class, 'getEmployeeTotalPage']);
Route::post('/updateEmployeeIsActive', [EmployeeController::class, 'updateIsActive']);

Route::post('/addRole', [RoleController::class, 'addRole']);
Route::post('/getRoles', [RoleController::class, 'getRoles']);
Route::get('/getRole', [RoleController::class, 'getRole']);
Route::post('/updateRole', [RoleController::class, 'updateRole']);
Route::delete('/deleteRole', [RoleController::class, 'deleteRole']);
Route::post('/getRoleTotalPage', [RoleController::class, 'getRoleTotalPage']);

Route::post('/getComments', [CommentsController::class, 'getComments']);
Route::get('/getComment', [CommentsController::class, 'getComment']);
Route::post('/updateCommentsIsActive', [CommentsController::class, 'updateIsActive']);
Route::post('/updateComment', [CommentsController::class, 'updateComment']);
Route::post('/getCommentTotalPage', [CommentsController::class, 'getCommentTotalPage']);

Route::post('/saveSetting', [BaseSettingController::class, 'save']);
Route::get('/getSetting', [BaseSettingController::class, 'getSetting']);

Route::post('/contact', [MpeoplesContactController::class, 'save']);
Route::post('/getMpeoplesContact', [MpeoplesContactController::class, 'getMpeoplesContact']);
Route::post('/getMpeoplesStudent', [MpeoplesContactController::class, 'getMpeoplesStudent']);
Route::post('/getMpeoplesStudentDetails', [MpeoplesContactController::class, 'getMpeoplesStudentDetails']);













