<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

// Home Page
Route::get('/', [UserController::class, 'login'])->name('login')->withoutMiddleware(['web', 'csrf']);

// Tender view Routes
Route::get('/tender/create', [TenderController::class, 'create'])->name('tender.create')->withoutMiddleware(['web', 'csrf']);
Route::post('/tender/store', [TenderController::class, 'store'])->name('tender.store')->withoutMiddleware(['web', 'csrf']);
Route::get('/tender/list_contractor', [TenderController::class, 'listContractor'])->name('tender.list_contractor')->withoutMiddleware(['web', 'csrf']);
Route::get('/tender/list_supplier', [TenderController::class, 'listSupplier'])->name('tender.list_supplier')->withoutMiddleware(['web', 'csrf']);
Route::get('/tender/detail/{id}', [TenderController::class, 'detail'])->name('tender.detail')->withoutMiddleware(['web', 'csrf']);
Route::get('/tender/edit/{id}', [TenderController::class, 'edit'])->name('tender.edit')->withoutMiddleware(['web', 'csrf']);


// Authentication routes without CSRF
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware(['web', 'csrf']);
Route::get('/register', [AuthController::class, 'register'])->name('register')->withoutMiddleware(['web', 'csrf']);
Route::get('/login', [AuthController::class, 'login'])->name('login')->withoutMiddleware(['web', 'csrf']);

// POST routes for authentication without CSRF
Route::post('/register', [AuthController::class, 'signUp'])->withoutMiddleware(['web', 'csrf']);
Route::post('/login', [AuthController::class, 'signIn'])->withoutMiddleware(['web', 'csrf']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->withoutMiddleware(['web', 'csrf']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api')->withoutMiddleware(['web', 'csrf']);
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->withoutMiddleware(['web', 'csrf']);