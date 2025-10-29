<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController; // Import AdminController
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // JADWAL ROUTES - Grouped and ordered to prevent route shadowing
    Route::middleware('role:admin')->group(function() {
        Route::get('/jadwal/manage', [JadwalController::class, 'manage'])->name('jadwal.manage');
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::match(['put', 'patch'], '/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    });

    // Routes for all authenticated users (must be after specific admin routes)
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{jadwal}', [JadwalController::class, 'show'])->name('jadwal.show');

    // Route for KRS
    Route::get('/krs', [App\Http\Controllers\KrsController::class, 'index'])->name('krs.index');
    Route::post('/krs', [App\Http\Controllers\KrsController::class, 'store'])->name('krs.store');

    // Route for KRS review show, accessible for URL generation
    Route::get('/krs/review/{krs}', [App\Http\Controllers\KrsReviewController::class, 'show'])->name('krs.review.show');

    // Grup Rute Khusus Dosen
    Route::middleware(['auth', 'role:dosen'])->group(function () {
        Route::get('/dosen/dashboard', [App\Http\Controllers\DosenController::class, 'dashboard'])->name('dosen.dashboard');
        Route::get('/krs/review', [App\Http\Controllers\KrsReviewController::class, 'index'])->name('krs.review.index');
        Route::post('/krs/review/{krs}/approve', [App\Http\Controllers\KrsReviewController::class, 'approve'])->name('krs.review.approve');
        Route::post('/krs/review/{krs}/reject', [App\Http\Controllers\KrsReviewController::class, 'reject'])->name('krs.review.reject');
    });

    // Grup Rute Khusus Dosen & Admin
    Route::middleware(['auth', 'role:dosen,admin'])->group(function () {
        // Rute untuk Input Nilai
        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');

        // Rute untuk melihat mata kuliah yang diampu
        Route::get('/dosen/mata-kuliah', [MataKuliahController::class, 'showMyCourses'])->name('matakuliah.my_courses');
    });

    // Route for KHS (Mahasiswa)
    Route::middleware('role:mahasiswa')->group(function () {
        Route::get('/khs', [App\Http\Controllers\KhsController::class, 'index'])->name('khs.index');
    });

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{pengumuman}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // Report Routes for Mahasiswa
    Route::middleware('role:mahasiswa')->group(function () {
        Route::get('/reports/selection', [ReportController::class, 'showStudentSelectionForm'])->name('reports.selection');
        Route::get('/reports/krs', [ReportController::class, 'generateKrs'])->name('reports.krs');
        Route::get('/reports/khs', [ReportController::class, 'generateKhs'])->name('reports.khs');
        Route::get('/reports/transkrip', [ReportController::class, 'generateTranskrip'])->name('reports.transkrip');
    });

    // Report Routes for Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); // Admin Dashboard
        Route::get('/reports/krs/{mahasiswaId}', [ReportController::class, 'generateKrs'])->name('admin.reports.krs');
        Route::get('/reports/khs/{mahasiswaId}', [ReportController::class, 'generateKhs'])->name('admin.reports.khs');
        Route::get('/reports/transkrip/{mahasiswaId}', [ReportController::class, 'generateTranskrip'])->name('admin.reports.transkrip');
    });
});

// Grup Rute Khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Rute untuk fitur Mata Kuliah
    Route::resource('matakuliah', MataKuliahController::class);

    // Rute untuk fitur Manajemen Mahasiswa
    Route::resource('mahasiswa', App\Http\Controllers\MahasiswaController::class)->except(['show']);

    // Rute untuk fitur Manajemen Dosen
    Route::resource('dosen', App\Http\Controllers\DosenController::class)->except(['show']);

    // Rute untuk fitur Pengumuman
    Route::resource('pengumuman', PengumumanController::class);

    // Rute untuk pemilihan laporan admin
    Route::get('/admin/reports/selection', [ReportController::class, 'showAdminSelectionForm'])->name('admin.reports.selection');

});

    require __DIR__.'/auth.php';