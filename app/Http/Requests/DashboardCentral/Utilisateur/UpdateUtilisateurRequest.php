<?php

namespace App\Http\Requests\DashboardCentral\Utilisateur;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUtilisateurRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize(): bool
    {
        return true;  // Autoriser tous les utilisateurs à effectuer cette action, à ajuster selon vos besoins
    }

    /**
     * Règles de validation pour la requête.
     */
    public function rules(): array
    {
        return [
            'entreprise_id' => 'nullable|integer|exists:entreprises,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'role' => 'nullable|string',
            'email' => 'nullable|string|email|unique:utilisateurs,email,' . $this->route('utilisateur_id'),
            'status' => 'nullable|boolean',
        ];
    }

    /**
     * Messages d'erreur personnalisés pour la validation.
     */
    public function messages(): array
    {
        return [
            'entreprise_id.required' => 'L\'identifiant de l\'entreprise est obligatoire.',
            'entreprise_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom de famille est obligatoire.',
            'role.required' => 'Le rôle est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse valide.',
            'email.unique' => 'Cet email est déjà utilisé par un autre utilisateur.',
            'status.required' => 'Le statut est obligatoire.',
            'status.boolean' => 'Le statut doit être vrai ou faux.',
        ];
    }

    /**
     * Personnaliser la réponse en cas d'échec de validation.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors();
        // Renvoyer une réponse avec le premier message d'erreur
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json(['error' => $errors->first()], 422)
        );
    }
}
