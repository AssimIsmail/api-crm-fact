<?php

namespace App\Http\Requests\DashboardCentral\Utilisateur;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUtilisateurRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'entreprise_id' => 'required|integer|exists:entreprises,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'required|string',
            'email' => 'required|string|email|unique:utilisateurs,email',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'entreprise_id.required' => 'L\'identifiant de l\'entreprise est obligatoire.',
            'entreprise_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom de famille est obligatoire.',
            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle doit être admin, user ou manager.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'status.required' => 'Le statut est obligatoire.',
            'status.boolean' => 'Le statut doit être vrai ou faux.',
        ];
    }
     /**
     * Personnaliser la réponse en cas d'échec de validation.
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Only get the first error message
        $firstError = $errors->first();

        // Throw a custom response with the first error message
        throw new HttpResponseException(
            response()->json(['error' => $firstError], 422)
        );
    }
}
