<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\TugasController;
use App\Http\Controllers\Admin\ParameterLookupController;
use App\Http\Controllers\Admin\MicroLearningController;

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

Route::get('/', [AuthController::class, 'index'])->name('login');	
Route::post('/authentication', [AuthController::class, 'doAuth'])->name('doAuth');
Route::get('/logout', [AuthController::class, 'logout'])->name('doLogout');

Route::group(['middleware' => 'auth:admin'], function() {   
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');	
    //MENU MASTER USER
    Route::get('/user', [UserController::class, 'index'])->name('user');	
    Route::get('/user/data', [UserController::class, 'data'])->name('userData');	
    Route::get('/user/data/edit', [UserController::class, 'edit'])->name('userEdit');	
    Route::post('/user/data/save', [UserController::class, 'save'])->name('userSave');	
    Route::post('/user/data/delete', [UserController::class, 'delete'])->name('userDelete');

    //MENU MASTER JADWAL KULIAH
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');	
    Route::get('/jadwal/data', [JadwalController::class, 'data'])->name('jadwalData');	
    Route::get('/jadwal/edit', [JadwalController::class, 'edit'])->name('jadwalEdit');	
    Route::post('/jadwal/data/save', [JadwalController::class, 'save'])->name('jadwalSave');
    Route::post('/jadwal/data/delete', [JadwalController::class, 'delete'])->name('jadwalDelete');
    Route::post('/jadwal/data/generate', [JadwalController::class, 'generate'])->name('jadwalGenerate');

    //MENU TUGAS
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas');	
    Route::get('/tugas/data', [TugasController::class, 'data'])->name('tugasData');
    Route::post('/tugas/upload', [TugasController::class, 'upload'])->name('tugasUpload');
    Route::post('/tugas/nilai', [TugasController::class, 'nilai'])->name('tugasNilai');
    Route::get('/tugas/download', [TugasController::class, 'download'])->name('tugasDownload');

    //MICRO LEARNING
    Route::get('/microLearning', [MicroLearningController::class, 'index'])->name('microLearning');	
    Route::get('/microLearning/data', [MicroLearningController::class, 'data'])->name('microLearningData');

    //PARAMETER
    Route::get('/parameter', [ParameterLookupController::class, 'lookup'])->name('parameterLookup');	

});