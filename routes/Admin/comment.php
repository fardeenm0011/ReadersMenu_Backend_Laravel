<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CommentsController;

/************************ Comment Routes Start ******************************/
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => '{language}'], function () {
        Route::get('/comment', [CommentsController::class, 'index'])->name('comment.all');
        Route::get('/comment/search', [CommentsController::class, 'search'])->name('comment.search');
    });
    Route::get('/comment/edit/{id}', [CommentsController::class, 'edit'])->name('comment.edit');
    Route::put('/comment/{id}', [CommentsController::class, 'update'])->name('comment.update');
    Route::post('/update-comment-is-active', [CommentsController::class, 'updateIsActive'])->name('comment.updateIsActive');

});
/************************ Comment Routes Ends ******************************/