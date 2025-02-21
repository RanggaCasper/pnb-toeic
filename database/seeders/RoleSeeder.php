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
        // Admin
        Role::create([
            'name' => 'admin'
        ]);
        //super admin
        Role::create([
            'name' => 'super'
        ]);

        // User
        Role::create([
            'name' => 'user'
        ]);
    }
}
