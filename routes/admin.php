<?php

use App\Http\Middleware\EnsureUserIsModerateur;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\SignalementController;
use App\Http\Controllers\RenouvellementController;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsModerateur::class)->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin');

    Route::controller(UserController::class)->group(function () {
        Route::get('/admin/utilisateurs', 'index')
            ->name('admin-utilisateurs');

        Route::post('/admin/delete', 'destroy')
            ->name('admin-user-delete');

        Route::post('/admin/avertir', 'avertir')
            ->name('admin-user-avertir');

        Route::post('/admin/promote', 'promote')
            ->name('admin-user-promote');

        Route::post('/admin/demote', 'demote')
            ->name('admin-user-demote');
    });

    Route::get('/admin/articles', function () {
        return view('admin/articles');
    })->name('admin-articles');

    Route::controller(SignalementController::class)->group(function () {
        Route::get('/admin/signalements', 'index')
        ->name('admin-signalements');

        Route::post('/admin/signalements/delete', 'destroy')
        ->name('admin-signalements-delete');
    });

    Route::controller(DemandeController::class)->group(function () {
        Route::get('/admin/demandes', 'index')
            ->name('admin-demandes');

        Route::get('/admin/demandes-traitees', 'index_traitees')
            ->name('admin-demandes-traitees');

        Route::post('/admin/demandes/accept', 'accept')
            ->name('demande-accept');

        Route::post('/admin/demandes/deny', 'deny')
            ->name('demande-deny');
    });


    Route::get('/admin/articles-non-recus', function () {
        return view('admin/articles-non-recus');
    })->name('admin-articles-non-recus');

    Route::get('/admin/commandes', [AdminController::class, 'commandes'])
    ->name('admin-commandes');

    Route::get('/admin/abonnements', [AdminController::class, 'abonnements'])
    ->name('admin-abonnements');

    Route::get('/admin/renouvellement', [RenouvellementController::class, 'index'])
    ->name('admin-renouvellement');

    Route::post('/admin/renouvellement', [RenouvellementController::class, 'store'])->name('admin-do-renouvellement');
});
