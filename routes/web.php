<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleNonRecuController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\Auth\TwoFactorController;
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
use App\Http\Middleware\TwoFactorAuthMiddleware;

use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Checkout;

Route::get('/', [CollectionController::class, 'index'])->name('decouverte')->withoutMiddleware([TwoFactorAuthMiddleware::class]);

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

    /* Routes liées aux filtre */
    Route::post('/articleFiltre', [ArticleController::class, 'articleFiltre'])->name('articleFiltre');
    Route::post('/kiosqueFiltre', [ArticleController::class, 'kiosqueFiltre'])->name('kiosqueFiltre');
});

/* Routes liées aux commandes*/
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

/* Routes liées aux transactions */
Route::controller(TransactionController::class)->group(function () {
    Route::get('/deleteThisArticle/{id}', 'destroy')->name('removeFromPanier');
    Route::post('/addArticleToPanier', 'store')->name('addArticleToPanier');
    Route::get('/mesTransactions/{idUser}', [TransactionController::class, 'mesTransactions'])->name('mesTransactions');
    Route::get('/traiterTransactionForm/{idTransaction}', [TransactionController::class, 'edit'])->name('traiterTransactionForm');
    Route::post('/traiterTransaction', [TransactionController::class, 'update'])->name('traiterTransaction');
    Route::post('/updateQuantite', 'updateQt')->name('update');

    /* Routes liées aux filtres */
    Route::post('/transactionsFiltres', [TransactionController::class, 'commandesFiltre'])->name('commandesFiltre');

    /* Routes liées au WebHook EasyPost */
    Route::post('/easypost/events', [TransactionController::class, 'updateWithWebHook']);
});

Route::get('/buttons', function () {
    return view('buttons');
})->name('buttons');

Route::get('/erreur', function () {
    return view('erreur');
})->name('erreur');

Route::middleware(['auth', TwoFactorAuthMiddleware::class])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profil/edit', 'edit')->name('profile.edit');
        Route::get('/profil/facturation', 'facturation')->name('profile.facturation');
        Route::get('/profil/carte/modifier', 'stripe_methodePaiement_form')->name('profile.modifierCarte');
        Route::get('/profil/carte/supprimer', 'destroy_card')->name('profile.supprimerCarte');
        Route::get('/profil/personnaliser', 'personnaliser')->name('profile.personnaliser');
        Route::post('/profil/edit', 'updateBlur')->name('profile.updateBlur');
        Route::patch('/profil', 'update')->name('profile.update');
        Route::delete('/profil', 'destroy')->name('profile.destroy');

        /** Route lié a stripe connect*/
        Route::get('/stripe/create-account', 'creeCompteConnect')->name('stripe.connect');
        Route::get('/connect', 'connectReturn')->name('connect-return');
        Route::get('/refresh', 'connectRefresh')->name('connect-refresh');
    });

    Route::controller(ArtisteController::class)->group(function () {
        Route::post('/profil/update-picture', 'updatePicture')->name('artiste.updatePicture');
        Route::post('/profil/update-name', 'updateName')->name('artiste.updateName');
        Route::post('/profil/update-color', 'updateColor')->name('artiste.updateColor');
        Route::post('/profil/update-socials', 'updateSocials')->name('artiste.updateSocials');
    });

    Route::controller(DemandeController::class)->group(function () {
        Route::get('/devenir-artiste', 'create')->name('devenir-artiste')->middleware(EnsureUserCanBecomeArtist::class);
        Route::post('/devenir-artiste', 'store')->name('store-demande-artiste');
        Route::get('/renouvellement', 'create')->name('renouvellement-artiste')->middleware(EnsureUserIsArtist::class);
    });

    Route::controller(AbonnementController::class)->group(function() {
        Route::get('/abonnement', 'create')->name('abonnement')->middleware(EnsureUserCanSubscribe::class);
        Route::get('/abonnement/demarrer', 'store')->name('demarrer-abonnement');
        Route::get('/abonnement/annuler', 'destroy')->name('annuler-abonnement');
    });

    Route::post('/article-non-recu', [ArticleNonRecuController::class, 'store'])->name('article-non-recu');

    Route::post('/2fa/activate',[TwoFactorController::class, 'create'])->name('2fa.activate');
    Route::post('/2fa/deactivate',[TwoFactorController::class, 'destroy'])->name('2fa.deactivate');

    //Route pour la génération de facture
    Route::get('/facture/vente/{id_commande}', [CommandeController::class, 'recusArtistes'])->name('recus');

    Route::post('/like/{idArticle}', [LikeController::class, 'toggleLike'])->name('like.toggle');
});

Route::get('/2fa', [TwoFactorController::class,'show'])->name('2fa');
Route::post('/2fa/verif', [TwoFactorController::class,'verify'])->name('2fa.verify')->withoutMiddleware([TwoFactorAuthMiddleware::class]);

Route::get('/recherche', [ArticleController::class, 'getSearch'])->name('recherche.getSearch');


Route::view('/contact', 'contact')->name('contact');
Route::view('/about-us', 'apropos')->name('apropos');

/* Route lié à l'utilisateur */
Route::controller(UserController::class)->group(function () {
    Route::post('/updateUnits', [UserController::class, 'updateUnits'])->name('updateUnits');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
