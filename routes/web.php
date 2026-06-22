<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WelcomeController;

// =================== Warga Controllers ===================
use App\Http\Controllers\Warga\WargaController;
use App\Http\Controllers\Warga\Profile\ProfileController;
use App\Http\Controllers\Warga\AduanWarga\AduanWargaController as WargaAduanWargaController;
use App\Http\Controllers\Warga\Berita\BeritaController as WargaBeritaController;
use App\Http\Controllers\Warga\Galeri\GaleriController as WargaGaleriController;
use App\Http\Controllers\Warga\PerangkatDesa\PerangkatDesaController as WargaPerangkatDesaController;
use App\Http\Controllers\Warga\Agenda\AgendaController;
use App\Http\Controllers\Warga\LayananPenduduk\LayananPendudukController as WargaLayananPendudukController;
use App\Http\Controllers\Warga\PendudukRequest\PendudukRequestController as WargaPendudukRequestController;
use App\Http\Controllers\Warga\Notification\NotificationController;
use App\Http\Controllers\Warga\Survey\SurveyController as WargaSurveyController;
use App\Http\Controllers\Warga\Apbdes\ApbdesController as WargaApbdesController;
use App\Http\Controllers\Warga\PenerimaBantuan\PenerimaBantuanController as WargaPenerimaBantuanController; // 

// =================== Admin Controllers ===================
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AduanWarga\AduanWargaController as AdminAduanWargaController;
use App\Http\Controllers\Admin\KelolaAkun\KelolaAkunController;
use App\Http\Controllers\Admin\KelolaWarga\KelolaWargaController;
use App\Http\Controllers\Admin\Berita\BeritaController;
use App\Http\Controllers\Admin\Galeri\GaleriController;
use App\Http\Controllers\Admin\PerangkatDesa\PerangkatDesaController;
use App\Http\Controllers\Admin\DataDesa\DataDesaController;
use App\Http\Controllers\Admin\Survey\SurveyController as AdminSurveyController;
use App\Http\Controllers\Admin\LayananPenduduk\LayananPendudukController;
use App\Http\Controllers\Admin\PendudukRequirement\PendudukRequirementController;
use App\Http\Controllers\Admin\PendudukRequest\PendudukRequestController as AdminPendudukRequestController;
use App\Http\Controllers\Admin\PendudukUpload\PendudukUploadController;
use App\Http\Controllers\Admin\Apbdes\ApbdesController as AdminApbdesController;
use App\Http\Controllers\Admin\PenerimaBantuan\PenerimaBantuanController as AdminPenerimaBantuanController;
use App\Http\Controllers\Admin\JenisBantuan\JenisBantuanController as AdminJenisBantuanController;
use App\Http\Controllers\Admin\Agenda\AgendaController as AdminAgendaController;

// =================== HALAMAN UTAMA ===================
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');


// =================== WARGA (butuh login) ===================
Route::middleware(['auth', 'role:warga'])
    ->prefix('warga')
    ->name('warga.')
    ->group(function () {

        Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('dashboard');

        // PROFILE
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('/', [ProfileController::class, 'update'])->name('update');
        });

        // ADUAN
        Route::prefix('aduan')->name('aduan.')->group(function () {
            Route::get('/', [WargaAduanWargaController::class, 'index'])->name('index');
            Route::get('/buat', [WargaAduanWargaController::class, 'create'])->name('create');
            Route::post('/', [WargaAduanWargaController::class, 'store'])->name('store');
            Route::get('/{id}', [WargaAduanWargaController::class, 'show'])->name('show');
        });

        // LAYANAN PENDUDUK
        Route::prefix('layananpenduduk')->name('layananpenduduk.')->group(function () {
            Route::get('/', [WargaLayananPendudukController::class, 'index'])->name('index');
            Route::get('/ajukan/{id}', [WargaLayananPendudukController::class, 'show'])->name('show');
        });

        // SURVEY
        Route::get('/survey', [WargaSurveyController::class, 'create'])->name('survey.create');
        Route::post('/survey', [WargaSurveyController::class, 'store'])->name('survey.store');
        Route::get('/survey/thanks', [WargaSurveyController::class, 'thanks'])->name('survey.thanks');

        // REQUEST
        Route::prefix('pendudukrequest')->name('pendudukrequest.')->group(function () {
            Route::get('/', [WargaPendudukRequestController::class, 'index'])->name('index');
            Route::get('/create/{layananId}', [WargaPendudukRequestController::class, 'create'])->name('create');
            Route::post('/store', [WargaPendudukRequestController::class, 'store'])->name('store');
            Route::get('/{id}', [WargaPendudukRequestController::class, 'show'])->name('show');
            Route::get('/upload/view/{id}', [WargaPendudukRequestController::class, 'viewFile'])->name('upload.view');
            Route::get('/download/{id}', [WargaPendudukRequestController::class, 'download'])->name('download');
            Route::post('/upload/update/{uploadId}', [WargaPendudukRequestController::class, 'updateUpload'])->name('upload.update');
            Route::delete('/upload/destroy/{uploadId}', [WargaPendudukRequestController::class, 'destroyUpload'])->name('upload.destroy');
            Route::post('/upload/add/{requestId}', [WargaPendudukRequestController::class, 'addUpload'])->name('upload.add');
        });

        // ========== APBDes WARGA ==========
        Route::prefix('apbdes')->name('apbdes.')->group(function () {
            Route::get('/', [WargaApbdesController::class, 'index'])->name('index');
            Route::get('/sumber-dana', [WargaApbdesController::class, 'sumberDana'])->name('sumber-dana');
            Route::get('/pengalokasian', [WargaApbdesController::class, 'pengalokasian'])->name('pengalokasian');
            Route::get('/realisasi', [WargaApbdesController::class, 'realisasi'])->name('realisasi');
            Route::get('/detail/{id}', [WargaApbdesController::class, 'detail'])->name('detail');
        });

        // ========== PENERIMA BANTUAN WARGA (BARU) ==========
        Route::prefix('penerima-bantuan')->name('penerimabantuan.')->group(function () {
            Route::get('/', [WargaPenerimaBantuanController::class, 'index'])->name('index');
            Route::get('/{id}', [WargaPenerimaBantuanController::class, 'show'])->name('show');
        });

    });


// =================== ADMIN ===================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // ADUAN
        Route::prefix('aduan')->name('aduan.')->group(function () {
            Route::get('/', [AdminAduanWargaController::class, 'index'])->name('index');
            Route::get('/edit/{id}', [AdminAduanWargaController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [AdminAduanWargaController::class, 'update'])->name('update');
            Route::get('/show/{id}', [AdminAduanWargaController::class, 'show'])->name('show');
            Route::delete('/hapus/{id}', [AdminAduanWargaController::class, 'destroy'])->name('destroy');
        });

        // BERITA
        Route::prefix('berita')->name('berita.')->group(function () {
            Route::get('/', [BeritaController::class, 'index'])->name('index');
            Route::get('/create', [BeritaController::class, 'create'])->name('create');
            Route::post('/store', [BeritaController::class, 'store'])->name('store');
            Route::get('/show/{slug}', [BeritaController::class, 'show'])->name('show');
            Route::get('/edit/{berita}', [BeritaController::class, 'edit'])->name('edit');
            Route::put('/update/{berita}', [BeritaController::class, 'update'])->name('update');
            Route::delete('/hapus/{berita}', [BeritaController::class, 'destroy'])->name('destroy');
        });

        // GALERI
        Route::prefix('galeri')->name('galeri.')->group(function () {
            Route::get('/', [GaleriController::class, 'index'])->name('index');
            Route::get('/create', [GaleriController::class, 'create'])->name('create');
            Route::post('/', [GaleriController::class, 'store'])->name('store');
            Route::get('/edit/{galeri}', [GaleriController::class, 'edit'])->name('edit');
            Route::put('/update/{galeri}', [GaleriController::class, 'update'])->name('update');
            Route::get('/show/{galeri}', [GaleriController::class, 'show'])->name('show');
            Route::delete('/destroy/{galeri}', [GaleriController::class, 'destroy'])->name('destroy');
        });

        // === JENIS BANTUAN ===
        Route::prefix('jenis-bantuan')->name('jenisbantuan.')->group(function () {
            Route::get('/', [AdminJenisBantuanController::class, 'index'])->name('index');
            Route::get('/create', [AdminJenisBantuanController::class, 'create'])->name('create');
            Route::post('/', [AdminJenisBantuanController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminJenisBantuanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminJenisBantuanController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminJenisBantuanController::class, 'destroy'])->name('destroy');
        });

        // === PENERIMA BANTUAN ===
        Route::prefix('penerima-bantuan')->name('penerimabantuan.')->group(function () {
            Route::get('/', [AdminPenerimaBantuanController::class, 'index'])->name('index');
            Route::get('/create', [AdminPenerimaBantuanController::class, 'create'])->name('create');
            Route::post('/', [AdminPenerimaBantuanController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminPenerimaBantuanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminPenerimaBantuanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminPenerimaBantuanController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminPenerimaBantuanController::class, 'destroy'])->name('destroy');
        });

        // PERANGKAT DESA
        Route::prefix('perangkatdesa')->name('perangkatdesa.')->group(function () {
            Route::get('/', [PerangkatDesaController::class, 'index'])->name('index');
            Route::get('/create', [PerangkatDesaController::class, 'create'])->name('create');
            Route::post('/', [PerangkatDesaController::class, 'store'])->name('store');
            Route::get('/{perangkatdesa}/edit', [PerangkatDesaController::class, 'edit'])->name('edit');
            Route::put('/{perangkatdesa}', [PerangkatDesaController::class, 'update'])->name('update');
            Route::delete('/{perangkatdesa}', [PerangkatDesaController::class, 'destroy'])->name('destroy');
        });

        // KELOLA AKUN
        Route::prefix('kelolaakun')->name('kelolaakun.')->group(function () {
            Route::get('/', [KelolaAkunController::class, 'index'])->name('index');
            Route::post('/{id}/status', [KelolaAkunController::class, 'updateStatus'])->name('updateStatus');
            Route::get('/{id}/edit', [KelolaAkunController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KelolaAkunController::class, 'update'])->name('update');
            Route::delete('/{id}', [KelolaAkunController::class, 'destroy'])->name('destroy');
        });

        // ========== APBDes ADMIN ==========
        Route::prefix('apbdes')->name('apbdes.')->group(function () {

            // === DASHBOARD ===
            Route::get('/', [AdminApbdesController::class, 'adminIndex'])->name('index');

            // === TAHUN ANGGARAN ===
            Route::prefix('tahun')->name('tahun.')->group(function () {
                Route::get('/', [AdminApbdesController::class, 'indexTahun'])->name('index');
                Route::get('/create', [AdminApbdesController::class, 'createTahun'])->name('create');
                Route::post('/', [AdminApbdesController::class, 'storeTahun'])->name('store');
                Route::get('/{id}', [AdminApbdesController::class, 'showTahun'])->name('show');
                Route::get('/{id}/edit', [AdminApbdesController::class, 'editTahun'])->name('edit');
                Route::put('/{id}', [AdminApbdesController::class, 'updateTahun'])->name('update');
                Route::delete('/{id}', [AdminApbdesController::class, 'destroyTahun'])->name('destroy');
            });

            // === SUMBER DANA ===
            Route::prefix('sumber-dana')->name('sumberdana.')->group(function () {
                Route::get('/', [AdminApbdesController::class, 'indexSumberDana'])->name('index');
                Route::get('/create', [AdminApbdesController::class, 'createSumberDana'])->name('create');
                Route::post('/', [AdminApbdesController::class, 'storeSumberDana'])->name('store');
                Route::get('/{id}', [AdminApbdesController::class, 'showSumberDana'])->name('show');
                Route::get('/{id}/edit', [AdminApbdesController::class, 'editSumberDana'])->name('edit');
                Route::put('/{id}', [AdminApbdesController::class, 'updateSumberDana'])->name('update');
                Route::delete('/{id}', [AdminApbdesController::class, 'destroySumberDana'])->name('destroy');
            });

            // === PENGALOKASIAN ===
            Route::prefix('pengalokasian')->name('pengalokasian.')->group(function () {
                Route::get('/', [AdminApbdesController::class, 'indexPengalokasian'])->name('index');
                Route::get('/create', [AdminApbdesController::class, 'createPengalokasian'])->name('create');
                Route::post('/', [AdminApbdesController::class, 'storePengalokasian'])->name('store');
                Route::get('/{id}', [AdminApbdesController::class, 'showPengalokasian'])->name('show');
                Route::get('/{id}/edit', [AdminApbdesController::class, 'editPengalokasian'])->name('edit');
                Route::put('/{id}', [AdminApbdesController::class, 'updatePengalokasian'])->name('update');
                Route::delete('/{id}', [AdminApbdesController::class, 'destroyPengalokasian'])->name('destroy');
                
                // APPROVAL
                Route::post('/{id}/approve', [AdminApbdesController::class, 'approvePengalokasian'])->name('approve');
                Route::post('/{id}/reject', [AdminApbdesController::class, 'rejectPengalokasian'])->name('reject');
                Route::post('/{id}/revisi', [AdminApbdesController::class, 'requestRevisionPengalokasian'])->name('revisi');
            });

            // === REALISASI ===
            Route::prefix('realisasi')->name('realisasi.')->group(function () {
                Route::get('/', [AdminApbdesController::class, 'indexRealisasi'])->name('index');
                Route::get('/create', [AdminApbdesController::class, 'createRealisasi'])->name('create');
                Route::post('/', [AdminApbdesController::class, 'storeRealisasi'])->name('store');
                Route::get('/{id}', [AdminApbdesController::class, 'showRealisasi'])->name('show');
                Route::get('/{id}/edit', [AdminApbdesController::class, 'editRealisasi'])->name('edit');
                Route::put('/{id}', [AdminApbdesController::class, 'updateRealisasi'])->name('update');
                Route::delete('/{id}', [AdminApbdesController::class, 'destroyRealisasi'])->name('destroy');
                
                // VERIFICATION
                Route::get('/{id}/verify', [AdminApbdesController::class, 'showVerifyRealisasi'])->name('show-verify');
                Route::post('/{id}/verify', [AdminApbdesController::class, 'verifyRealisasi'])->name('verify');
                Route::post('/{id}/reject', [AdminApbdesController::class, 'rejectRealisasi'])->name('reject');
            });

            // === RECALCULATE (emergency) ===
            Route::post('/recalculate/{type}/{id}', [AdminApbdesController::class, 'recalculate'])->name('recalculate');

        });

        // KELOLA WARGA
        Route::prefix('kelolawarga')->name('kelolawarga.')->group(function () {
            Route::get('/', [KelolaWargaController::class, 'index'])->name('index');
            Route::get('/create', [KelolaWargaController::class, 'create'])->name('create');
            Route::post('/store', [KelolaWargaController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [KelolaWargaController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [KelolaWargaController::class, 'update'])->name('update');
            Route::get('/show/{id}', [KelolaWargaController::class, 'show'])->name('show');
            Route::delete('/hapus/{id}', [KelolaWargaController::class, 'destroy'])->name('destroy');
        });

        // ========== AGENDA ==========
        Route::prefix('agenda')->name('agenda.')->group(function () {
            Route::get('/', [AdminAgendaController::class, 'index'])->name('index');
            Route::get('/create', [AdminAgendaController::class, 'create'])->name('create');
            Route::post('/', [AdminAgendaController::class, 'store'])->name('store');
            Route::get('/{agenda}/edit', [AdminAgendaController::class, 'edit'])->name('edit');
            Route::put('/{agenda}', [AdminAgendaController::class, 'update'])->name('update');
            Route::delete('/{agenda}', [AdminAgendaController::class, 'destroy'])->name('destroy');
        });

        // LAYANAN
        Route::prefix('layananpenduduk')->name('layananpenduduk.')->group(function () {
            Route::get('/', [LayananPendudukController::class, 'index'])->name('index');
            Route::get('/create', [LayananPendudukController::class, 'create'])->name('create');
            Route::post('/store', [LayananPendudukController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [LayananPendudukController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [LayananPendudukController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [LayananPendudukController::class, 'destroy'])->name('destroy');
        });

        // PENDUDUK REQUIREMENT
        Route::prefix('pendudukrequirement')->name('pendudukrequirement.')->group(function () {
            Route::get('/{layananId}', [PendudukRequirementController::class, 'index'])->name('index');
            Route::get('/{layananId}/create', [PendudukRequirementController::class, 'create'])->name('create');
            Route::post('/', [PendudukRequirementController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PendudukRequirementController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PendudukRequirementController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [PendudukRequirementController::class, 'destroy'])->name('destroy');
        });

        // SURVEY
        Route::get('/surveys', [AdminSurveyController::class, 'index'])->name('surveys.index');
        Route::get('/surveys/{survey}', [AdminSurveyController::class, 'show'])->name('surveys.show');

        // REQUEST
        Route::prefix('pendudukrequest')->name('pendudukrequest.')->group(function () {
            Route::get('/', [AdminPendudukRequestController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminPendudukRequestController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminPendudukRequestController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminPendudukRequestController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminPendudukRequestController::class, 'destroy'])->name('destroy');
        });

        // FILE
        Route::get('/uploads/view/{id}', [PendudukUploadController::class, 'view'])->name('upload.view');
        Route::get('/uploads/download/{id}', [PendudukUploadController::class, 'download'])->name('upload.download');

    });


// =================== PUBLIK (gak perlu login) ===================
Route::get('visimisi', [AdminController::class, 'visimisi'])->name('visimisi.index');
Route::get('sejarahdesa', [AdminController::class, 'sejarahdesa'])->name('sejarahdesa.index');
Route::get('datadesa', [DataDesaController::class, 'index'])->name('datadesa.index');
Route::get('perangkatdesa', [WargaPerangkatDesaController::class, 'index'])->name('perangkatdesa.index');
Route::get('agenda', [AgendaController::class, 'index'])->name('agenda.index');

// Aduan Publik
Route::get('aduan', [WargaAduanWargaController::class, 'index'])->name('aduan.public.index');
Route::get('aduan/{id}', [WargaAduanWargaController::class, 'show'])->name('aduan.show');

Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [WargaBeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [WargaBeritaController::class, 'show'])->name('show');
});

Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [WargaGaleriController::class, 'index'])->name('index');
});

// ========== TRANSPARASI (APBDes + Penerima Bantuan) ==========
Route::prefix('transparasi')->name('public.')->group(function () {
    
    // APBDes
    Route::prefix('apbdes')->name('apbdes.')->group(function () {
        Route::get('/', [WargaApbdesController::class, 'index'])->name('index');
        Route::get('/sumber-dana', [WargaApbdesController::class, 'sumberDana'])->name('sumberdana');
        Route::get('/pengalokasian', [WargaApbdesController::class, 'pengalokasian'])->name('pengalokasian');
        Route::get('/realisasi', [WargaApbdesController::class, 'realisasi'])->name('realisasi');
        Route::get('/detail/{id}', [WargaApbdesController::class, 'detail'])->name('detail');
    });

    // PENERIMA BANTUAN (publik - transparansi)
    Route::prefix('penerima-bantuan')->name('penerimabantuan.')->group(function () {
        Route::get('/', [WargaPenerimaBantuanController::class, 'publicIndex'])->name('index');
        Route::get('/{jenisBantuanId}', [WargaPenerimaBantuanController::class, 'publicShow'])->name('show');
    });
});

// =================== NOTIFIKASI ===================
Route::middleware(['auth'])
    ->prefix('notifikasi')
    ->name('notifikasi.')
    ->group(function () {
        Route::post('/read/{id}', [NotificationController::class, 'markAsRead'])->name('read');
    });

require __DIR__ . '/auth.php';