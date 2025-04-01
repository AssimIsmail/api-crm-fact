<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entreprise_id',
        'first_name',
        'last_name',
        'role',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Récupère l'identifiant unique de l'utilisateur.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Retourne la clé primaire de l'utilisateur (généralement l'ID)
    }

    /**
     * Récupère les déclarations personnalisées que tu souhaites ajouter dans le token.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // Tu peux ajouter des informations supplémentaires ici si nécessaire
    }
}
