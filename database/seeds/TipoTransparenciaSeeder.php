<?php

// namespace Database\Seeders;

use App\Models\TipoTransparencia;
use Illuminate\Database\Seeder;

class TipoTransparenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoTransparencia::firstOrcreate([
            "nombre"=>"FACULTADES"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"SECRETARIA GENERAL"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"UNIDAD DE GRADOS Y TITULOS"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"TRIBUNAL DE HONOR"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"COMISIÓN PERMANENTE DE FISCALIZACIÓN"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"COMITÉ ELECTORAL UNIVERSITARIO"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"ESCUELA DE POSGRADO"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"VICERECTORADO DE INVESTIGACIÓN (VRI)"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"VICERECTORADO ACADÉMICO (VRA)"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"DEFENSORÍA UNIVERSITARIA (ODU)"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"UNIDAD DE CONTABILIDAD"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"UNIDAD EJECUTORA DE INVERSIONES"
        ]);
        TipoTransparencia::firstOrcreate([
            "nombre"=>"OFICINA DE PLANEAMIENTO Y PRESUPUESTO"
        ]);
    }
}
