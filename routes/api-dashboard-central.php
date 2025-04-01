<?php

use App\Http\Controllers\DashboardCentral\EntrepriseController;
use App\Http\Controllers\DashboardCentral\UtilisateurController;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api', 'isAdminCentral'])->group(function () {
    Route::prefix('entreprises')->group(function () {
        Route::get('/', [EntrepriseController::class, 'get_entreprises'])->name('entreprises');
        Route::post('/', [EntrepriseController::class, 'create_entreprise'])->name('create.entreprise');
        Route::prefix('{entreprise_id}')->group(function () {
            Route::get('/', [EntrepriseController::class, 'get_entreprise'])->name('entreprise');
            Route::post('/', [EntrepriseController::class, 'update_entreprise'])->name('update.entreprise');
            Route::post('/status', [EntrepriseController::class, 'update_status'])->name('update.entreprise.status');
        });
    });
    Route::prefix('utilisateurs')->group(function () {
        Route::get('/', [UtilisateurController::class, 'get_utilisateurs'])->name('utilisateurs');
        Route::post('/', [UtilisateurController::class, 'create_utilisateur'])->name('create.utilisateur');
        Route::prefix('{utilisateur_id}')->group(function () {
            Route::get('/', [UtilisateurController::class, 'get_utilisateur'])->name('utilisateur');
            Route::post('/', [UtilisateurController::class, 'update_utilisateur'])->name('update.utilisateur');
            Route::post('/change-password', [UtilisateurController::class, 'change_password'])->name('change_password.utilisateur');
            Route::post('/status', [UtilisateurController::class, 'change_status'])->name('change_status.utilisateur');
        });
    });
});
