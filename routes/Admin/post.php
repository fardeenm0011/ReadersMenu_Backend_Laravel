<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostsController;

/************************ Category Routes Start ******************************/
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => '{language}'], function () {
        Route::get('/post/{id}', [PostsController::class, 'index'])->name('post.all');
        ;
    });
    Route::post('/post/save', [PostsController::class, 'save'])->name('post.save');
    Route::put('/post/edit/{id}', [PostsController::class, 'edit'])->name('post.edit');
    Route::delete('/post/{id}', [PostsController::class, 'delete'])->name('post.delete');
    Route::post('/update-is-active', [PostsController::class, 'updateIsActive'])->name('post.updateIsActive');
    Route::post('/update-is-breaking', [PostsController::class, 'updateIsBreaking'])->name('post.updateIsBreaking');

});
/************************ Category Routes Ends ******************************/