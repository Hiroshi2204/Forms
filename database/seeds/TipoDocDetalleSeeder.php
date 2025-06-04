<?php

// namespace Database\Seeders;

use App\Models\TipoDocDetalle;
use Illuminate\Database\Seeder;

class TipoDocDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DECANALES",
            "tipo_doc_id"=>1
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE CONSEJO DE FACULTAD",
            "tipo_doc_id"=>1
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO DE FACULTAD",
            "tipo_doc_id"=>1
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO UNIVERSITARIO",
            "tipo_doc_id"=>2
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES RECTORALES",
            "tipo_doc_id"=>2
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE CONSEJO UNIVERSITARIO",
            "tipo_doc_id"=>2
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE ASAMBLEA UNIVERSITARIA",
            "tipo_doc_id"=>2
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DIRECTORALES",
            "tipo_doc_id"=>2
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES  DE ASAMBLEA UNIVERSITARIA",
            "tipo_doc_id"=>2
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"TARIFAS DE SERVICIOS",
            "tipo_doc_id"=>2
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE GRADOS",
            "tipo_doc_id"=>3
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES Y DICTAMENES DEL TRIBUNAL DE HONOR",
            "tipo_doc_id"=>4
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"INFORME ANUAL",
            "tipo_doc_id"=>5
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL COMITÉ ELECTORAL UNIVERSITARIO",
            "tipo_doc_id"=>6
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL CONSEJO DE ESCUELA DE POSGRADO",
            "tipo_doc_id"=>7
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE ESCUELA DE POSGRADO",
            "tipo_doc_id"=>7
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES VICERRECTORALES(VRI)",
            "tipo_doc_id"=>8
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL CONSEJO DE INVESTIGACIÓN(VRI)",
            "tipo_doc_id"=>8
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO DE INVESTIGACIÓN(VRI)",
            "tipo_doc_id"=>8
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"PROYECTOS DE INVESTIGACIÓN",
            "tipo_doc_id"=>8
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES VICERRECTORALES(VRA)",
            "tipo_doc_id"=>9
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"EXPEDIENTES DEFENSORIA UNIVERSITARIA",
            "tipo_doc_id"=>10
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"EF-1 ESTADO DE SITUACIÓN FINANCIERA",
            "tipo_doc_id"=>11
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"EF-2 ESTADO DE GESTIÓN",
            "tipo_doc_id"=>11
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"EF-3 ESTADO DE CAMBIO EN EL PATRIMONIO NETO",
            "tipo_doc_id"=>11
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"EF-4 ESTADO DE FLUJO EFECTIVO",
            "tipo_doc_id"=>11
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"EP-1 ESTADO DE EJECUCIÓN DEL PRESUPUESTO DE INGRESOS Y GASTOS",
            "tipo_doc_id"=>11
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"PP-1 PRESUPUESTO INSTITUCIONAL DE INGRESOS",
            "tipo_doc_id"=>11
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"PP-2 PRESUPUESTO INSTITUCIONAL DE GASTOS",
            "tipo_doc_id"=>11
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"SALDO DE BALANCE",
            "tipo_doc_id"=>11
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"PROYECTOS Y ACTIVIDADES",
            "tipo_doc_id"=>12
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"REPORTE DE SEGUIMIENTO DEL PLAN OPERATIVO INSTITUCIONAL (AÑO)",
            "tipo_doc_id"=>13
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"PLAN OPERATIVO INSTITUCIONAL (AÑO)",
            "tipo_doc_id"=>13
        ]);
        TipoDocDetalle::firstOrcreate([
            "nombre"=>"PLAN OPERATIVO INSTITUCIONAL MULTIANUAL(AÑO  - AÑO)",
            "tipo_doc_id"=>13
        ]);
    }
}
