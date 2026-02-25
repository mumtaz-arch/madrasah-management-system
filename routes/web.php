<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PONSPES System
|--------------------------------------------------------------------------
*/

// Landing Page (Public)
Route::get('/', function () {
    return view('landing.index');
})->name('home');

// PPDB Public Routes
Route::get('/ppdb', function () {
    return view('ppdb.index');
})->name('ppdb');

Route::get('/ppdb/daftar', function () {
    return view('ppdb.form');
})->name('ppdb.form');

// Dynamic Pages
Route::get('/page/{slug}', function ($slug) {
    $page = \App\Models\Page::where('slug', $slug)->where('is_published', true)->firstOrFail();
    return view('page.show', compact('page'));
})->name('page.show');

// Generic dashboard redirect (fallback)
Route::get('/dashboard', function () {
    $user = auth()->user();
    return match($user->role) {
        'admin', 'operator' => redirect()->route('admin.dashboard'),
        'guru' => redirect()->route('guru.dashboard'),
        'santri' => redirect()->route('santri.dashboard'),
        'wali' => redirect()->route('wali.dashboard'),
        default => redirect('/'),
    };
})->middleware(['auth'])->name('dashboard');

// Profile routes (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,operator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Analytics
    Route::get('/analytics', function () {
        return view('admin.analytics.index');
    })->name('analytics.index');
    Route::get('/analytics/export', [\App\Http\Controllers\AnalyticsExportController::class, 'export'])->name('analytics.export');
    
    // Users management - placeholder routes
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
    
    // Santri management
    Route::get('/santri', function () {
        return view('admin.santri.index');
    })->name('santri.index');
    
    Route::get('/santri/create', function () {
        return view('admin.santri.create');
    })->name('santri.create');
    
    Route::get('/santri/{santri}/edit', function (App\Models\Santri $santri) {
        return view('admin.santri.edit', ['santri' => $santri]);
    })->name('santri.edit');
    
    // Santri Export/Import
    Route::get('/santri/export', [\App\Http\Controllers\SantriController::class, 'export'])->name('santri.export');
    Route::get('/santri/template', [\App\Http\Controllers\SantriController::class, 'downloadTemplate'])->name('santri.template');
    Route::post('/santri/import', [\App\Http\Controllers\SantriController::class, 'import'])->name('santri.import');
    
    // Guru management
    Route::get('/guru', function () {
        return view('admin.guru.index');
    })->name('guru.index');
    
    Route::get('/guru/create', function () {
        return view('admin.guru.create');
    })->name('guru.create');
    
    Route::get('/guru/{guru}/edit', function (App\Models\Guru $guru) {
        return view('admin.guru.edit', ['guru' => $guru]);
    })->name('guru.edit');
    
    // Guru Export/Import
    Route::get('/guru/export', [\App\Http\Controllers\GuruController::class, 'export'])->name('guru.export');
    Route::get('/guru/template', [\App\Http\Controllers\GuruController::class, 'downloadTemplate'])->name('guru.template');
    Route::post('/guru/import', [\App\Http\Controllers\GuruController::class, 'import'])->name('guru.import');
    
    // Kelas management
    Route::get('/kelas', function () {
        return view('admin.kelas.index');
    })->name('kelas.index');
    
    Route::get('/kelas/create', function () {
        return view('admin.kelas.create');
    })->name('kelas.create');
    
    Route::get('/kelas/{kelas}/edit', function (App\Models\Kelas $kelas) {
        return view('admin.kelas.edit', ['kelas' => $kelas]);
    })->name('kelas.edit');
    
    // Mapel management
    Route::get('/mapel', function () {
        return view('admin.mapel.index');
    })->name('mapel.index');
    
    Route::get('/mapel/create', function () {
        return view('admin.mapel.create');
    })->name('mapel.create');
    
    Route::get('/mapel/{mapel}/edit', function (App\Models\Mapel $mapel) {
        return view('admin.mapel.edit', ['mapel' => $mapel]);
    })->name('mapel.edit');

    // Mapel Export/Import
    Route::get('/mapel/export', [\App\Http\Controllers\Admin\MapelController::class, 'export'])->name('mapel.export');
    Route::get('/mapel/template', [\App\Http\Controllers\Admin\MapelController::class, 'downloadTemplate'])->name('mapel.template');
    Route::post('/mapel/import', [\App\Http\Controllers\Admin\MapelController::class, 'import'])->name('mapel.import');
    
    // Jadwal management
    Route::get('/jadwal', function () {
        return view('admin.jadwal.index');
    })->name('jadwal.index');
    
    Route::get('/jadwal/create', function () {
        return view('admin.jadwal.create');
    })->name('jadwal.create');
    
    Route::get('/jadwal/{jadwal}/edit', function (App\Models\Jadwal $jadwal) {
        return view('admin.jadwal.edit', ['jadwal' => $jadwal]);
    })->name('jadwal.edit');

    // Jadwal Export/Import
    Route::get('/jadwal/export', [\App\Http\Controllers\Admin\JadwalController::class, 'export'])->name('jadwal.export');
    Route::get('/jadwal/export-pdf', [\App\Http\Controllers\Admin\JadwalController::class, 'exportPdf'])->name('jadwal.export-pdf');
    Route::get('/jadwal/template', [\App\Http\Controllers\Admin\JadwalController::class, 'downloadTemplate'])->name('jadwal.template');
    Route::post('/jadwal/import', [\App\Http\Controllers\Admin\JadwalController::class, 'import'])->name('jadwal.import');
    
    // Nilai management
    Route::get('/nilai', function () {
        return view('admin.nilai.index');
    })->name('nilai.index');
    
    Route::get('/nilai/input', function () {
        return view('admin.nilai.input');
    })->name('nilai.input');
    
    Route::get('/nilai/rapor/{santri}', function (App\Models\Santri $santri) {
        return view('admin.nilai.rapor', ['santri' => $santri]);
    })->name('nilai.rapor');
    
    // Settings
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
    
    // Activity Logs (admin only)
    Route::get('/activity-logs', function () {
        return view('admin.activity-logs');
    })->name('activity-logs');
    
    // Backup Database (admin only)
    Route::get('/backup', [\App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup', [\App\Http\Controllers\BackupController::class, 'create'])->name('backup.create');
    Route::get('/backup/{filename}', [\App\Http\Controllers\BackupController::class, 'download'])->name('backup.download');
    Route::delete('/backup/{filename}', [\App\Http\Controllers\BackupController::class, 'destroy'])->name('backup.destroy');
    
    // Banners
    Route::get('/banners', function () {
        return view('admin.banners.index');
    })->name('banners.index');
    
    // Announcements
    Route::get('/announcements', function () {
        return view('admin.announcements.index');
    })->name('announcements.index');
    
    // CMS Pages
    Route::get('/cms/pages', function () {
        return view('admin.cms.pages');
    })->name('cms.pages');
    
    Route::get('/cms/testimonials', function () {
        return view('admin.cms.testimonials');
    })->name('cms.testimonials');
    
    Route::get('/cms/achievements', function () {
        return view('admin.cms.achievements');
    })->name('cms.achievements');
    
    // Landing Page Builder (CMS)
    Route::get('/cms/page-builder', \App\Livewire\Admin\Cms\LandingPageBuilder::class)->name('cms.page-builder');
    
    Route::get('/cms/teacher-profiles', function () {
        return view('admin.cms.teacher-profiles');
    })->name('cms.teacher-profiles');
    
    // PPDB Management
    Route::get('/ppdb', function () {
        return view('admin.ppdb.index');
    })->name('ppdb.index');
    
    Route::get('/ppdb/{registration}', function (App\Models\PpdbRegistration $registration) {
        return view('admin.ppdb.detail', ['registration' => $registration]);
    })->name('ppdb.detail');
    
    // Attendance Routes
    Route::get('/attendance/santri', function () {
        return view('admin.attendance.santri');
    })->name('attendance.santri');
    
    Route::get('/attendance/guru', function () {
        return view('admin.attendance.guru');
    })->name('attendance.guru');
    
    Route::get('/attendance/report', function () {
        return view('admin.attendance.report');
    })->name('attendance.report');
    
    // CBT Routes
    Route::get('/cbt/questions', function () {
        return view('admin.cbt.questions');
    })->name('cbt.questions');
    
    Route::get('/cbt/exams', function () {
        return view('admin.cbt.exams');
    })->name('cbt.exams');
    
    Route::get('/cbt/results/{examId?}', function (?int $examId = null) {
        return view('admin.cbt.results', compact('examId'));
    })->name('cbt.results');
    
    // Finance Routes
    Route::get('/finance/dashboard', function () {
        return view('admin.finance.dashboard');
    })->name('finance.dashboard');
    
    Route::get('/finance/tagihan', function () {
        return view('admin.finance.tagihan');
    })->name('finance.tagihan');
    
    Route::get('/finance/payments', function () {
        return view('admin.finance.payments');
    })->name('finance.payments');
    
    Route::get('/finance/reports', [\App\Http\Controllers\FinancialReportController::class, 'index'])->name('finance.reports');
    Route::post('/finance/reports/generate', [\App\Http\Controllers\FinancialReportController::class, 'generate'])->name('finance.reports.generate');
    Route::get('/finance/invoice/{tagihan}', [\App\Http\Controllers\FinancialReportController::class, 'invoice'])->name('finance.invoice');
    Route::get('/finance/kwitansi/{tagihan}', [\App\Http\Controllers\FinancialReportController::class, 'kwitansi'])->name('finance.kwitansi');
    
    // Export Data Page
    Route::get('/export-data', function () {
        return view('admin.export-data');
    })->name('export-data');
    
    // Question Bank Import/Export
    Route::get('/cbt/questions/export', [\App\Http\Controllers\QuestionBankController::class, 'export'])->name('cbt.questions.export');
    Route::get('/cbt/questions/template', [\App\Http\Controllers\QuestionBankController::class, 'downloadTemplate'])->name('cbt.questions.template');
    Route::post('/cbt/questions/import', [\App\Http\Controllers\QuestionBankController::class, 'import'])->name('cbt.questions.import');
    
    // AI Routes
    Route::get('/ai/rpp', function () {
        return view('admin.ai.rpp');
    })->name('ai.rpp');
    
    Route::get('/ai/questions', function () {
        return view('admin.ai.questions');
    })->name('ai.questions');
    
    // Rapor Routes
    Route::get('/rapor', [App\Http\Controllers\RaporController::class, 'index'])->name('rapor.index');
    Route::get('/rapor/summary', [App\Http\Controllers\RaporController::class, 'summary'])->name('rapor.summary');
    Route::get('/rapor/{santri}', [App\Http\Controllers\RaporController::class, 'show'])->name('rapor.show');
    Route::get('/rapor/{santri}/preview', [App\Http\Controllers\RaporController::class, 'preview'])->name('rapor.preview');
    Route::get('/rapor/{santri}/download', [App\Http\Controllers\RaporController::class, 'generatePdf'])->name('rapor.download');
    
    // CMS Routes
    Route::get('/cms/testimonials', function () {
        return view('admin.cms.testimonials');
    })->name('cms.testimonials');
    
    Route::get('/cms/achievements', function () {
        return view('admin.cms.achievements');
    })->name('cms.achievements');
    
    Route::get('/cms/pages', function () {
        return view('admin.cms.pages');
    })->name('cms.pages');
    
    Route::get('/cms/teacher-profiles', function () {
        return view('admin.cms.teacher-profiles');
    })->name('cms.teacher-profiles');
    
    Route::get('/cms/settings', \App\Livewire\Admin\Cms\LandingPageSettings::class)->name('cms.settings');
    Route::get('/cms/programs', \App\Livewire\Admin\Cms\ProgramManager::class)->name('cms.programs');

    // Teacher Journal Routes
    Route::get('/journal/export', [\App\Http\Controllers\Admin\JournalController::class, 'export'])->name('journal.export');
    Route::resource('journal', \App\Http\Controllers\Admin\JournalController::class)->names([
        'index' => 'journal.index',
        'show' => 'journal.show',
        'destroy' => 'journal.destroy',
    ])->only(['index', 'show', 'destroy']);
    Route::patch('/journal/{journal}/verify', [\App\Http\Controllers\Admin\JournalController::class, 'verify'])->name('journal.verify');
});

/*
|--------------------------------------------------------------------------
| Guru Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');
    
    Route::get('/jadwal', function () {
        return view('guru.jadwal.index');
    })->name('jadwal.index');
    
    Route::get('/nilai', function () {
        return view('guru.nilai.index');
    })->name('nilai.index');

    // Teacher Journal Routes
    Route::resource('journal', \App\Http\Controllers\TeacherJournalController::class)->names([
        'index' => 'journal.index',
        'create' => 'journal.create',
        'store' => 'journal.store',
        'edit' => 'journal.edit',
        'update' => 'journal.update',
        'destroy' => 'journal.destroy',
    ]);
});

/*
|--------------------------------------------------------------------------
| Santri Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:santri'])->prefix('santri')->name('santri.')->group(function () {
    Route::get('/dashboard', function () {
        return view('santri.dashboard');
    })->name('dashboard');
    
    Route::get('/nilai', function () {
        return view('santri.nilai.index');
    })->name('nilai.index');
    
    Route::get('/jadwal', function () {
        return view('santri.jadwal.index');
    })->name('jadwal.index');
    
    // CBT Routes
    Route::get('/cbt', function () {
        return view('santri.cbt.index');
    })->name('cbt.index');
    
    Route::get('/cbt/exam/{exam}', function (\App\Models\Exam $exam) {
        return view('santri.cbt.take', compact('exam'));
    })->name('cbt.take');
});

/*
|--------------------------------------------------------------------------
| Wali Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:wali'])->prefix('wali')->name('wali.')->group(function () {
    Route::get('/dashboard', function () {
        return view('wali.dashboard');
    })->name('dashboard');
    
    Route::get('/monitoring', function () {
        return view('wali.monitoring.index');
    })->name('monitoring.index');
    
    Route::get('/nilai', function () {
        return view('wali.nilai.index');
    })->name('nilai.index');
    
    Route::get('/presensi', function () {
        return view('wali.presensi.index');
    })->name('presensi.index');
    
    Route::get('/tagihan', function () {
        return view('wali.tagihan.index');
    })->name('tagihan.index');
    
    Route::get('/chat', function () {
        return view('wali.chat.index');
    })->name('chat.index');

    Route::get('/rapor/{santri}/download', [\App\Http\Controllers\RaporController::class, 'generatePdf'])->name('rapor.download');
});

require __DIR__.'/auth.php';
