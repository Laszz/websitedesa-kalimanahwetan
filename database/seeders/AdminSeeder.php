<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin default
        User::create([
            'name' => 'Administrator',
            'email' => 'admindesa@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'disetujui',
        ]);
    }
}
