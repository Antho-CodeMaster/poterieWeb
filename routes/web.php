<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\TransactionController;

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
    Route::get('/modifArticleForm/{idArticle}', 'create')->name('modifArticleForm');
    Route::get('/tousMesArticles', 'show')->name('tousMesArticles');
    Route::patch('/deleteArticle', 'update')->name('deleteArticle');
    Route::get('/addArticleForm', 'create')->name('addArticleForm');
    Route::patch('/modifArticle', 'update')->name('modifArticle');
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
    Route::get('/devenir-artiste', [DemandeController::class, 'create'])->name('devenir-artiste');
    Route::post('/devenir-artiste', [DemandeController::class, 'store'])->name('store-demande-artiste');
});


Route::get('/recherche/{search}', [ArticleController::class, 'getSearch'])->name('recherche.getSearch');

Route::controller(CommandeController::class)->group(function(){
    #Route pour afficher le panier en cours de l'utilisateur
    Route::get('/panier', [CommandeController::class, 'showPanier'])->name('panier');
    Route::get('/commandes', [CommandeController::class, 'index']);
    Route::get('/commande/{id}', 'show');

});

Route::controller(TransactionController::class)->group(function(){
    Route::get('/deleteThisArticle/{id}','destroy');
});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
