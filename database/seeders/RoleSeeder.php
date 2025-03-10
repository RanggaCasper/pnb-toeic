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
        Role::firstOrCreate([
            'name' => 'admin'
        ]);
        //super admin
        Role::firstOrCreate([
            'name' => 'super'
        ]);

        // User
        Role::firstOrCreate([
            'name' => 'user'
        ]);
    }
}
