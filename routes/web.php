<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

	// user route
	Route::resource('dashboard', \App\Http\Controllers\DashboardController::class)->only(['index', 'update']);
	Route::resource('absence', \App\Http\Controllers\AbsenceController::class)->except(['edit', 'update', 'destroy']);
	Route::resource('overtime', \App\Http\Controllers\OvertimeController::class)->only(['index', 'show']);
	Route::put('overtime/{id}/approved', [\App\Http\Controllers\OvertimeController::class, 'approved'])->name('overtime.approved');
	Route::resource('bonus', \App\Http\Controllers\BonusController::class)->only(['index']);
	Route::resource('training', \App\Http\Controllers\TrainingController::class)->only(['index']);
	Route::resource('announcement', \App\Http\Controllers\AnnouncementController::class)->only(['index', 'show']);


	//admin route
	Route::resource('user-management', \App\Http\Controllers\UserController::class);
	Route::resource('absence-management', \App\Http\Controllers\AbsenceController::class)->except(['edit', 'update', 'destroy']);
	Route::post('absence-management/bukti', [\App\Http\Controllers\AbsenceController::class, 'uploadBukti'])->name('absence-management.bukti');
	Route::put('absence-management/{id}/approved', [\App\Http\Controllers\AbsenceController::class, 'approved'])->name('absence-management.approved');
	Route::put('absence-management/{id}/pemotongan', [\App\Http\Controllers\AbsenceController::class, 'pemotongan'])->name('absence-management.pemotongan');
	Route::resource('overtime-management', \App\Http\Controllers\OvertimeController::class)->only(['index', 'create', 'show', 'store']);
	Route::resource('bonus-management', \App\Http\Controllers\BonusController::class);
	Route::put('overtime-management/{id}/approved', [\App\Http\Controllers\OvertimeController::class, 'approved'])->name('overtime-management.approved');
	Route::resource('announcement-management', \App\Http\Controllers\AnnouncementController::class)->except(['show']);
	Route::post('announcement-management/banner', [\App\Http\Controllers\AnnouncementController::class, 'uploadBanner'])->name('announcement-management.banner');
	Route::resource('training-management', \App\Http\Controllers\TrainingController::class)->except(['show']);
	Route::post('training-management/file', [\App\Http\Controllers\TrainingController::class, 'uploadFile'])->name('training-management.file');
	Route::resource('payslip-management', \App\Http\Controllers\PaySlipController::class)->only(['index']);
	Route::get('payslip-management/export', [\App\Http\Controllers\PaySlipController::class, 'export']);
	Route::get('payslip', [\App\Http\Controllers\PaySlipController::class, 'me']);
	Route::get('payslip/print', [\App\Http\Controllers\PaySlipController::class, 'print']);

	Route::get('/', [HomeController::class, 'home']);

	Route::get('/logout', [SessionsController::class, 'destroy']);
});



Route::group(['middleware' => 'guest'], function () {
	Route::get('/login', [SessionsController::class, 'create'])->name('login');
	Route::post('/session', [SessionsController::class, 'store']);
});