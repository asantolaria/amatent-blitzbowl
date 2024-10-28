<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'email_verified_at' => now(),
            'admin' => true,
            'enabled' => true
        ]);

        User::create([
            'name' => 'Alex',
            'last_name' => 'Santolaria',
            'email' => 'alex.carter15@gmail.com',
            'password' => 'admin',
            'email_verified_at' => now(),
            'admin' => true,
            'enabled' => true
        ]);

        User::create([
            'name' => 'User1',
            'last_name' => 'Test1',
            'email' => 'user1@user.com',
            'password' => 'test',
            'email_verified_at' => now(),
            'admin' => false,
            'enabled' => false
        ]);
    }
}
