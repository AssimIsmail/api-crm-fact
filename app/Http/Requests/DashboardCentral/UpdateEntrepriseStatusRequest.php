<?php

namespace App\Http\Requests\DashboardCentral;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntrepriseStatusRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;  // Tu peux ajouter une logique pour vérifier les permissions ici
    }

    /**
     * Règles de validation appliquées à la requête.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'status' => 'required|boolean', 
        ];
    }
}
