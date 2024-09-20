<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EmployeeController;

/************************ Employee Routes Start ******************************/
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => '{language}'], function () {
        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.all');
        Route::get('/employee/search', [EmployeeController::class, 'search'])->name('employee.search');
    });
    Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::put('/employee/password/{id}', [EmployeeController::class, 'updatePassword'])->name('employee.updatePassword');
    Route::delete('/employee/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
    Route::post('/employee/save', [EmployeeController::class, 'save'])->name('employee.save');

});
/************************ Employee Routes Ends ******************************/