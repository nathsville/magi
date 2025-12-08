<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\DPPKBController;
use App\Http\Controllers\OrangTuaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes (untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated Routes (untuk yang sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:Admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Data Master
        Route::get('/datamaster', [AdminController::class, 'datamasterIndex'])->name('datamaster');
        Route::get('/datamaster/search', [AdminController::class, 'datamasterSearch'])->name('datamaster.search');
        Route::get('/datamaster/create', [AdminController::class, 'datamasterCreate'])->name('datamaster.create');
        Route::post('/datamaster', [AdminController::class, 'datamasterStore'])->name('datamaster.store');
        Route::get('/datamaster/{id}/edit', [AdminController::class, 'datamasterEdit'])->name('datamaster.edit');
        Route::put('/datamaster/{id}', [AdminController::class, 'datamasterUpdate'])->name('datamaster.update');
        Route::delete('/datamaster/{id}', [AdminController::class, 'datamasterDestroy'])->name('datamaster.destroy');
        
        // Users Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/search', [AdminController::class, 'usersSearch'])->name('users.search');
        Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('users.create');
        Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'usersUpdate'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
        Route::post('/users/{id}/reset-password', [AdminController::class, 'usersResetPassword'])->name('users.reset-password');
        Route::post('/users/{id}/toggle-status', [AdminController::class, 'usersToggleStatus'])->name('users.toggle-status');
        
        // Puskesmas Management
        Route::get('/puskesmas', [AdminController::class, 'puskesmas'])->name('puskesmas');
        Route::get('/puskesmas/search', [AdminController::class, 'puskesmasSearch'])->name('puskesmas.search');
        Route::get('/puskesmas/create', [AdminController::class, 'puskesmasCreate'])->name('puskesmas.create');
        Route::post('/puskesmas', [AdminController::class, 'puskesmasStore'])->name('puskesmas.store');
        Route::get('/puskesmas/{id}/edit', [AdminController::class, 'puskesmasEdit'])->name('puskesmas.edit');
        Route::put('/puskesmas/{id}', [AdminController::class, 'puskesmasUpdate'])->name('puskesmas.update');
        Route::delete('/puskesmas/{id}', [AdminController::class, 'puskesmasDestroy'])->name('puskesmas.destroy');
        
        // Posyandu Management
        Route::get('/posyandu', [AdminController::class, 'posyandu'])->name('posyandu');
        Route::get('/posyandu/search', [AdminController::class, 'posyanduSearch'])->name('posyandu.search');
        Route::get('/posyandu/create', [AdminController::class, 'posyanduCreate'])->name('posyandu.create');
        Route::post('/posyandu', [AdminController::class, 'posyanduStore'])->name('posyandu.store');
        Route::get('/posyandu/{id}/edit', [AdminController::class, 'posyanduEdit'])->name('posyandu.edit');
        Route::put('/posyandu/{id}', [AdminController::class, 'posyanduUpdate'])->name('posyandu.update');
        Route::delete('/posyandu/{id}', [AdminController::class, 'posyanduDestroy'])->name('posyandu.destroy');
        
        // Broadcast Management
        Route::get('/broadcast', [AdminController::class, 'broadcast'])->name('broadcast');
        Route::post('/broadcast/send', [AdminController::class, 'broadcastSend'])->name('broadcast.send');
        Route::get('/broadcast/history', [AdminController::class, 'broadcastHistory'])->name('broadcast.history');
        
        // Audit Log
        Route::get('/audit-log', [AdminController::class, 'auditLog'])->name('audit-log');
        Route::get('/audit-log/filter', [AdminController::class, 'auditLogFilter'])->name('audit-log.filter');
        Route::get('/audit-log/{id}/detail', [AdminController::class, 'auditLogDetail'])->name('audit-log.detail');
        Route::get('/audit-log/export', [AdminController::class, 'auditLogExport'])->name('audit-log.export');
    });
    
    // Petugas Posyandu Routes
    Route::prefix('posyandu')->name('posyandu.')->middleware('role:Petugas Posyandu')->group(function () {
        Route::get('/dashboard', [PosyanduController::class, 'dashboard'])->name('dashboard');
        
        // Input Data Pengukuran
        Route::get('/input-data', [PosyanduController::class, 'inputData'])->name('input-data');
        Route::post('/input-data', [PosyanduController::class, 'storeData'])->name('input-data.store');
        
        // Data Anak
        Route::get('/data-anak', [PosyanduController::class, 'dataAnak'])->name('data-anak');
        
        // Monitoring
        Route::get('/monitoring', [PosyanduController::class, 'monitoring'])->name('monitoring');
    });
    
    // Petugas Puskesmas Routes
    Route::prefix('puskesmas')->name('puskesmas.')->middleware('role:Petugas Puskesmas')->group(function () {
        // Dashboard
        Route::get('/dashboard', [PuskesmasController::class, 'dashboard'])->name('dashboard');
        
        // Monitoring Data (dengan filter)
        Route::get('/monitoring', [PuskesmasController::class, 'monitoring'])->name('monitoring');
        Route::get('/monitoring/filter', [PuskesmasController::class, 'monitoringFilter'])->name('monitoring.filter');
        
        // Validasi
        Route::get('/validasi', [PuskesmasController::class, 'validasiIndex'])->name('validasi.index');
        Route::get('/validasi/{id}', [PuskesmasController::class, 'validasiDetail'])->name('validasi.detail');
        Route::post('/validasi/{id}', [PuskesmasController::class, 'validasiProses'])->name('validasi.proses');
        Route::post('/validasi/bulk', [PuskesmasController::class, 'validasiBulk'])->name('validasi.bulk');
        
        // Input Data Pengukuran
        Route::get('/input-data', [PuskesmasController::class, 'inputIndex'])->name('input.index');
        Route::post('/input-data', [PuskesmasController::class, 'inputStore'])->name('input.store');
        
        // Data Anak
        Route::get('/data-anak', [PuskesmasController::class, 'anakIndex'])->name('anak.index');
        Route::get('/data-anak/{id}/edit', [PuskesmasController::class, 'anakEdit'])->name('anak.edit');
        Route::put('/data-anak/{id}', [PuskesmasController::class, 'anakUpdate'])->name('anak.update');
        Route::delete('/data-anak/{id}', [PuskesmasController::class, 'anakDestroy'])->name('anak.destroy');
        
        // Intervensi
        Route::get('/intervensi', [PuskesmasController::class, 'intervensiIndex'])->name('intervensi.index');
        Route::get('/intervensi/create/{id_anak}', [PuskesmasController::class, 'intervensiCreate'])->name('intervensi.create');
        Route::post('/intervensi', [PuskesmasController::class, 'intervensiStore'])->name('intervensi.store');
        Route::get('/intervensi/{id}/edit', [PuskesmasController::class, 'intervensiEdit'])->name('intervensi.edit');
        Route::put('/intervensi/{id}', [PuskesmasController::class, 'intervensiUpdate'])->name('intervensi.update');
        
        // Laporan
        Route::get('/laporan', [PuskesmasController::class, 'laporanIndex'])->name('laporan.index');
        Route::get('/create', [PuskesmasController::class, 'laporanCreate'])->name('laporan.create');
        Route::post('/laporan', [PuskesmasController::class, 'laporanStore'])->name('laporan.store');
        Route::get('/{id}/preview', [PuskesmasController::class, 'laporanPreview'])->name('laporan.preview');
        Route::get('/{id}/download', [PuskesmasController::class, 'laporanDownload'])->name('laporan.download');
        Route::get('/preview-data', [PuskesmasController::class, 'laporanPreviewData'])->name('laporan.preview-data');
    });
    
    // Petugas DPPKB Routes
    Route::prefix('dppkb')->name('dppkb.')->middleware('role:Petugas DPPKB')->group(function () {
        Route::get('/dashboard', [DPPKBController::class, 'dashboard'])->name('dashboard');
        
        // Validasi Data
        Route::get('/validasi', [DPPKBController::class, 'validasi'])->name('validasi');
        Route::get('/validasi/{id}', [DPPKBController::class, 'validasiDetail'])->name('validasi.detail');
        Route::post('/validasi/{id}', [DPPKBController::class, 'validasiStore'])->name('validasi.store');
        
        // Monitoring
        Route::get('/monitoring', [DPPKBController::class, 'monitoring'])->name('monitoring');
        
        // Laporan
        Route::get('/laporan', [DPPKBController::class, 'laporan'])->name('laporan');
    });
    
    // Orang Tua Routes
    Route::prefix('orangtua')->name('orangtua.')->middleware('role:Orang Tua')->group(function () {
        // Dashboard
    Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('dashboard');
    
    // Data Anak
    Route::prefix('anak')->name('anak.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'anakIndex'])->name('index');
        Route::get('/{id}/detail', [OrangTuaController::class, 'anakDetail'])->name('detail');
        
        // AJAX Endpoint for dynamic chart updates
        Route::get('/{id}/chart-data', [OrangTuaController::class, 'getChartData'])->name('chart-data');
    });
    
    // Notifikasi (will implement next)
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'notifikasiIndex'])->name('index');
        Route::get('/{id}', [OrangTuaController::class, 'notifikasiShow'])->name('show');
        Route::post('/{id}/mark-read', [OrangTuaController::class, 'notifikasiMarkRead'])->name('mark-read');
        Route::post('/mark-all-read', [OrangTuaController::class, 'notifikasiMarkAllRead'])->name('mark-all-read');
        Route::delete('/{id}', [OrangTuaController::class, 'notifikasiDelete'])->name('delete');
    });
    
    // Edukasi (will implement next)
    Route::prefix('edukasi')->name('edukasi.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'edukasiIndex'])->name('index');
        Route::get('/{slug}', [OrangTuaController::class, 'edukasiShow'])->name('show');
    });
    
    // Profile
    Route::get('/profile', [OrangTuaController::class, 'profile'])->name('profile');
    Route::put('/profile', [OrangTuaController::class, 'profileUpdate'])->name('profile.update');
    });
});