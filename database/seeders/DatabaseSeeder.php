<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin@sumed.local'],
            [
                'name' => 'Administrador',
                'password' => 'password',
                'tipo_operacion' => 'ambos',
                'clave_remision' => 'ADM',
                'is_active' => true,
            ]
        );

        $admin->assignRole('administrador');
    }
}