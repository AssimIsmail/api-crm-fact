<?php

namespace App\Services\DashboardCentral;

use App\Models\Utilisateur;
use App\Services\FilterService;
use Exception;


class UtilisateurService
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function getUtilisateurs($perPage = 32)
{
    try {
        $allowedFilters = ['full_name', 'email', 'status', 'role', 'entreprise_id'];
        $filters = $this->filterService->getFilters($allowedFilters);

        $query = Utilisateur::query();

        foreach ($filters as $key => $value) {
            if ($key === 'full_name') {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$value%"]);
            } elseif ($key === 'email') {
                $query->where('email', 'LIKE', "%$value%");
            } elseif ($key === 'status') {
                $query->where('status', $value);
            } elseif ($key === 'role') {
                $query->where('role', 'LIKE', "%$value%");
            } elseif ($key === 'entreprise_id') {
                $query->where('entreprise_id', $value);
            }
        }
        $query->orderBy('id');
        $utilisateurs = $query->paginate($perPage);

        return $utilisateurs;
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la récupération des utilisateurs . " );
    }
}
public function getUtilisateur($utilisateur_id){
    try {
        $utilisateur = Utilisateur::findOrFail($utilisateur_id);
        return $utilisateur;
    } catch (Exception $e) {
        throw new Exception("Utilisateur non trouvé.");
    }
}
    public function createUtilisateur($utilisateur){
        try{
            $utilisateur = Utilisateur::create($utilisateur);
            return $utilisateur;
        }catch(Exception $e){
            throw new Exception("Erreur lors de la création de l'utilisateur  ." . $e->getMessage());
        }
    }
    public function updateUtilisateur ($utilisateur,$data ){
        try{
            $utilisateur->update($data);
            return $utilisateur;
        }catch(Exception $e){
            throw new Exception("Une erreur est survenue lors de la mise à jour de l\'utilisateur.");
        }
    }
}
