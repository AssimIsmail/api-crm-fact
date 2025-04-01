<?php

namespace App\Services\DashboardCentral;

use App\Models\Entreprise;
use App\Services\FilterService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


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
    public function storeLogo($logo): string
    {
        try {
            if (!$logo instanceof UploadedFile) {
                throw new Exception('Le fichier fourni n\'est pas valide.');
            }
            $fileName = Str::random(40) . '.' . $logo->getClientOriginalExtension();

            $path = $logo->storeAs('logos', $fileName, 'public');
            return $path;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'enregistrement du logo.  " );
        }
    }
    public function createEntreprise($entreprise){
        try{
            $entreprise = Entreprise::create($entreprise);
            return $entreprise;
        }catch(Exception $e){
            throw new Exception("Une erreur est survenue lors de la création de l\'entreprise");
        }
    }
    public function updateEntreprise($entreprise , $data){
        try{
            $entreprise->update($data);
            return $entreprise;
         return $entreprise;
        }catch(Exception $e){
             throw new Exception("Une erreur est survenue lors de la mise à jour de l\'entreprise.");
        }
    }
    public function updateStatus($entreprise, bool $status): bool
    {
        try {
            $entreprise->status = $status;
            return $entreprise->save();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour du statut de l'entreprise.");
        }
    }
    public function deleteEntreprise ($entreprise ){
        try{
            $entreprise_deleted = $entreprise->delete();
            return $entreprise_deleted ;
        }catch(Exception $e){
             throw new Exception("L\'entreprise a été supprimée avec succès.");
        }
    }
}
