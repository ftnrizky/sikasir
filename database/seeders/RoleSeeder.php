<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        // Role::firstOrCreate(['name' => 'kasir']);
        // Role::firstOrCreate(['name' => 'owner']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Sikasir', 'password' => Hash::make('admin123')]
        );

        $admin->assignRole('admin');
    }
}