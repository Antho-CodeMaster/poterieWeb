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
use App\Http\Controllers\UserController;

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\EnsureUserIsArtist;
use App\Http\Middleware\EnsureUserCanBecomeArtist;
use App\Http\Middleware\EnsureUserCanSubscribe;
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
    Route::get('/checkout', 'checkoutCommande')->name('checkout');
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
    Route::post('/updateQuantite', 'updateQt')->name('update');
});

Route::get('/buttons', function () {
    return view('buttons');
})->name('buttons');

Route::middleware('auth')->group(function () {
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profil/facturation', [ProfileController::class, 'facturation'])->name('profile.facturation');
    Route::get('/profil/carte/modifier', [ProfileController::class, 'stripe_methodePaiement_form'])->name('profile.modifierCarte');
    Route::get('/profil/carte/supprimer', [ProfileController::class, 'destroy_card'])->name('profile.supprimerCarte');
    Route::get('/profil/personnaliser', [ProfileController::class, 'personnaliser'])->name('profile.personnaliser');
    Route::post('/profil/edit', [ProfileController::class, 'updateBlur'])->name('profile.updateBlur');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profil/update-picture', [ArtisteController::class, 'updatePicture'])->name('artiste.updatePicture');
    Route::post('/profil/update-name', [ArtisteController::class, 'updateName'])->name('artiste.updateName');
    Route::post('/profil/update-color', [ArtisteController::class, 'updateColor'])->name('artiste.updateColor');
    Route::post('/profil/update-socials', [ArtisteController::class, 'updateSocials'])->name('artiste.updateSocials');
    Route::get('/devenir-artiste', [DemandeController::class, 'create'])->name('devenir-artiste')->middleware(EnsureUserCanBecomeArtist::class);
    Route::post('/devenir-artiste', [DemandeController::class, 'store'])->name('store-demande-artiste');
    Route::get('/renouvellement', [DemandeController::class, 'create'])->name('renouvellement-artiste')->middleware(EnsureUserIsArtist::class);
    Route::get('/abonnement', [AbonnementController::class, 'create'])->name('abonnement')->middleware(EnsureUserCanSubscribe::class);
    Route::get('/abonnement/demarrer', [AbonnementController::class, 'store'])->name('demarrer-abonnement');
    Route::get('/abonnement/annuler', [AbonnementController::class, 'destroy'])->name('annuler-abonnement');

    /** Route lié a stripe connect*/
    Route::get('/stripe/create-account', [ProfileController::class, 'creeCompteConnect'])->name('stripe.connect');
    Route::get('/connect', [ProfileController::class, 'connectReturn'])->name('connect-return');
    Route::get('/refresh', [ProfileController::class, 'connectRefresh'])->name('connect-refresh');

    //Route pour la génération de facture
    Route::get('/facture/vente/{id_commande}', [CommandeController::class,'recusArtistes'])->name('recus');
});

Route::get('/recherche', [ArticleController::class, 'getSearch'])->name('recherche.getSearch');


Route::view('/contact','contact')->name('contact');
Route::view('/about-us','apropos')->name('apropos');

/* Route lié à l'utilisateur */
Route::controller(UserController::class)->group(function () {
    Route::post('/updateUnits', [UserController::class, 'updateUnits'])->name('updateUnits');
});



require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
