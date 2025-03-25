<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'rol' => 'administrador',
        ]);

        DB::table('users')->insert([
            'name' => 'cliente1',
            'email' => 'cliente1@gmail.com',
            'password' => Hash::make('cliente1'),
            'rol' => 'cliente',
        ]);

        DB::table('users')->insert([
            'name' => 'gestor1',
            'email' => 'gestor1@gmail.com',
            'password' => Hash::make('gestor1'),
            'rol' => 'gestor_trafico',
        ]);

        DB::table('users')->insert([
            'name' => 'transportista1',
            'email' => 'transportista1@gmail.com',
            'password' => Hash::make('transportista1'),
            'rol' => 'transportista',
        ]);
    }
}
