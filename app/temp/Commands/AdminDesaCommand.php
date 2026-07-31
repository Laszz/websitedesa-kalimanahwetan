<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AdminDesaCommand extends Command
{
    protected $signature = 'admindesa:admin';
    protected $description = 'Create admin user from .env credentials';

    public function handle()
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password) {
            $this->error('ADMIN_EMAIL and ADMIN_PASSWORD must be set in .env');
            return 1;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => bcrypt($password),
                'role' => 'admin',
                'status' => 'disetujui',
            ]
        );

        $this->info("Admin user created: {$user->email}");
    }
}
