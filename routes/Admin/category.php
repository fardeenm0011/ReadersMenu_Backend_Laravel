<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostsController;

/************************ Category Routes Start ******************************/
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => '{language}'], function () {
        Route::get('/category/{id}', [CategoryController::class, 'index'])->name('category.get');
        Route::get('/post/search', [PostsController::class, 'search'])->name('post.search');
    });
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/category/add', [CategoryController::class, 'add'])->name('category.add');
    Route::delete('/category/{id}', [CategoryController::class, 'delete'])->name('category.delete');
});
/************************ Category Routes Ends ******************************/