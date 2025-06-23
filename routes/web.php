<?php

use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\StaffController;
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
Route::get('/hod/monitor-task/', [HodController::class, 'monitorTask'])->name('hod.monitorTask');
Route::get('/hod/monitor-task/{task}', [HodController::class, 'monitorTaskDetail'])->name('hod.monitorTaskDetail');
Route::post('hod/task/delete/{task}', [HodController::class, 'deleteTask'])->name('hod.deleteTask');
Route::post('/hod/task/comment/{task}', [HodController::class, 'commentTask'])->name('hod.commentTask');
Route::get('/hod/report', [HodController::class, 'report'])->name('hod.report');
Route::get('/hod/report/download', [\App\Http\Controllers\HodController::class, 'downloadReport'])->name('hod.report.download');

Route::get('staff', [StaffController::class, 'index'])->name('staff.dashboard');
Route::get('staff/task', [StaffController::class, 'task'])->name('staff.task');
Route::get('staff/update-task/{task}', [StaffController::class, 'updateProgress'])->name('staff.updateProgress');
Route::post('staff/update-task/{task}', [StaffController::class, 'updateProgressStore'])->name('staff.updateProgressStore');
Route::get('staff/monitor-task/{task}', [StaffController::class, 'TaskDetail'])->name('staff.TaskDetail');
Route::get('staff/task/complete/{task}', [StaffController::class, 'TaskMarkComplete'])->name('staff.TaskMarkComplete');
Route::post('staff/upload-profile-image', [\App\Http\Controllers\StaffController::class, 'uploadProfileImage'])->name('staff.uploadProfileImage');


