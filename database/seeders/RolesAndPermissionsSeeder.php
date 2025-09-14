<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- PERMISOS PARA TIPOS DE VISITA ---
        Permission::firstOrCreate(['name' => 'ver tipo_visitas']);
        Permission::firstOrCreate(['name' => 'crear tipo_visitas']);
        Permission::firstOrCreate(['name' => 'editar tipo_visitas']);
        Permission::firstOrCreate(['name' => 'eliminar tipo_visitas']);

        // --- PERMISOS PARA VISITAS --- 
        Permission::firstOrCreate(['name' => 'ver visitas']);
        Permission::firstOrCreate(['name' => 'crear visitas']);
        Permission::firstOrCreate(['name' => 'editar visitas']);
        Permission::firstOrCreate(['name' => 'eliminar visitas']);

        // --- ROL DE ADMIN ---
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}