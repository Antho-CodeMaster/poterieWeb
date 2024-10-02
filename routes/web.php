<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtisteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('decouverte');
});

Route::get('/decouverte', function () {
    return view('decouverte');
})->name('decouverte');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/facturation', [ProfileController::class, 'facturation'])->name('profile.facturation');
    Route::post('/profile/edit', [ProfileController::class, 'updateBlur'])->name('profile.updateBlur');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile', [ArtisteController::class, 'updatePicture'])->name('artiste.updatePicture');
});

require __DIR__.'/auth.php';
