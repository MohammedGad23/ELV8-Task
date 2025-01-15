<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email'=> 'admin@example.com',
            'phone' => '1234567890',
            'username' => 'admin',
            'password' => Hash::make('password'),  // Hash the password
            'type' => 'admin',
            'gender'=>'male',
            'created_by'=>null,
        ]);
    }
}
