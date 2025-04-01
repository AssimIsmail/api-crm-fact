<?php

namespace App\Http\Requests\DashboardCentral;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EntrepriseRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation appliquées à la requête.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'localisation' => 'nullable|string|max:255',
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ice' => 'required|string|max:20|unique:entreprises,ice',
            'email' => 'required|email|unique:entreprises,email',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Messages d'erreur personnalisés pour chaque règle de validation.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de l\'entreprise est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

            'localisation.string' => 'La localisation doit être une chaîne de caractères.',
            'localisation.max' => 'La localisation ne doit pas dépasser 255 caractères.',

            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone.regex' => 'Le numéro de téléphone doit être valide (10 à 15 chiffres, avec ou sans "+").',

            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'address.max' => 'L\'adresse ne doit pas dépasser 255 caractères.',

            'logo.image' => 'Le fichier doit être une image.',
            'logo.mimes' => 'L\'image doit être au format jpeg, png, jpg ou gif.',
            'logo.max' => 'L\'image ne doit pas dépasser 2 Mo.',

            'ice.required' => 'Le numéro ICE est obligatoire.',
            'ice.string' => 'Le numéro ICE doit être une chaîne de caractères.',
            'ice.max' => 'Le numéro ICE ne doit pas dépasser 20 caractères.',
            'ice.unique' => 'Ce numéro ICE est déjà utilisé.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'status.required' => 'Le statut est obligatoire.',
            'status.boolean' => 'Le statut doit être vrai ou faux.',
        ];
    }
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
