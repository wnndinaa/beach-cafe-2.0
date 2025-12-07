<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('users')->insert([
            ['name' => 'Zul','email' => 'zul1@gmail.com','password' => Hash::make('password'),'role' => 'Staff', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dila','email' => 'dila1@gmail.com','password' => Hash::make('password'),'role' => 'Staff', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dina','email' => 'dina1@gmail.com','password' => Hash::make('password'),'role' => 'Customer', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Aysha','email' => 'aysha1@gmail.com','password' => Hash::make('password'),'role' => 'Customer', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Adriana','email' => 'adriana@gmail.com','password' => Hash::make('password'),'role' => 'Customer', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
