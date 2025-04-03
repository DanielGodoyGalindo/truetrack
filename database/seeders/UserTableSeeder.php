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
        /* Clientes */
        /* Empieza desde el id 2 */
        DB::table('users')->insert([
            'name' => 'cliente1',
            'email' => 'cliente1@gmail.com',
            'password' => Hash::make('cliente1'),
            'rol' => 'cliente',
        ]);

        DB::table('users')->insert([
            'name' => 'cliente2',
            'email' => 'cliente2@gmail.com',
            'password' => Hash::make('cliente2'),
            'rol' => 'cliente',
        ]);

        /* Gestores */
        DB::table('users')->insert([
            'name' => 'gestor1',
            'email' => 'gestor1@gmail.com',
            'password' => Hash::make('gestor1'),
            'rol' => 'gestor_trafico',
        ]);

        /* Transportistas */
        DB::table('users')->insert([
            'name' => 'transportista1',
            'email' => 'transportista1@gmail.com',
            'password' => Hash::make('transportista1'),
            'rol' => 'transportista',
        ]);

        /* Admin */
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'rol' => 'administrador',
        ]);
    }
}
