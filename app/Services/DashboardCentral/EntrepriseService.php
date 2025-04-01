<?php

namespace App\Services\DashboardCentral;

use App\Models\Entreprise;
use App\Services\FilterService;
use Exception;

class EntrepriseService
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }
    public function getEntreprises($perPage = 32)
    {
        try {
            $allowedFilters = ['name', 'ice', 'status', 'pays'];

            $filters = $this->filterService->getFilters($allowedFilters);

            $query = Entreprise::query();

            foreach ($filters as $key => $value) {
                if ($key === 'name') {
                    $query->where('name', 'LIKE', "%$value%");
                } elseif ($key === 'ice') {
                    $query->where('ice', 'LIKE', "%$value%");
                } elseif ($key === 'status') {
                    $query->where('status', $value);
                } elseif ($key === 'pays') {
                    $query->whereHas('pays', function ($q) use ($value) {
                        $q->where('name', 'LIKE', "%$value%");
                    });
                }
            }
            $query->orderBy('id');
            $entreprises = $query->paginate($perPage);

            return $entreprises;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function getEntreprise($entreprise_id){
        try{
            $entreprise = Entreprise::findOrFail($entreprise_id);
            return $entreprise;
        }catch(Exception $e){
            throw new Exception("L'entreprise est introuvable.");
        }
    }
}
