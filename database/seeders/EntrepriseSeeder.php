<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use Illuminate\Database\Seeder;

class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Entreprise::create([
            'name' => 'CRM Solutions',
            'localisation' => 'Paris, France',
            'phone' => '0123456789',
            'address' => '123 Rue de l\'Entreprise, Paris',
            'logo' => 'logo.png',
            'ice' => 'AB123456789',
            'email' => 'contact@crm-solutions.fr',
            'status' => true,
        ]);
    }
}
