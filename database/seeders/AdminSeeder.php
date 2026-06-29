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
            'email' => 'admindesakalimanahwetan@gmail.com',
            'password' => bcrypt('desakalimanahwetan'),
            'role' => 'admin',
            'status' => 'disetujui',
        ]);
    }
}
