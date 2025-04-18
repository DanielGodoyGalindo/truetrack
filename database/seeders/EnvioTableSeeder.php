<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnvioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
        DB::table('envios')->insert([
            'cliente_id' => '2',
            'destinatario' => 'Juan González - Calle Mayor 1 1ºA, 50001 Zaragoza',
            'estado' => 'pendiente',
            'bultos' => 2,
            'kilos' => 14.6,
        ]);

        DB::table('envios')->insert([
            'cliente_id' => '2',
            'destinatario' => 'David Serrano - Calle San Valero 2, 50830 Villanueva de Gállego',
            'estado' => 'pendiente',
            'bultos' => 9,
            'kilos' => 46,
        ]);

        DB::table('envios')->insert([
            'cliente_id' => '2',
            'destinatario' => 'Ana Rodríguez - Calle San Juan Bosco 16, 50009 Zaragoza',
            'estado' => 'pendiente',
            'bultos' => 5,
            'kilos' => 22.8,
        ]);

        DB::table('envios')->insert([
            'cliente_id' => '3',
            'destinatario' => 'Luis Perez - Avenida de Cataluña 112 3ºC, 50014 Zaragoza',
            'estado' => 'pendiente',
            'bultos' => 1,
            'kilos' => 9,
        ]);

        DB::table('envios')->insert([
            'cliente_id' => '3',
            'destinatario' => 'Miguel Ángel Bueno - Calle de Pedro II 7, 50410 Cuarte de Huerva',
            'estado' => 'pendiente',
            'bultos' => 4,
            'kilos' => 80.70,
        ]);

        DB::table('envios')->insert([
            'cliente_id' => '3',
            'destinatario' => 'Olga Martínez - Calle de Huesca 31, 50180 Utebo',
            'estado' => 'pendiente',
            'bultos' => 2,
            'kilos' => 27.6,
        ]);

        DB::table('envios')->insert([
            'cliente_id' => '3',
            'destinatario' => 'Jorge García - Calle San Antonio 28, 50196 La Muela',
            'estado' => 'pendiente',
            'bultos' => 3,
            'kilos' => 750,
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
    }
}
