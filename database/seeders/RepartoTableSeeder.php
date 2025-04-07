<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepartoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('repartos')->insert([
            'gestor_id' => 4,
            'transportista_id' => 6,
            'vehiculo_id' => 1,
            'estado' => 'en proceso',
        ]);
        DB::table('repartos')->insert([
            'gestor_id' => 4,
            'transportista_id' => 6,
            'vehiculo_id' => 2,
            'estado' => 'en proceso',
        ]);
        DB::table('repartos')->insert([
            'gestor_id' => 5,
            'transportista_id' => 6,
            'vehiculo_id' => 1,
            'estado' => 'en proceso',
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
