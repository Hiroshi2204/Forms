<?php

// namespace Database\Seeders;

use App\Models\ClaseDocumento;
use Illuminate\Database\Seeder;

class ClaseDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClaseDocumento::firstOrcreate([
            "nombre"=>"Actas de Consejo Universitario",
            "nomenclatura"=>"ACU",
            "tipo_transparencia_id"=>2
        ]);

        ClaseDocumento::firstOrcreate([
            "nombre"=>"Resoluciones Rectorales",
            "nomenclatura"=>"R",
            "tipo_transparencia_id"=>2
        ]);

        ClaseDocumento::firstOrcreate([
            "nombre"=>"Resoluciones de Consejo Universitario",
            "nomenclatura"=>"CU",
            "tipo_transparencia_id"=>2
        ]);

        ClaseDocumento::firstOrcreate([
            "nombre"=>"Resoluciones de Vice Rectorado Academico",
            "nomenclatura"=>"VRA",
            "tipo_transparencia_id"=>9
        ]);
    }
}
