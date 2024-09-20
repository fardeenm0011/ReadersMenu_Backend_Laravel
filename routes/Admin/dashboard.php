<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

/************************ Dashboard Routes Start ******************************/
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => '{language}'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});
/************************ Dashboard Routes Ends ******************************/