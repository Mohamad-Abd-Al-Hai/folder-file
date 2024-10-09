<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'John Doe', 'email' => 'johndoe@example.com', 'password' => Hash::make('password')],
            ['name' => 'Jane Smith', 'email' => 'janesmith@example.com', 'password' => Hash::make('password')],
        ];

        foreach ($users as $data) {
            User::create($data);
        }
    }
}
