<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/berita/{id}', [LandingController::class, 'show'])->name('berita.show');

Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Post::orderBy('created_at', 'desc')->get();
    return response()->view('sitemap', [
        'posts' => $posts
    ])->header('Content-Type', 'text/xml');
});
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return app(\App\Http\Controllers\Admin\AdminDashboardController::class)->index();
    } elseif ($user->role === 'pengurus_pac') {
        if ($user->status == 0) {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect('/login')->withErrors(['username' => 'Akun Anda belum disetujui oleh Admin Cabang.']);
        }
        return app(\App\Http\Controllers\Pengurus\PengurusDashboardController::class)->index();
    } elseif ($user->role === 'penulis_berita') {
        return redirect()->route('admin.post.index');
    }
    abort(403);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route dasar Breeze yang dimodifikasi
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==== Area Admin ====
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('pengurus', \App\Http\Controllers\Admin\AdminUserController::class);
        Route::post('pengurus/{id}/approve', [\App\Http\Controllers\Admin\AdminUserController::class, 'approve'])->name('pengurus.approve');
        Route::get('pac/export', [\App\Http\Controllers\Admin\AdminPacController::class, 'export'])->name('pac.export');
        Route::resource('pac', \App\Http\Controllers\Admin\AdminPacController::class);
        Route::resource('dokumen', \App\Http\Controllers\Admin\DokumenController::class)->except(['show', 'edit', 'update']);
        
        // Surat
        Route::get('surat-masuk', [\App\Http\Controllers\Admin\SuratController::class, 'masuk'])->name('surat.masuk');
        Route::get('surat-keluar', [\App\Http\Controllers\Admin\SuratController::class, 'keluar'])->name('surat.keluar');
        Route::get('surat/create', [\App\Http\Controllers\Admin\SuratController::class, 'create'])->name('surat.create');
        Route::post('surat/store', [\App\Http\Controllers\Admin\SuratController::class, 'store'])->name('surat.store');
        Route::get('surat/{id}/edit', [\App\Http\Controllers\Admin\SuratController::class, 'edit'])->name('surat.edit');
        Route::put('surat/{id}', [\App\Http\Controllers\Admin\SuratController::class, 'update'])->name('surat.update');
        Route::post('surat/{id}/kirim', [\App\Http\Controllers\Admin\SuratController::class, 'kirim'])->name('surat.kirim');
        Route::post('surat/{id}/arsipkan', [\App\Http\Controllers\Admin\SuratController::class, 'arsipkan'])->name('surat.arsipkan');
        Route::delete('surat/{id}', [\App\Http\Controllers\Admin\SuratController::class, 'destroy'])->name('surat.destroy');
        Route::get('surat-arsip', [\App\Http\Controllers\Admin\SuratController::class, 'arsipIndex'])->name('surat.arsip');
    });

    // ==== Area Bersama Admin & Penulis Berita ====
    Route::middleware(['role:admin,penulis_berita'])->prefix('admin')->name('admin.')->group(function () {
        // Portal Berita
        Route::resource('post', \App\Http\Controllers\Admin\PostController::class);
    });

    // ==== Area Pengurus PAC ====
    Route::middleware(['role:pengurus_pac', 'status'])->prefix('pengurus')->name('pengurus.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Pengurus\PengurusDashboardController::class, 'index'])->name('dashboard');
        Route::resource('ranting', \App\Http\Controllers\Pengurus\PengurusRantingController::class);
        Route::get('dokumen', [\App\Http\Controllers\Pengurus\DokumenController::class, 'index'])->name('dokumen.index');

        // Surat
        Route::get('surat-masuk', [\App\Http\Controllers\Pengurus\SuratController::class, 'masuk'])->name('surat.masuk');
        Route::get('surat-keluar', [\App\Http\Controllers\Pengurus\SuratController::class, 'keluar'])->name('surat.keluar');
        Route::get('surat/create', [\App\Http\Controllers\Pengurus\SuratController::class, 'create'])->name('surat.create');
        Route::post('surat/store', [\App\Http\Controllers\Pengurus\SuratController::class, 'store'])->name('surat.store');
        Route::get('surat/{id}/edit', [\App\Http\Controllers\Pengurus\SuratController::class, 'edit'])->name('surat.edit');
        Route::put('surat/{id}', [\App\Http\Controllers\Pengurus\SuratController::class, 'update'])->name('surat.update');
        Route::post('surat/{id}/kirim', [\App\Http\Controllers\Pengurus\SuratController::class, 'kirim'])->name('surat.kirim');
        Route::post('surat/{id}/arsipkan', [\App\Http\Controllers\Pengurus\SuratController::class, 'arsipkan'])->name('surat.arsipkan');
        Route::delete('surat/{id}', [\App\Http\Controllers\Pengurus\SuratController::class, 'destroy'])->name('surat.destroy');
        Route::get('surat-arsip', [\App\Http\Controllers\Pengurus\SuratController::class, 'arsipIndex'])->name('surat.arsip');
    });
});

require __DIR__.'/auth.php';
