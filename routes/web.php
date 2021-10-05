<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

// Student Controller
Route::get('get-all-student', [StudentController::class, 'getAllStudent'])->name('getAllStudent');
Route::get('student', [StudentController::class, 'index'])->name('student.index');
Route::post('student', [StudentController::class, 'store'])->name('student.store');
Route::get('student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
Route::put('student/{id}', [StudentController::class, 'update']);
Route::delete('student/{id}', [StudentController::class, 'destroy']);


// Customer Controller
Route::get('get-customers', [CustomerController::class, 'getCustomers'])->name('get-customers');
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit']);
Route::put('/customer/{id}', [CustomerController::class, 'update']);
Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);
