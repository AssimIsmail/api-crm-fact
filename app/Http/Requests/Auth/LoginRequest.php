<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }



    public function messages(): array
    {
        return [
          'email.required' => 'Veuillez entrer l\'adresse e-mail.',
'email.email' => 'L\'adresse e-mail est incorrecte.',
'password.required' => 'Veuillez entrer le mot de passe.',
'password.min' => 'Le mot de passe doit comporter au moins 6 caractères.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
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
