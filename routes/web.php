<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    if (! auth()->user()->can('dashboard.view')) {
        return redirect()->route('pengaduans.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('pengaduans/{pengaduan}/photos', [PengaduanController::class, 'photos'])
        ->middleware('permission:pengaduan.view')
        ->name('pengaduans.photos');
    Route::get('pengaduans/{pengaduan}/file', [PengaduanController::class, 'file'])
        ->middleware('permission:pengaduan.view')
        ->name('pengaduans.file');

    Route::get('pengaduans', [PengaduanController::class, 'index'])
        ->middleware('permission:pengaduan.view')
        ->name('pengaduans.index');
    Route::get('pengaduans/create', [PengaduanController::class, 'create'])
        ->middleware('permission:pengaduan.create')
        ->name('pengaduans.create');
    Route::post('pengaduans', [PengaduanController::class, 'store'])
        ->middleware('permission:pengaduan.create')
        ->name('pengaduans.store');
    Route::get('pengaduans/{pengaduan}/edit', [PengaduanController::class, 'edit'])
        ->middleware('permission:pengaduan.update')
        ->name('pengaduans.edit');
    Route::put('pengaduans/{pengaduan}', [PengaduanController::class, 'update'])
        ->middleware('permission:pengaduan.update')
        ->name('pengaduans.update');
    Route::patch('pengaduans/{pengaduan}', [PengaduanController::class, 'update'])
        ->middleware('permission:pengaduan.update');
    Route::delete('pengaduans/{pengaduan}', [PengaduanController::class, 'destroy'])
        ->middleware('permission:pengaduan.delete')
        ->name('pengaduans.destroy');

    Route::resource('kategoris', KategoriController::class)
        ->except(['show'])
        ->middleware('permission:kategori.manage');
    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('permission:user.manage');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
