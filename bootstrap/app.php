<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function () {
        Route::prefix('api/dashboard-central')->group(function () {
            require __DIR__.'/../routes/api-dashboard-central.php';  // Vérifie que ce fichier existe
        });

        Route::prefix('api/session')->group(function () {
            require __DIR__.'/../routes/api-session.php';  // Vérifie que ce fichier existe
        });

        // Inclure d'autres routes si nécessaire
        require __DIR__.'/../routes/web.php';
        require __DIR__.'/../routes/console.php';
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrement du middleware personnalisé
        $middleware->alias([
            'isAdminCentral' => \App\Http\Middleware\IsAdminCentral::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configuration des exceptions ici
    })
    ->create();
