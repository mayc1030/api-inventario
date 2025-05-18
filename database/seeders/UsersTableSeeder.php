<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Smart Tranks',
            'email' => 'smarttranks@laravel.com',
            'password' => Hash::make('025014'),
            'role' => 'admin',
        ]);
    }
}
