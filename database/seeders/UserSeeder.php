<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== USUARIO ADMINISTRADOR =====
        $admin = User::updateOrCreate(
            ['email' => 'admin@dahen.dev'],
            [
                'name' => 'Admin Dahen',
                'password' => Hash::make('password'), 
            ]
        );
        $admin->assignRole('admin');

    }
}