<?php

namespace App\Http\Controllers\DashboardCentral;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardCentral\Utilisateur\ChangePasswordRequest;
use App\Http\Requests\DashboardCentral\Utilisateur\ChangeStatusRequest;
use App\Http\Requests\DashboardCentral\Utilisateur\CreateUtilisateurRequest;
use App\Http\Requests\DashboardCentral\Utilisateur\UpdateUtilisateurRequest;
use App\Services\DashboardCentral\UtilisateurService;
use App\Utils\PaginationHelper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

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
    public function create_utilisateur (CreateUtilisateurRequest $request){
        try{
            $utilisateur = $request->validated();
            $utilisateur['password'] = Hash::make($utilisateur['password']);
            $this->utilisateurService->createUtilisateur($utilisateur);
            return response()->json([
                'message' => 'Utilisateur créée avec succès.',
            ], 201);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function update_utilisateur ($utilisateur_id, UpdateUtilisateurRequest $request){
        try{
            $data = $request->validated();
            $utilisateur = $this->utilisateurService->getUtilisateur($utilisateur_id);
            $this->utilisateurService->updateUtilisateur($utilisateur,$data);
            return response()->json([
                'message' => 'L\'utilisateur a été mise à jour avec succès.',
            ], 200);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function  change_password ($utilisateur_id, ChangePasswordRequest $request){
        try{
            $data = $request->validated();
            $utilisateur = $this->utilisateurService->getUtilisateur($utilisateur_id);
            $this->utilisateurService->changePassword(
                $utilisateur,
                $data['current_password'],
                $data['new_password']
            );
            return response()->json([
                'message' => 'Le mot de passe  a été mise à jour avec succès.',
            ], 200);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function  change_status ($utilisateur_id, ChangeStatusRequest $request){
        try{
            $data = $request->validated();
            $utilisateur = $this->utilisateurService->getUtilisateur($utilisateur_id);
            $this->utilisateurService->changeStatus(
                $utilisateur,
                $data['status'],
            );
            return response()->json([
                'message' => 'Le status  a été mise à jour avec succès.',
            ], 200);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
