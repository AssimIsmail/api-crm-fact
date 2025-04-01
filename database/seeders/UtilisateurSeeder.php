<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Utilisateur::create([
            'entreprise_id' => 1,
            'first_name' => 'Ismail',
            'last_name' => 'Assim',
            'role' => 'ADMIN_CENTRAL',
            'pays' => 'FRANCE',
            'email' => 'ismailassimdev@gmail.com',
            'password' => Hash::make('assim123'),
            'status' => true,
            'last_active' => now(),
        ]);
    }
}
