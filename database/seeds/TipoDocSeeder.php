<?php

// namespace Database\Seeders;

use App\Models\TipoDoc;
use Illuminate\Database\Seeder;

class TipoDocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDoc::firstOrcreate([
            "nombre"=>"FACULTADES"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"SECRETARIA GENERAL"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"UNIDAD DE GRADOS Y TITULOS"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"TRIBUNAL DE HONOR"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"COMISIÓN PERMANENTE DE FISCALIZACIÓN"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"COMITÉ ELECTORAL UNIVERSITARIO"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"ESCUELA DE POSGRADO"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"VICERECTORADO DE INVESTIGACIÓN (VRI)"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"VICERECTORADO ACADÉMICO (VRA)"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"DEFENSORÍA UNIVERSITARIA (ODU)"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"UNIDAD DE CONTABILIDAD"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"UNIDAD EJECUTORA DE INVERSIONES"
        ]);
        TipoDoc::firstOrcreate([
            "nombre"=>"OFICINA DE PLANEAMIENTO Y PRESUPUESTO"
        ]);
    }
}
