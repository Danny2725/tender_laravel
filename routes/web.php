<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\UserController;

// Home Page
Route::get('/', [UserController::class, 'login'])->name('login');

// Tender view Routes
Route::get('/tender/create', [TenderController::class, 'create'])->name('tender.create');
Route::post('/tender/store', [TenderController::class, 'store'])->name('tender.store');
Route::get('/tender/list_contractor', [TenderController::class, 'listContractor'])->name('tender.list_contractor');
Route::get('/tender/list_supplier', [TenderController::class, 'listSupplier'])->name('tender.list_supplier');
Route::get('/tender/detail/{id}', [TenderController::class, 'detail'])->name('tender.detail');
Route::get('/tender/edit/{id}', [TenderController::class, 'edit'])->name('tender.edit');

// Tender crud
Route::post('/tender/update/{id}', [TenderController::class, 'update'])->name('tender.update');
Route::delete('/tender/delete/{id}', [TenderController::class, 'destroy'])->name('tender.delete');
Route::put('/tender/update/{id}', [TenderController::class, 'update'])->name('tender.update');

// Additional Tender Actions
Route::get('/tender/edit/{title}', [TenderController::class, 'edit'])->name('tender.edit');
Route::get('/tender/delete/{title}', [TenderController::class, 'delete'])->name('tender.delete');
Route::get('/tender/view/{title}', [TenderController::class, 'view'])->name('tender.view');
Route::get('/tender/apply/{title}', [TenderController::class, 'apply'])->name('tender.apply');

// Authentication Routes
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Optional: Register Route (if you have a registration page)
Route::get('/register', [UserController::class, 'register'])->name('register');
