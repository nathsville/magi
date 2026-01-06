<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OtpController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\DPPKBController;
use App\Http\Controllers\OrangTuaController;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. ROUTE UTAMA (TRAFFIC CONTROLLER)
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Menggunakan helper redirect yang sudah kita buat di AuthController (Opsional, atau pakai logika manual di bawah)
        return AuthController::redirectBasedOnRole($user->role);
    }
    return redirect()->route('login');
});

// 2. GUEST & AUTHENTICATION ROUTES (Login & OTP)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // === FITUR 2FA / OTP ===
    // PERBAIKAN DI SINI: Ganti 'otp.view' menjadi 'otp.show'
    Route::get('/verify-otp', [OtpController::class, 'show'])->name('otp.show'); 
    
    Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
    Route::get('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');
});

// 3. AUTHENTICATED ROUTES (Dashboard & Fitur Utama)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // --- ADMIN ROUTES ---
    Route::prefix('admin')->name('admin.')->middleware('role:Admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Data Master
        Route::prefix('datamaster')->name('datamaster')->group(function() {
            Route::get('/', [AdminController::class, 'datamasterIndex']); 
            Route::get('/search', [AdminController::class, 'datamasterSearch'])->name('.search');
            Route::get('/create', [AdminController::class, 'datamasterCreate'])->name('.create');
            Route::post('/', [AdminController::class, 'datamasterStore'])->name('.store');
            Route::get('/{id}/edit', [AdminController::class, 'datamasterEdit'])->name('.edit');
            Route::put('/{id}', [AdminController::class, 'datamasterUpdate'])->name('.update');
            Route::delete('/{id}', [AdminController::class, 'datamasterDestroy'])->name('.destroy');
        });

        // Users Management
        Route::prefix('users')->name('users')->group(function() {
            Route::get('/', [AdminController::class, 'users']);
            Route::get('/search', [AdminController::class, 'usersSearch'])->name('.search');
            Route::get('/create', [AdminController::class, 'usersCreate'])->name('.create');
            Route::post('/', [AdminController::class, 'usersStore'])->name('.store');
            Route::get('/{id}/edit', [AdminController::class, 'usersEdit'])->name('.edit');
            Route::put('/{id}', [AdminController::class, 'usersUpdate'])->name('.update');
            Route::delete('/{id}', [AdminController::class, 'usersDestroy'])->name('.destroy');
            Route::post('/{id}/reset-password', [AdminController::class, 'usersResetPassword'])->name('.reset-password');
            Route::post('/{id}/toggle-status', [AdminController::class, 'usersToggleStatus'])->name('.toggle-status');
        });

        // Puskesmas Management
        Route::prefix('puskesmas')->name('puskesmas')->group(function() {
            Route::get('/', [AdminController::class, 'puskesmas']);
            Route::get('/search', [AdminController::class, 'puskesmasSearch'])->name('.search');
            Route::get('/create', [AdminController::class, 'puskesmasCreate'])->name('.create');
            Route::post('/', [AdminController::class, 'puskesmasStore'])->name('.store');
            Route::get('/{id}/edit', [AdminController::class, 'puskesmasEdit'])->name('.edit');
            Route::put('/{id}', [AdminController::class, 'puskesmasUpdate'])->name('.update');
            Route::delete('/{id}', [AdminController::class, 'puskesmasDestroy'])->name('.destroy');
        });
        
        // Posyandu Management
        Route::prefix('posyandu')->name('posyandu')->group(function() {
            Route::get('/', [AdminController::class, 'posyandu']);
            Route::get('/search', [AdminController::class, 'posyanduSearch'])->name('.search');
            Route::get('/create', [AdminController::class, 'posyanduCreate'])->name('.create');
            Route::post('/', [AdminController::class, 'posyanduStore'])->name('.store');
            Route::get('/{id}/edit', [AdminController::class, 'posyanduEdit'])->name('.edit');
            Route::put('/{id}', [AdminController::class, 'posyanduUpdate'])->name('.update');
            Route::delete('/{id}', [AdminController::class, 'posyanduDestroy'])->name('.destroy');
        });

        // Broadcast & Audit
        Route::get('/broadcast', [AdminController::class, 'broadcast'])->name('broadcast');
        Route::post('/broadcast/send', [AdminController::class, 'broadcastSend'])->name('broadcast.send');
        Route::get('/broadcast/history', [AdminController::class, 'broadcastHistory'])->name('broadcast.history');
        
        Route::get('/audit-log', [AdminController::class, 'auditLog'])->name('audit-log');
        Route::get('/audit-log/filter', [AdminController::class, 'auditLogFilter'])->name('audit-log.filter');
        Route::get('/audit-log/{id}/detail', [AdminController::class, 'auditLogDetail'])->name('audit-log.detail');
        Route::get('/audit-log/export', [AdminController::class, 'auditLogExport'])->name('audit-log.export');
    });
    
    // --- PETUGAS POSYANDU ROUTES ---
    Route::prefix('posyandu')->name('posyandu.')->middleware('role:Petugas Posyandu')->group(function () {
        // ... (Kode Posyandu tetap sama) ...
        Route::get('/dashboard', [PosyanduController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/stats', [PosyanduController::class, 'getRiwayatStats'])->name('dashboard.stats');

        Route::prefix('pengukuran')->name('pengukuran.')->group(function () {
            Route::get('/form', [PosyanduController::class, 'inputPengukuranForm'])->name('form');
            Route::post('/store', [PosyanduController::class, 'inputPengukuranStore'])->name('store');
            Route::get('/riwayat/stats', [PosyanduController::class, 'getRiwayatStats'])->name('stats-cards-riwayat');
            Route::get('/riwayat', [PosyanduController::class, 'riwayatPengukuran'])->name('riwayat');
            Route::get('/riwayat/export', [PosyanduController::class, 'riwayatExport'])->name('riwayat.export');
            Route::get('/riwayat/{id}', [PosyanduController::class, 'riwayatPengukuranDetail'])->name('detail');
        });

        Route::prefix('anak')->name('anak.')->group(function () {
            Route::get('/', [PosyanduController::class, 'dataAnakIndex'])->name('index');
            Route::get('/create', [PosyanduController::class, 'dataAnakCreate'])->name('create');
            Route::post('/store', [PosyanduController::class, 'dataAnakStore'])->name('store');
            Route::get('/{id}', [PosyanduController::class, 'dataAnakShow'])->name('show');
            Route::get('/{id}/edit', [PosyanduController::class, 'dataAnakEdit'])->name('edit');
            Route::put('/{id}', [PosyanduController::class, 'dataAnakUpdate'])->name('update');
        });

        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/', [PosyanduController::class, 'notifikasiIndex'])->name('index');
            Route::post('/mark-all-as-read', [PosyanduController::class, 'notifikasiMarkAllAsRead'])->name('mark-all-as-read');
            Route::delete('/delete-all-read', [PosyanduController::class, 'notifikasiDeleteAllRead'])->name('delete-all-read');
            Route::post('/{id}/mark-as-read', [PosyanduController::class, 'notifikasiMarkAsRead'])->name('mark-as-read');
            Route::delete('/{id}', [PosyanduController::class, 'notifikasiDelete'])->name('delete');
        });

        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [PosyanduController::class, 'laporanIndex'])->name('index');
            Route::post('/generate', [PosyanduController::class, 'laporanGenerate'])->name('generate');
        });

        Route::get('/profile', [PosyanduController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [PosyanduController::class, 'profileUpdate'])->name('profile.update');
    });
    
    // --- PETUGAS PUSKESMAS ROUTES ---
    Route::prefix('puskesmas')->name('puskesmas.')->middleware('role:Petugas Puskesmas')->group(function () {
        // ... (Kode Puskesmas tetap sama) ...
        Route::get('/dashboard', [PuskesmasController::class, 'dashboard'])->name('dashboard');
        Route::get('/monitoring', [PuskesmasController::class, 'monitoring'])->name('monitoring');
        Route::get('/monitoring/filter', [PuskesmasController::class, 'monitoringFilter'])->name('monitoring.filter');
        
        Route::prefix('validasi')->name('validasi.')->group(function() {
            Route::get('/', [PuskesmasController::class, 'validasiIndex'])->name('index');
            Route::post('/bulk', [PuskesmasController::class, 'validasiBulk'])->name('bulk');
            Route::get('/{id}', [PuskesmasController::class, 'validasiDetail'])->name('detail');
            Route::post('/{id}', [PuskesmasController::class, 'validasiProses'])->name('proses');
        });
        
        Route::prefix('input-data')->name('input.')->group(function() {
            Route::get('/', [PuskesmasController::class, 'inputIndex'])->name('index');
            Route::post('/', [PuskesmasController::class, 'inputStore'])->name('store');
        });
        
        Route::prefix('data-anak')->name('anak.')->group(function() {
            Route::get('/', [PuskesmasController::class, 'anakIndex'])->name('index');
            Route::get('/{id}/edit', [PuskesmasController::class, 'anakEdit'])->name('edit');
            Route::put('/{id}', [PuskesmasController::class, 'anakUpdate'])->name('update');
            Route::delete('/{id}', [PuskesmasController::class, 'anakDestroy'])->name('destroy');
        });
        
        Route::prefix('intervensi')->name('intervensi.')->group(function() {
            Route::get('/', [PuskesmasController::class, 'intervensiIndex'])->name('index');
            Route::get('/create/{id_anak}', [PuskesmasController::class, 'intervensiCreate'])->name('create');
            Route::post('/', [PuskesmasController::class, 'intervensiStore'])->name('store');
            Route::get('/{id}/edit', [PuskesmasController::class, 'intervensiEdit'])->name('edit');
            Route::put('/{id}', [PuskesmasController::class, 'intervensiUpdate'])->name('update');
        });
        
        Route::prefix('laporan')->name('laporan.')->group(function() {
            Route::get('/', [PuskesmasController::class, 'laporanIndex'])->name('index');
            Route::get('/create', [PuskesmasController::class, 'laporanCreate'])->name('create');
            Route::post('/', [PuskesmasController::class, 'laporanStore'])->name('store');
            Route::get('/preview-data', [PuskesmasController::class, 'laporanPreviewData'])->name('preview-data');
            Route::get('/{id}/preview', [PuskesmasController::class, 'laporanPreview'])->name('preview');
            Route::get('/{id}/download', [PuskesmasController::class, 'laporanDownload'])->name('download');
        });
    });
    
    // --- PETUGAS DPPKB ROUTES ---
    Route::prefix('dppkb')->name('dppkb.')->middleware('role:Petugas DPPKB')->group(function () {
        Route::get('/dashboard', [DPPKBController::class, 'dashboard'])->name('dashboard');
        
        Route::prefix('monitoring')->name('monitoring')->group(function() {
            Route::get('/', [DPPKBController::class, 'monitoring']);
            Route::get('/data', [DPPKBController::class, 'monitoringData'])->name('.data');
            Route::get('/wilayah/{kecamatan}', [DPPKBController::class, 'monitoringWilayah'])->name('.wilayah');
        });
        
        Route::prefix('validasi')->name('validasi')->group(function() {
            Route::get('/', [DPPKBController::class, 'validasi']);
            Route::get('/data', [DPPKBController::class, 'validasiData'])->name('.data');
            Route::get('/{id}/detail', [DPPKBController::class, 'validasiDetail'])->name('.detail');
            Route::post('/{id}/approve', [DPPKBController::class, 'approveValidasi'])->name('.approve');
            Route::post('/{id}/klarifikasi', [DPPKBController::class, 'mintaKlarifikasi'])->name('.klarifikasi');
        });
        
        Route::prefix('notifikasi')->name('notifikasi')->group(function() {
            Route::get('/', [DPPKBController::class, 'notifikasi']); 
            Route::get('/stats', [DPPKBController::class, 'notifikasiStats'])->name('.stats');
            Route::post('/send', [DPPKBController::class, 'sendNotifikasi'])->name('.send'); 
            Route::get('/users', [DPPKBController::class, 'getUsersList'])->name('.users');
            Route::get('/stunting-data', [DPPKBController::class, 'getStuntingDataList'])->name('.stunting-data');
            Route::post('/mark-all-read', [DPPKBController::class, 'notifikasiMarkAllRead'])->name('.read-all');
            Route::get('/{id}', [DPPKBController::class, 'notifikasiDetail'])->name('.detail');
            Route::post('/{id}/read', [DPPKBController::class, 'notifikasiMarkAsRead'])->name('.read');
            Route::delete('/{id}', [DPPKBController::class, 'notifikasiDelete'])->name('.delete');
        });
        
        Route::prefix('statistik')->name('statistik')->group(function() {
            Route::get('/', [DPPKBController::class, 'statistik']);
            Route::post('/export', [DPPKBController::class, 'statistikExport'])->name('.export');
            Route::get('/detail/{wilayah}', [DPPKBController::class, 'statistikDetailWilayah'])->name('.detail');
            Route::get('/export-detail/{kode}', [DPPKBController::class, 'statistikExportDetail'])->name('.export-detail');
        });
        
        Route::prefix('laporan')->name('laporan')->group(function() {
            Route::get('/', [DPPKBController::class, 'laporan']);
            Route::get('/count', [DPPKBController::class, 'laporanCount'])->name('.count');
            Route::post('/generate', [DPPKBController::class, 'generateLaporan'])->name('.generate');
            Route::post('/preview', [DPPKBController::class, 'laporanPreview'])->name('.preview');
            Route::post('/share', [DPPKBController::class, 'laporanShare'])->name('.share');
            Route::get('/{id}/download', [DPPKBController::class, 'laporanDownload'])->name('.download');
            Route::delete('/{id}', [DPPKBController::class, 'laporanDelete'])->name('.delete');
        });

        Route::get('/profile', [DPPKBController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [DPPKBController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [DPPKBController::class, 'updatePassword'])->name('profile.password');
    });
    
    // --- ORANG TUA ROUTES ---
    Route::prefix('orangtua')->name('orangtua.')->middleware('role:Orang Tua')->group(function () {
        Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('dashboard');
        
        Route::prefix('anak')->name('anak.')->group(function () {
            Route::get('/', [OrangTuaController::class, 'anakIndex'])->name('index');
            Route::get('/{id}/detail', [OrangTuaController::class, 'anakDetail'])->name('detail');
            Route::get('/{id}/chart-data', [OrangTuaController::class, 'getChartData'])->name('chart-data');
        });
        
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/', [OrangTuaController::class, 'notifikasiIndex'])->name('index');
            Route::post('/mark-all-read', [OrangTuaController::class, 'notifikasiMarkAllRead'])->name('mark-all-read');
            Route::get('/{id}', [OrangTuaController::class, 'notifikasiShow'])->name('show');
            Route::post('/{id}/mark-read', [OrangTuaController::class, 'notifikasiMarkRead'])->name('mark-read');
            Route::delete('/{id}', [OrangTuaController::class, 'notifikasiDelete'])->name('delete');
        });
        
        Route::prefix('edukasi')->name('edukasi.')->group(function () {
            Route::get('/', [OrangTuaController::class, 'edukasiIndex'])->name('index');
            Route::get('/{slug}', [OrangTuaController::class, 'edukasiShow'])->name('show');
        });
        
        Route::get('/profile', [OrangTuaController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [OrangTuaController::class, 'profileUpdate'])->name('profile.update');
        Route::post('/profile/change-password', [OrangTuaController::class, 'changePassword'])->name('profile.change-password');
        
        Route::get('/settings', [OrangTuaController::class, 'settings'])->name('settings');
        Route::put('/settings/update', [OrangTuaController::class, 'settingsUpdate'])->name('settings.update');
        
        Route::post('/account/delete-request', [OrangTuaController::class, 'deleteAccountRequest'])->name('account.delete-request');
        Route::get('/data/export', [OrangTuaController::class, 'exportData'])->name('data.export');
    });
});