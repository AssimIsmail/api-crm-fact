<?php

namespace App\Services\Auth;

use App\Models\Utilisateur;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function authenticate(array $credentials)
    {
        // Check if user exists and password is correct
        $user = Utilisateur::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        // Generate the JWT token
        if ($token = JWTAuth::attempt($credentials)) {
            return $token;
        }

        return null;
    }
}
