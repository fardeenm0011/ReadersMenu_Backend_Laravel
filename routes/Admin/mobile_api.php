<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RasiController;
use App\Http\Controllers\Admin\RasiDailyController;
use App\Http\Controllers\Admin\PanchangamController;
use App\Http\Controllers\Admin\CalendarDailyInfoController;
use App\Http\Controllers\Admin\CalendarDetailsController;
use App\Http\Controllers\Admin\AdditionalDayInfoController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PaginationController;


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
Route::post('/updateDeviceToken', [AuthController::class, 'updateDeviceToken']);
Route::get('/getRoleList', [AuthController::class, 'getRoleList']);

Route::get('/category', [CategoryController::class, 'getCategory']);
Route::get('/subcategory', [CategoryController::class, 'getSubCategory']);
Route::post('/updateCategorySeo', [CategoryController::class, 'updateCategorySeo']);
Route::post('/getMainCategories', [CategoryController::class, 'getMainCategories']);

Route::get('/allPosts', [PostsController::class, 'getAllPosts']);
Route::get('/getPost', [PostsController::class, 'getPost']);
Route::post('/updateStatus', [PostsController::class, 'updateStatus']);
Route::delete('/deletePost', [PostsController::class, 'deletePost']);
Route::post('/savePost', [PostsController::class, 'savePost']);
Route::get('/countOfPosts', [PostsController::class, 'countOfPosts']);
Route::get('/unreadCountOfPosts', [PostsController::class, 'unreadCountOfPosts']);
Route::get('/postsbyCategory', [PostsController::class, 'postsbyCategory']);
Route::post('/postsbyCategoryPagination', [PostsController::class, 'postsbyCategoryPagination']);
Route::post('/loggedinUserPaginationposts', [PostsController::class, 'loggedinUserPaginationposts']);
Route::post('/loggedinUserposts', [PostsController::class, 'loggedinUserposts']);
Route::get('/getPostsCount', [PostsController::class, 'getPostsCount']);
Route::get('/getPostsCountByUser', [PostsController::class, 'getPostsCountByUser']);
Route::post('/updatePostSeo', [PostsController::class, 'updatePostSeo']);

Route::post('/addEmployee', [EmployeeController::class, 'addEmployee']);
Route::post('/updateEmployeeIsActive', [EmployeeController::class, 'updateIsActive']);
Route::get('/getEmployeesWithoutAdmin', [EmployeeController::class, 'getEmployeesWithoutAdmin']);

Route::get('/getRasi', [RasiController::class, 'getRasi']);

Route::post('/getDailyRasi', [RasiDailyController::class, 'getDailyRasi']);
Route::post('/getAllDailyRasi', [RasiDailyController::class, 'getAllDailyRasi']);

Route::post('/getPanchangam', [PanchangamController::class, 'getPanchangam']);
Route::post('/gowripanchangam', [PanchangamController::class, 'getGowriPanchangam']);
Route::post('/horainfo', [PanchangamController::class, 'getHora']);
Route::post('/panchangamadditional', [PanchangamController::class, 'getPanchangamAdditonal']);

Route::post('/getCalendarDaily', [CalendarDailyInfoController::class, 'getCalendarDaily']);
Route::post('/getAllInfo', [CalendarDailyInfoController::class, 'getAllInfo']);
Route::post('/getMuhurthamDays', [CalendarDailyInfoController::class, 'getMuhurthamDays']);
Route::post('/getHolidays', [CalendarDailyInfoController::class, 'getHolidays']);
Route::post('/getAdditionalDayInfo', [AdditionalDayInfoController::class, 'getAdditionalDayInfo']);
Route::post('/getCalendarImages', [CalendarDailyInfoController::class, 'getCalendarImages']);


Route::get('/specialdays', [CalendarDailyInfoController::class, 'getSpecialDays']);
Route::get('/daysbytype', [CalendarDailyInfoController::class, 'getDayTypes']);
Route::get('/additionaldaysbytype', [CalendarDailyInfoController::class, 'getAdditionalDayTypes']);

Route::get('/allinonebymonth', [CalendarDailyInfoController::class, 'getAllinonebymonth']);


Route::get('/dailyinfo', [CalendarDailyInfoController::class, 'getDailyInfo']);

Route::get('/tamengdates', [CalendarDailyInfoController::class, 'getTamEngDates']);
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('optimize:clear');
    // return what you want
});
Route::get('/clear-config', function() {
    $exitCode = Artisan::call('optimize:clear');
    // return what you want
});









