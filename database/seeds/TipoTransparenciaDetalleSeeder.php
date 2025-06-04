<?php

// namespace Database\Seeders;

use App\Models\TipoTransparenciaDetalle;
use Illuminate\Database\Seeder;

class TipoTransparenciaDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DECANALES",
            "tipo_transparencia_id"=>1
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE CONSEJO DE FACULTAD",
            "tipo_transparencia_id"=>1
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO DE FACULTAD",
            "tipo_transparencia_id"=>1
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO UNIVERSITARIO",
            "tipo_transparencia_id"=>2
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES RECTORALES",
            "tipo_transparencia_id"=>2
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE CONSEJO UNIVERSITARIO",
            "tipo_transparencia_id"=>2
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE ASAMBLEA UNIVERSITARIA",
            "tipo_transparencia_id"=>2
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DIRECTORALES",
            "tipo_transparencia_id"=>2
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES  DE ASAMBLEA UNIVERSITARIA",
            "tipo_transparencia_id"=>2
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"TARIFAS DE SERVICIOS",
            "tipo_transparencia_id"=>2
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE GRADOS",
            "tipo_transparencia_id"=>3
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES Y DICTAMENES DEL TRIBUNAL DE HONOR",
            "tipo_transparencia_id"=>4
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"INFORME ANUAL",
            "tipo_transparencia_id"=>5
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL COMITÉ ELECTORAL UNIVERSITARIO",
            "tipo_transparencia_id"=>6
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL CONSEJO DE ESCUELA DE POSGRADO",
            "tipo_transparencia_id"=>7
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE ESCUELA DE POSGRADO",
            "tipo_transparencia_id"=>7
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES VICERRECTORALES(VRI)",
            "tipo_transparencia_id"=>8
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL CONSEJO DE INVESTIGACIÓN(VRI)",
            "tipo_transparencia_id"=>8
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO DE INVESTIGACIÓN(VRI)",
            "tipo_transparencia_id"=>8
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"PROYECTOS DE INVESTIGACIÓN",
            "tipo_transparencia_id"=>8
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"RESOLUCIONES VICERRECTORALES(VRA)",
            "tipo_transparencia_id"=>9
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"EXPEDIENTES DEFENSORIA UNIVERSITARIA",
            "tipo_transparencia_id"=>10
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"EF-1 ESTADO DE SITUACIÓN FINANCIERA",
            "tipo_transparencia_id"=>11
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"EF-2 ESTADO DE GESTIÓN",
            "tipo_transparencia_id"=>11
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"EF-3 ESTADO DE CAMBIO EN EL PATRIMONIO NETO",
            "tipo_transparencia_id"=>11
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"EF-4 ESTADO DE FLUJO EFECTIVO",
            "tipo_transparencia_id"=>11
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"EP-1 ESTADO DE EJECUCIÓN DEL PRESUPUESTO DE INGRESOS Y GASTOS",
            "tipo_transparencia_id"=>11
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"PP-1 PRESUPUESTO INSTITUCIONAL DE INGRESOS",
            "tipo_transparencia_id"=>11
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"PP-2 PRESUPUESTO INSTITUCIONAL DE GASTOS",
            "tipo_transparencia_id"=>11
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"SALDO DE BALANCE",
            "tipo_transparencia_id"=>11
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"PROYECTOS Y ACTIVIDADES",
            "tipo_transparencia_id"=>12
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"REPORTE DE SEGUIMIENTO DEL PLAN OPERATIVO INSTITUCIONAL (AÑO)",
            "tipo_transparencia_id"=>13
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"PLAN OPERATIVO INSTITUCIONAL (AÑO)",
            "tipo_transparencia_id"=>13
        ]);
        TipoTransparenciaDetalle::firstOrcreate([
            "nombre"=>"PLAN OPERATIVO INSTITUCIONAL MULTIANUAL(AÑO  - AÑO)",
            "tipo_transparencia_id"=>13
        ]);
    }
}
