<?php

use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('decouverte');
});

/* Route relié au kiosque */
Route::controller(ArtisteController::class)->group(function(){
    Route::post('/kiosque', 'show')->name('kiosque');
});

/* Routes relié aux likes
Route::controller(LikeController::class)->group(function(){
    Route::post('/kiosque', 'show')->name('kiosque');
}); */


Route::get('/decouverte', function () {
    return view('decouverte');
})->name('decouverte');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
