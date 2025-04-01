<?php

namespace App\Http\Requests\DashboardCentral\Utilisateur;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|string|min:8',  // Validation du mot de passe actuel
            'new_password' => 'required|string|min:8|confirmed',  // Validation du nouveau mot de passe
        ];
    }

    /**
     * Messages d'erreur personnalisés pour la validation.
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'current_password.min' => 'Le mot de passe actuel doit contenir au moins 8 caractères.',
            'new_password.required' => 'Le nouveau mot de passe est obligatoire.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'new_password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
        ];
    }
}
