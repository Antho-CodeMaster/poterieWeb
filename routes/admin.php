<?php

use App\Http\Middleware\EnsureUserIsModerateur;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsModerateur::class)->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin');

    Route::get('/admin/utilisateurs', [UserController::class, 'index'])
        ->name('admin-utilisateurs');

    Route::post('/admin/delete', [UserController::class, 'destroy'])
        ->name('admin-user-delete');

    Route::post('/admin/avertir', [UserController::class, 'avertir'])
        ->name('admin-user-avertir');

    Route::post('/admin/promote', [UserController::class, 'promote'])
        ->name('admin-user-promote');

    Route::post('/admin/demote', [UserController::class, 'demote'])
        ->name('admin-user-demote');

    Route::get('/admin/articles', function () {
        return view('admin/articles');
    })->name('admin-articles');

    Route::get('/admin/signalements', function () {
        return view('admin/signalements');
    })->name('admin-signalements');

    Route::get('/admin/demandes', [DemandeController::class, 'index'])
        ->name('admin-demandes');

    Route::post('/admin/demandes/accept', [DemandeController::class, 'accept'])
        ->name('demande-accept');

    Route::post('/admin/demandes/deny', [DemandeController::class, 'deny'])
        ->name('demande-deny');

    Route::get('/admin/articles-non-recus', function () {
        return view('admin/articles-non-recus');
    })->name('admin-articles-non-recus');

    Route::get('/admin/transactions', function () {
        return view('admin/transactions');
    })->name('admin-transactions');
});
