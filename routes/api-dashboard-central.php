<?php

use App\Http\Controllers\DashboardCentral\EntrepriseController;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:api', 'isAdminCentral'])->group(function () {
    Route::prefix('entreprises')->group(function () {
        Route::get('/', [EntrepriseController::class, 'get_entreprises'])->name('entreprises');});
});
