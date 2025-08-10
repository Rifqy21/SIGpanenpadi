<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\BPSAdminController;
use App\Http\Controllers\BPSController;


// group route with guest middleware
Route::get('/logout', [AuthentificationController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
    Route::get('/dataPanen', [LandingPageController::class, 'dataPanen'])->name('data-panen');
    Route::get('/bpsMaps', [LandingPageController::class, 'bpsMaps'])->name('bps-maps');
    Route::get('/landing/limits-panen', [LandingPageController::class, 'getPanenLimits']);

    Route::get('/login', [AuthentificationController::class, 'login'])->name('login');
    Route::get('/register', [AuthentificationController::class, 'register'])->name('register');
    Route::post('/authLogin', [AuthentificationController::class, 'authLogin'])->name('authLogin');
    Route::post('/authRegis', [AuthentificationController::class, 'authRegis'])->name('authRegis');

});

Route::middleware('auth')->group(function () {
    Route::get('/validateRole', [AuthentificationController::class, 'validateRole'])->name('validateRole');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.index');
    Route::get('/limits-panen', [BpsAdminController::class, 'getPanenLimits']);
    
    
// BPS Admin Routes
Route::prefix('admin/bps')->name('bps.')->group(function () {
    Route::get('/', [BPSAdminController::class, 'index'])->name('index');
    Route::post('/', [BPSAdminController::class, 'store'])->name('store');
    Route::put('/{id}', [BPSAdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [BPSAdminController::class, 'destroy'])->name('destroy');
    Route::get('/map', [BPSAdminController::class, 'map'])->name('map');
});

    Route::get('/createDataPanen', [AdminDashboardController::class, 'createDataPanen'])->name('createDataPanen');
    Route::post('/insertDataPanen', [AdminDashboardController::class, 'insertDataPanen'])->name('insertDataPanen');
    Route::get('/admin/panen/show/{id}', [AdminDashboardController::class, 'show'])->name('admin.panen.show');
    Route::get('/admin/panen/edit/{id}', [AdminDashboardController::class, 'edit'])->name('admin.panen.edit');
    Route::put('/admin/panen/update/{id}', [AdminDashboardController::class, 'update'])->name('admin.panen.update');
    Route::delete('/admin/panen/delete/{id}', [AdminDashboardController::class, 'delete'])->name('admin.panen.delete');


    Route::get('/admin/data-bps', [BPSAdminController::class, 'index'])->name('admin.data-bps.index');
    Route::get('/admin/data-bps/map', [BPSAdminController::class, 'map'])->name('admin.data-bps.map');
    Route::get('/getGeoJsonPanen', [AdminDashboardController::class, 'getGeoJsonPanen']);
    Route::get('/limits-by-category', [AdminDashboardController::class, 'getLimitsByCategory']);


    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin');
    Route::get('/tambah', [AdminDashboardController::class, 'tambah'])->name('admin.tambah');
    Route::post('/insertPanen', [AdminDashboardController::class, 'insertPanen'])->name('insertPanen');
    Route::get('/panen/show/{id}', [AdminDashboardController::class, 'show'])->name('panen.show');
    Route::get('/panen/edit/{id}', [AdminDashboardController::class, 'edit'])->name('panen.edit');
    Route::put('/panen/update/{id}', [AdminDashboardController::class, 'update'])->name('panen.update');
    Route::delete('/panen/delete/{id}', [AdminDashboardController::class, 'delete'])->name('panen.delete');

    
    

});
