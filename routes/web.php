<?php

use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/admin', 'admin.index')->name('admin.dashboard');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::view('/user/add', 'admin.add-user');
Route::post('/user/add', [UserController::class, 'store']);
Route::post('/excel/add', [ImportExcelController::class, 'excelStore']);

Route::get('/export/user', [ExportExcelController::class, 'export']);

Route::get('/user/list', [UserController::class, 'list'])->name('user.list');
Route::post('/user/{user}/delete', [UserController::class, 'destroy'])->name('user.delete');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/{user}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
Route::post('/user/{user}/edit/store', [UserController::class, 'editStore'])->name('user.editStore');

Route::get('/hod', [HodController::class, 'index'])->name('hod.dashboard');
Route::get('/hod/staffInfo', [HodController::class, 'staffInfo'])->name('hod.staffInfo');
Route::post('/hod/staffInfo/{user}', [HodController::class, 'staffInfoStore'])->name('hod.staffInfoStore');
Route::get('/hod/create/task', [HodController::class, 'createTask'])->name('hod.createTask');
Route::post('/hod/create/task', [HodController::class, 'storeTask'])->name('hod.storeTask');


