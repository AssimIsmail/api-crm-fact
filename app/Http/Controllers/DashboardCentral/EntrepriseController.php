<?php

namespace App\Http\Controllers\DashboardCentral;

use App\Http\Controllers\Controller;
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

        }
    }
}
