<?php

namespace App\Http\Controllers\DashboardCentral;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardCentral\CreateEntrepriseRequest;
use App\Http\Requests\DashboardCentral\UpdateEntrepriseRequest;
use App\Http\Requests\DashboardCentral\UpdateEntrepriseStatusRequest;
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
    public function create_entreprise(CreateEntrepriseRequest $request){
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
    public function update_entreprise(UpdateEntrepriseRequest $request ,$entreprise_id){
        try{
            $data = $request->validated();
            $entreprise = $this->entrepriseService->getEntreprise($entreprise_id);
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $logoPath = $this->entrepriseService->storeLogo($request->file('logo'));
                $data['logo'] = $logoPath;
            }
            $this->entrepriseService->updateEntreprise($entreprise , $data);
            return response()->json([
                'message' => 'L\'entreprise a été mise à jour avec succès.',
            ], 200);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function update_status(UpdateEntrepriseStatusRequest $request, $entreprise_id)
    {
        try {
            $status = $request->validated()['status'];
            $entreprise = $this->entrepriseService->getEntreprise($entreprise_id);
            $this->entrepriseService->updateStatus($entreprise, $status);
            return response()->json([
                'message' => 'Le statut de l\'entreprise a été mis à jour avec succès.',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function delete_entreprise ($entreprise_id){
        try{
            $entreprise = $this->entrepriseService->getEntreprise($entreprise_id);
            $this->entrepriseService->deleteEntreprise($entreprise ,$entreprise_id );
            return response()->json([
                'message' => 'L\'entreprise a été supprimée avec succès.',
            ], 200);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
