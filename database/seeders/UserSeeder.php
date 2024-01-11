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
        User::create([
            'lastName' => 'Super',
            'firstName' => 'Admin',
            'discord' => 'blabla-admin',
            'address' => '1-5 rue Emile Masson',
            'zipCode' => '44000',
            'city' => 'Nantes',
            'avatar' => 'no-avatar.png',
            'email' => 'arinfo@mail.com',
            'role_id' => 1,
            'password' => Hash::make('Arinfo2023$')
        ]);

        User::create([
            'lastName' => 'Simple',
            'firstName' => 'Admin',
            'discord' => 'blabla-prof',
            'address' => '1-5 rue Emile Masson',
            'zipCode' => '44000',
            'city' => 'Nantes',
            'avatar' => 'no-avatar.png',
            'email' => 'toto@mail.com',
            'role_id' => 2,
            'password' => Hash::make('Arinfo2023$')
        ]);

        User::factory(8)->create();
    }
}
