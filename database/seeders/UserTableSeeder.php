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
            'name' => 'cliente Juan',
            'email' => 'clientejuan@gmail.com',
            'password' => Hash::make('clientejuan'),
            'rol' => 'cliente',
        ]);

        DB::table('users')->insert([
            'name' => 'cliente Ana',
            'email' => 'clienteana@gmail.com',
            'password' => Hash::make('clienteana'),
            'rol' => 'cliente',
        ]);

        /* Gestores */
        DB::table('users')->insert([
            'name' => 'gestor1',
            'email' => 'gestor1@gmail.com',
            'password' => Hash::make('gestor1'),
            'rol' => 'gestor_trafico',
        ]);

        DB::table('users')->insert([
            'name' => 'gestor2',
            'email' => 'gestor2@gmail.com',
            'password' => Hash::make('gestor2'),
            'rol' => 'gestor_trafico',
        ]);

        /* Transportistas */
        DB::table('users')->insert([
            'name' => 'transportista1',
            'email' => 'transportista1@gmail.com',
            'password' => Hash::make('transportista1'),
            'rol' => 'transportista',
        ]);

        DB::table('users')->insert([
            'name' => 'transportista2',
            'email' => 'transportista2@gmail.com',
            'password' => Hash::make('transportista2'),
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
