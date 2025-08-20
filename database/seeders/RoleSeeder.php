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
        $roles = ['admin', 'kasir', 'owner', 'bar', 'kitchen', 'pelanggan'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Sikasir', 'password' => Hash::make('admin123')]
        );

        $admin->assignRole('admin');
        
        $kasir = User::firstOrCreate(
            ['email' => 'kasir@gmail.com'],
            ['name' => 'kasir', 'password' => Hash::make('kasir123')]
        );

        $kasir->assignRole('kasir');
        
        $owner = User::firstOrCreate(
            ['email' => 'owner@gmail.com'],
            ['name' => 'Owner Sikasir', 'password' => Hash::make('owner123')]
        );

        $owner->assignRole('owner');
        
        $kitchen = User::firstOrCreate(
            ['email' => 'kitchen@gmail.com'],
            ['name' => 'Kitchen Sikasir', 'password' => Hash::make('kitchen123')]
        );
    
        $kitchen->assignRole('kitchen');
        
        $bar = User::firstOrCreate(
            ['email' => 'bar@gmail.com'],
            ['name' => 'Bar Sikasir', 'password' => Hash::make('bar123')]
        );

        $bar->assignRole('bar');
    }
}