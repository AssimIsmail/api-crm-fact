<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entreprise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'localisation',
        'phone',
        'address',
        'logo',
        'ice',
        'email',
        'status',
    ];

    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class);
    }
}
