<?php

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('decouverte');
});

Route::get('/decouverte', function () {
    return view('decouverte');
})->name('decouverte');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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
