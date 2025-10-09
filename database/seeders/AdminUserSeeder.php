<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Samir',
                'email' => 'Samir@example.com',
                'password' => Hash::make('123456'),
                'role' => 'administrador',
            ],
            [
                'name' => 'Prueba',
                'email' => 'Prueba@example.com',
                'password' => Hash::make('123456'),
                'role' => 'supervisor',
            ]
        ]);
    }
}
