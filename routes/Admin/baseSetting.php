<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BaseSettingController;

/************************ Category Routes Start ******************************/
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => '{language}'], function () {
        Route::get('/baseSetting', [BaseSettingController::class, 'index'])->name('baseSetting.all');
        ;
    });
    Route::post('/save-complete-form', [BaseSettingController::class, 'saveSetting'])->name('baseSetting.save');

});
/************************ Category Routes Ends ******************************/