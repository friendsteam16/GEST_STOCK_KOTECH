<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'Gérer les utilisateurs',
            'Voir le tableau de bord',
            'Gérer les produits',
            'Gérer les catégories',
            'Gérer les fournisseurs',
            'Gérer les entrées',
            'Gérer les sorties',
            'Exporter les données',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        $this->call([
            PermissionSeeder::class,
        ]);
    }
}
