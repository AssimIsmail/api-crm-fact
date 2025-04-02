<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Models\Utilisateur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash; // Assurez-vous d'importer Hash ici

class AuthController extends Controller
{
    // Fonction de connexion
    public function login(LoginRequest $request)
    {
        try {
            // Validation des informations de connexion
            $credentials = $request->validated();

            // Tentative d'authentification et génération du token
            $user = Utilisateur::where('email', $credentials['email'])->first();

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'error' => 'L\'adresse e-mail ou le mot de passe est incorrect. Veuillez réessayer.'
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }

            // Vérifier si l'utilisateur est activé
            if (!$user->status) {
                return response()->json([
                    'error' => 'Votre compte n\'est pas activé. Veuillez contacter le support pour obtenir de l\'aide.'
                ], JsonResponse::HTTP_FORBIDDEN);
            }
            if ($user->entreprise && !$user->entreprise->status) {
                return response()->json([
                    'error' => 'L\'entreprise associée à votre compte est désactivée. Veuillez contacter le support.'
                ], JsonResponse::HTTP_FORBIDDEN);
            }
            // Mettre à jour la dernière activité de l'utilisateur
            $user->update(['last_active' => now()]);

            // Créer un token JWT
            $token = JWTAuth::fromUser($user);

            // Créer un cookie pour stocker le token
            $cookie = cookie('token', $token, 1440, '/', '.crm-facturation.com', false, true, false, 'None');

            // Retourner les informations de l'utilisateur et le cookie
            return response()->json([
                'message' => 'Connexion réussie ! Bienvenue.',
                'user' => $user,
            ], JsonResponse::HTTP_OK)->cookie($cookie);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return response()->json([
                'error' => 'Une erreur est survenue lors de la tentative de connexion. Veuillez réessayer plus tard.'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Fonction pour récupérer les détails de l'utilisateur actuellement connecté
    public function me(Request $request)
    {
        try {
            // Récupérer l'utilisateur authentifié à partir du token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Mettre à jour la dernière activité
            $user->update(['last_active' => now()]);

            // Retourner les informations de l'utilisateur
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'status' => $user->status,
                    'last_active' => $user->last_active,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ],
            ], JsonResponse::HTTP_OK);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'error' => 'Votre session a expiré. Veuillez vous reconnecter.'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'error' => 'Le token est invalide. Veuillez vous reconnecter.'
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'error' => 'Impossible d\'accéder à la ressource. Veuillez vous reconnecter.'
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Impossible de récupérer les informations de l\'utilisateur. Veuillez vous reconnecter.'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    // Fonction de déconnexion
    public function logout(Request $request)
    {
        try {
            // Récupérer le token JWT
            $token = JWTAuth::getToken();

            if (!$token) {
                return response()->json([
                    'error' => 'Aucune session active trouvée. Veuillez vous connecter d\'abord.'
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }

            // Invalider le token
            JWTAuth::invalidate($token);

            // Supprimer le cookie contenant le token
            $cookie = cookie('token', null, -1, '/', '.127.0.0.1', false, true);

            return response()->json([
                'message' => 'Déconnexion réussie. Si vous avez besoin d\'aide, contactez le support.'
            ], JsonResponse::HTTP_OK)->cookie($cookie);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la déconnexion. Veuillez réessayer plus tard.'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
