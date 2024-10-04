<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('decouverte');
});

/* Route relié au kiosque */
Route::controller(ArtisteController::class)->group(function(){
    Route::get('/kiosque/{idUser}', 'show')->name('kiosque');
});

/* Route lié à Article */
Route::controller(ArticleController::class)->group(function(){
    Route::post('/addArticle', 'store')->name('addArticle');
    Route::patch('/deleteArticle', 'update')->name('deleteArticle');
    Route::get('/addArticleForm', 'create')->name('addArticleForm');
});

Route::get('/decouverte', function () {
    return view('decouverte');
})->name('decouverte');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
