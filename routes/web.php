<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Route::resource('documents', DocumentController::class);

    // Route untuk simpan form
    Route::post('/documents/store', [DocumentController::class, 'store'])->name('documents.store');

    // Route untuk upload file via AJAX
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');

    // Route untuk menghapus file
    Route::delete('/documents/{id}', [DocumentController::class, 'delete'])->name('documents.destroy');

    // Route untuk menampilkan halaman utama
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');

    // Route untuk mengupdate dokumen
    Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');
});
