<?php

use App\Http\Middleware\EnsureUserIsModerateur;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin')->middleware(EnsureUserIsModerateur::class);

Route::get('/admin/utilisateurs', [UserController::class, 'index'])
    ->name('admin-utilisateurs')->middleware(EnsureUserIsModerateur::class);

Route::delete('/admin/delete/{id}', [UserController::class, 'destroy'])
    ->name('admin-user-delete')->middleware(EnsureUserIsModerateur::class);

Route::get('/admin/publications', function() {
    return view('admin/publications');
})->name('admin-publications')->middleware(EnsureUserIsModerateur::class);

Route::get('/admin/signalements', function() {
    return view('admin/signalements');
})->name('admin-signalements')->middleware(EnsureUserIsModerateur::class);

Route::get('/admin/demandes', function() {
    return view('admin/demandes');
})->name('admin-demandes')->middleware(EnsureUserIsModerateur::class);

Route::get('/admin/articles-non-recus', function() {
    return view('admin/articles-non-recus');
})->name('admin-articles-non-recus')->middleware(EnsureUserIsModerateur::class);

Route::get('/admin/transactions', function() {
    return view('admin/transactions');
})->name('admin-transactions')->middleware(EnsureUserIsModerateur::class);
