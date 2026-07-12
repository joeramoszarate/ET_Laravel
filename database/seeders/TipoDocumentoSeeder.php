<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipodocumento')->insert([
            ['id_tipdoc' => 'DNI', 'descripcion' => 'DNI'],
            ['id_tipdoc' => 'PAS', 'descripcion' => 'Pasaporte'],
            ['id_tipdoc' => 'CARR', 'descripcion' => 'Carnet'],
            ['id_tipdoc' => 'RUC', 'descripcion' => 'RUC'],
        ]);
    }
}
