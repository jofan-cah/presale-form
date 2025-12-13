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
        // Create admin user dengan NIP 012412010
        User::create([
            'nip' => '012412010',
            'name' => 'Admin 2',
            'password' => Hash::make('password'),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('NIP: 012412010');
        $this->command->info('Password: password');
    }
}
