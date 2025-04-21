<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiculoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehiculos')->insert([
            'matricula' => '1234FFF',
            'carga_max' => '800',
        ]);

        DB::table('vehiculos')->insert([
            'matricula' => '4444HHH',
            'carga_max' => '500',
        ]);
    }
}
