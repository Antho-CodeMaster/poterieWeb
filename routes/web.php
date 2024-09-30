<?php

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/panier', [CommandeController::class, 'showPanier']);
    Route::get('/commandes', [CommandeController::class, 'index']);
});

require __DIR__.'/auth.php';
