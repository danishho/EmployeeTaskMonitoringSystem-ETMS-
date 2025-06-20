<?php

use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/admin', 'admin.index');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::view('/user/add', 'admin.add-user');
Route::post('/user/add', [UserController::class, 'store']);
Route::post('/excel/add', [ImportExcelController::class, 'excelStore']);

Route::get('/export/user', [ExportExcelController::class, 'export']);

Route::get('/user/list', [UserController::class, 'list'])->name('user.list');
Route::post('/user/{user}/delete', [UserController::class, 'destroy'])->name('user.delete');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/{user}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
Route::post('/user/{user}/edit/store', [UserController::class, 'editStore'])->name('user.editStore');
