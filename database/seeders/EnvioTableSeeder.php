<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            [
                'cliente_id' => '2',
                'destinatario' => 'Juan González - Calle Mayor 1 1ºA, 50001 Zaragoza',
                'estado' => 'pendiente',
                'bultos' => 2,
                'kilos' => 14.6,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '2',
                'destinatario' => 'David Serrano - Calle San Valero 2, 50830 Villanueva de Gállego',
                'estado' => 'pendiente',
                'bultos' => 9,
                'kilos' => 46,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '2',
                'destinatario' => 'Ana Rodríguez - Calle San Juan Bosco 16, 50009 Zaragoza',
                'estado' => 'pendiente',
                'bultos' => 5,
                'kilos' => 22.8,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '3',
                'destinatario' => 'Luis Perez - Avenida de Cataluña 112 3ºC, 50014 Zaragoza',
                'estado' => 'pendiente',
                'bultos' => 1,
                'kilos' => 9,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '3',
                'destinatario' => 'Miguel Ángel Bueno - Calle de Pedro II 7, 50410 Cuarte de Huerva',
                'estado' => 'pendiente',
                'bultos' => 4,
                'kilos' => 80.70,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '3',
                'destinatario' => 'Olga Martínez - Calle de Huesca 31, 50180 Utebo',
                'estado' => 'pendiente',
                'bultos' => 2,
                'kilos' => 27.6,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '3',
                'destinatario' => 'Jorge García - Calle San Antonio 28, 50196 La Muela',
                'estado' => 'pendiente',
                'bultos' => 3,
                'kilos' => 320.1,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '2',
                'destinatario' => 'María López - Av. Goya 45, 50005 Zaragoza',
                'estado' => 'pendiente',
                'bultos' => 2,
                'kilos' => 284.26,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '2',
                'destinatario' => 'Carlos Ruiz - C/ Mayor 12, 50003 Zaragoza',
                'estado' => 'pendiente',
                'bultos' => 1,
                'kilos' => 150.44,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '3',
                'destinatario' => 'Lucía Martínez - C/ Mayor 8, 50410 Cuarte de Huerva',
                'estado' => 'pendiente',
                'bultos' => 4,
                'kilos' => 160,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '3',
                'destinatario' => 'Antonio Pérez - C/ Constitución 21, 50180 Utebo',
                'estado' => 'pendiente',
                'bultos' => 3,
                'kilos' => 74.3,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '2',
                'destinatario' => 'Ana Torres - Av. Zaragoza 13, 50430 María de Huerva',
                'estado' => 'pendiente',
                'bultos' => 2,
                'kilos' => 210.8,
                'created_at' => Carbon::now(),
            ],
            [
                'cliente_id' => '2',
                'destinatario' => 'Jorge García - Calle San Antonio 28, 50196 La Muela',
                'estado' => 'pendiente',
                'bultos' => 3,
                'kilos' => 163.7,
                'created_at' => Carbon::now(),
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
