<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'role' => 'super-admin'
        ]);
        
        Role::create([
            'role' => 'admin'
        ]);

        Role::create([
            'role' => 'cda-tc-1123'
        ]);
    }
}
