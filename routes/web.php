<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\EnsureUserIsArtist;
use App\Http\Middleware\EnsureUserCanBecomeArtist;
use App\Http\Middleware\EnsureUserIsProArtist;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Checkout;

Route::get('/', [CollectionController::class, 'index'])->name('decouverte');

/* Route relié au kiosque */
Route::controller(ArtisteController::class)->group(function () {
    Route::get('/kiosque/{idUser}', 'show')->name('kiosque');
});

/* Route relié aux notifications */
Route::controller(NotificationController::class)->group(function () {
    Route::post('/notification/hide', 'hideNotification')->name('notification.hide');
});

/* Routes liés à Article */
Route::controller(ArticleController::class)->group(function () {
    Route::post('/addArticle', 'store')->name('addArticle');
    Route::get('/modifArticleForm/{idArticle}', 'showModifArticle')->name('modifArticleForm');
    Route::get('/tousMesArticles', 'show')->name('tousMesArticles');
    Route::patch('/deleteArticle', 'update')->name('deleteArticle');
    Route::get('/addArticleForm', 'create')->name('addArticleForm');
    Route::patch('/modifArticle', 'update')->name('modifArticle');
    Route::post('/signaleArticle', 'store')->name('signaleArticle');
});

/* Routes lié aux commandes*/
Route::controller(CommandeController::class)->group(function () {
    #Route pour afficher le panier en cours de l'utilisateur
    Route::get('/panier', [CommandeController::class, 'showPanier'])->name('panier');
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes');
    Route::get('/commande/{id}', 'show');

    /**Route pour Cashier */
    Route::get('/checkout','checkoutCommande')->name('checkout');
    Route::get('/checkout/success', 'success')->name('checkout-success');
    Route::get('/checkout/cancel', 'cancel')->name('checkout-cancel');
});

/* Routes liés aux transactions */
Route::controller(TransactionController::class)->group(function () {
    Route::get('/deleteThisArticle/{id}', 'destroy');
    Route::post('/addArticleToPanier', 'store')->name('addArticleToPanier');
    Route::get('/mesTransactions/{idUser}', [TransactionController::class, 'mesTransactions'])->name('mesTransactions');
    Route::get('/traiterTransactionForm/{idTransaction}', [TransactionController::class, 'edit'])->name('traiterTransactionForm');
    Route::post('/traiterTransaction', [TransactionController::class, 'update'])->name('traiterTransaction');
    Route::post('/updateQuantite','updateQt')->name('update');
});

Route::get('/buttons', function () {
    return view('buttons');
})->name('buttons');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/facturation', [ProfileController::class, 'facturation'])->name('profile.facturation');
    Route::get('/stripe/facturation', [ProfileController::class, 'stripe_facturation_form'])->name('stripe.facturation');
    Route::get('/profile/personnaliser', [ProfileController::class, 'personnaliser'])->name('profile.personnaliser');
    Route::post('/profile/edit', [ProfileController::class, 'updateBlur'])->name('profile.updateBlur');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-picture', [ArtisteController::class, 'updatePicture'])->name('artiste.updatePicture');
    Route::post('/profile/update-name', [ArtisteController::class, 'updateName'])->name('artiste.updateName');
    Route::get('/devenir-artiste', [DemandeController::class, 'create'])->name('devenir-artiste')->middleware(EnsureUserCanBecomeArtist::class);
    Route::post('/devenir-artiste', [DemandeController::class, 'store'])->name('store-demande-artiste');
    Route::get('/renouvellement', [DemandeController::class, 'create'])->name('renouvellement-artiste')->middleware(EnsureUserIsArtist::class);
    Route::get('/abonnement', [AbonnementController::class, 'create'])->name('abonnement')->middleware(EnsureUserIsProArtist::class);
    Route::post('/abonnement', [AbonnementController::class, 'store'])->name('abonnement');
    Route::get('/abonnement/annuler', [AbonnementController::class, 'destroy'])->name('annuler-abonnement');
});

Route::get('/recherche/{search}', [ArticleController::class, 'getSearch'])->name('recherche.getSearch');



require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
