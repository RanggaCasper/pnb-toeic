<?php

namespace Database\Seeders;

use App\Models\ProgramStudy;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::firstOrCreate([
            'identity' => '01',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'gender' => 'male',
            'password' => Hash::make('password'),
            'birthday' => '2000-01-01',
            'role_id' => Role::where('name', 'admin')->first()->id,
            // 'program_study_id' => ProgramStudy::where('name', 'Teknologi Rekayasa Perangkat Lunak')->first()->id
        ]);

        // User
        User::firstOrCreate([
            'identity' => '02',
            'name' => 'user',
            'email' => 'user@gmail.com',
            'gender' => 'male',
            'password' => Hash::make('password'),
            'birthday' => '2000-01-01',
            'role_id' => Role::where('name', 'user')->first()->id,
            'program_study_id' => ProgramStudy::where('name', 'Teknologi Rekayasa Perangkat Lunak')->first()->id
        ]);

        //super
        User::firstOrCreate([
            'identity' => '03',
            'name' => 'Super',
            'email' => 'Super@example.com',
            'gender' => 'male',
            'password' => Hash::make('password'),
            'birthday' => '2000-01-01',
            'role_id' => Role::where('name', 'super')->first()->id,
            // 'program_study_id' => ProgramStudy::where('name', 'Teknologi Rekayasa Perangkat Lunak')->first()->id
        ]);
    }
}
