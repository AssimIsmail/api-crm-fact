<?php

namespace App\Http\Controllers\DashboardCentral;

use App\Http\Controllers\Controller;
use App\Services\DashboardCentral\UtilisateurService;
use App\Utils\PaginationHelper;
use Exception;
use Illuminate\Http\JsonResponse;

class UtilisateurController extends Controller
{
    protected UtilisateurService $utilisateurService;

    public function __construct(UtilisateurService $utilisateurService)
    {
        $this->utilisateurService = $utilisateurService;
    }

    public function get_utilisateurs(){
        try{
            $entreprises = $this->utilisateurService->getUtilisateurs();
            $pagination_links = PaginationHelper::generatePaginationLinks($entreprises);
            return response()->json([
                'utilisateurs' => $entreprises->items(),
                'links' => $pagination_links['links'],
                'current_page' => $pagination_links['current_page'],
                'first_page' => $pagination_links['first_page'],
                'last_page' => $pagination_links['last_page'],
            ], JsonResponse::HTTP_OK);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function get_utilisateur($utilisateur_id){
        try{
            $utilisateur = $this->utilisateurService->getUtilisateur($utilisateur_id);
            return response()->json([
                'utilisateur' => $utilisateur,
            ], JsonResponse::HTTP_OK);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
