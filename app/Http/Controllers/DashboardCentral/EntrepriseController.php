<?php

namespace App\Http\Controllers\DashboardCentral;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardCentral\EntrepriseRequest;
use App\Services\DashboardCentral\EntrepriseService;
use App\Utils\PaginationHelper;
use Exception;
use Illuminate\Http\JsonResponse;

class EntrepriseController extends Controller
{
    protected EntrepriseService $entrepriseService;

    public function __construct(EntrepriseService $entrepriseService)
    {
        $this->entrepriseService = $entrepriseService;
    }

    public function get_entreprises(){
        try{
            $entreprises = $this->entrepriseService->getEntreprises();
            $pagination_links = PaginationHelper::generatePaginationLinks($entreprises);
            return response()->json([
                'entreprises' => $entreprises->items(),
                'links' => $pagination_links['links'],
                'current_page' => $pagination_links['current_page'],
                'first_page' => $pagination_links['first_page'],
                'last_page' => $pagination_links['last_page'],
            ], JsonResponse::HTTP_OK);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function get_entreprise($entreprise_id){
        try{
            $entreprise = $this->entrepriseService->getEntreprise($entreprise_id);
            return response()->json([
                'entreprise' => $entreprise,
            ], JsonResponse::HTTP_OK);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function create_entreprise(EntrepriseRequest $request){
        try{
            $data = $request->validated();
            if ($request->hasFile('logo')) {
                $logoPath = $this->entrepriseService->storeLogo($request->file('logo'));
                $data['logo'] = $logoPath;
            }
            $entreprise = $this->entrepriseService->createEntreprise($data);
            return response()->json([
                'message' => 'Entreprise créée avec succès.',
            ], 201);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
