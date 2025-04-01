<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdminCentral
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        $user = Auth::user();

        if (!$user || $user->role !== 'ADMIN_CENTRAL') {
            return response()->json([
                'message' => 'Accès refusé. Vous devez être administrateur central.'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
