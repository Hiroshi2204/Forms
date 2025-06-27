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
        $d1 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES DECANALES",
            "nomenclatura"=>"RD",
            "tipo_transparencia_id"=>1,
        ]);

        $d2 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE CONSEJO DE FACULTAD",
            "nomenclatura"=>"CF",
            "tipo_transparencia_id"=>1,
        ]);

        $d3 = ClaseDocumento::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO DE FACULTAD",
            "nomenclatura"=>"ACF",
            "tipo_transparencia_id"=>1,
        ]);

        $d4 = ClaseDocumento::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO UNIVERSITARIO",
            "nomenclatura"=>"ACU",
            "tipo_transparencia_id"=>2,
        ]);

        $d5 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES RECTORALES",
            "nomenclatura"=>"RR",
            "tipo_transparencia_id"=>2,
        ]);

        $d6 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE CONSEJO UNIVERSITARIO",
            "nomenclatura"=>"CU",
            "tipo_transparencia_id"=>2,
        ]);

        $d7 = ClaseDocumento::firstOrcreate([
            "nombre"=>"ACTAS DE ASAMBLEA UNIVERSITARIA",
            "nomenclatura"=>"AAU",
            "tipo_transparencia_id"=>2,
        ]);

        $d8 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES DIRECTORALES",
            "nomenclatura"=>"D",
            "tipo_transparencia_id"=>2,
        ]);

        $d9 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES  DE ASAMBLEA UNIVERSITARIA",
            "nomenclatura"=>"AU",
            "tipo_transparencia_id"=>2,
        ]);

        $d10 = ClaseDocumento::firstOrcreate([
            "nombre"=>"TARIFAS DE SERVICIOS",
            "nomenclatura"=>"TS",
            "tipo_transparencia_id"=>2,
        ]);

        $d11 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES DE GRADOS",
            "nomenclatura"=>"G",
            "tipo_transparencia_id"=>3,
        ]);

        $d12 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES Y DICTAMENES DEL TRIBUNAL DE HONOR",
            "nomenclatura"=>"DTH",
            "tipo_transparencia_id"=>4,
        ]);

        $d13 = ClaseDocumento::firstOrcreate([
            "nombre"=>"INFORME ANUAL",
            "nomenclatura"=>"IA",
            "tipo_transparencia_id"=>5,
        ]);

        $d14 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL COMITÉ ELECTORAL UNIVERSITARIO",
            "nomenclatura"=>"CEU",
            "tipo_transparencia_id"=>6,
        ]);

        $d15 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL CONSEJO DE ESCUELA DE POSGRADO",
            "nomenclatura"=>"CEP",
            "tipo_transparencia_id"=>7,
        ]);

        $d16 = ClaseDocumento::firstOrcreate([
            "nombre"=>"ACTAS DE ESCUELA DE POSGRADO",
            "nomenclatura"=>"AEP",
            "tipo_transparencia_id"=>7,
        ]);

        $d17 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES VICERRECTORALES(VRI)",
            "nomenclatura"=>"VRI",
            "tipo_transparencia_id"=>8,
        ]);

        $d18 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES DEL CONSEJO DE INVESTIGACIÓN(VRI)",
            "nomenclatura"=>"VCI",
            "tipo_transparencia_id"=>8,
        ]);

        $d19 = ClaseDocumento::firstOrcreate([
            "nombre"=>"ACTAS DE CONSEJO DE INVESTIGACIÓN(VRI)",
            "nomenclatura"=>"ACI",
            "tipo_transparencia_id"=>8,
        ]);

        $d20 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PROYECTOS DE INVESTIGACIÓN",
            "nomenclatura"=>"PI",
            "tipo_transparencia_id"=>8,
        ]);

        $d21 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESOLUCIONES VICERRECTORALES(VRA)",
            "nomenclatura"=>"VRA",
            "tipo_transparencia_id"=>9,
        ]);

        $d22 = ClaseDocumento::firstOrcreate([
            "nombre"=>"EXPEDIENTES DEFENSORIA UNIVERSITARIA",
            "nomenclatura"=>"EDU",
            "tipo_transparencia_id"=>10,
        ]);

        $d23 = ClaseDocumento::firstOrcreate([
            "nombre"=>"EF-1 ESTADO DE SITUACIÓN FINANCIERA",
            "nomenclatura"=>"EF-1",
            "tipo_transparencia_id"=>11,
        ]);

        $d24 = ClaseDocumento::firstOrcreate([
            "nombre"=>"EF-2 ESTADO DE GESTIÓN",
            "nomenclatura"=>"EF-2",
            "tipo_transparencia_id"=>11,
        ]);

        $d25 = ClaseDocumento::firstOrcreate([
            "nombre"=>"EF-3 ESTADO DE CAMBIO EN EL PATRIMONIO NETO",
            "nomenclatura"=>"EF-3",
            "tipo_transparencia_id"=>11,
        ]);

        $d26 = ClaseDocumento::firstOrcreate([
            "nombre"=>"EF-4 ESTADO DE FLUJO EFECTIVO",
            "nomenclatura"=>"EF-4",
            "tipo_transparencia_id"=>11,
        ]);

        $d27 = ClaseDocumento::firstOrcreate([
            "nombre"=>"EP-1 ESTADO DE EJECUCIÓN DEL PRESUPUESTO DE INGRESOS Y GASTOS",
            "nomenclatura"=>"EP-1",
            "tipo_transparencia_id"=>11,
        ]);

        $d28 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PP-1 PRESUPUESTO INSTITUCIONAL DE INGRESOS",
            "nomenclatura"=>"PP-1",
            "tipo_transparencia_id"=>11,
        ]);

        $d29 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PP-2 PRESUPUESTO INSTITUCIONAL DE GASTOS",
            "nomenclatura"=>"PP-2",
            "tipo_transparencia_id"=>11,
        ]);

        $d30 = ClaseDocumento::firstOrcreate([
            "nombre"=>"SALDO DE BALANCE",
            "nomenclatura"=>"SB",
            "tipo_transparencia_id"=>11,
        ]);

        $d31 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PROYECTOS Y ACTIVIDADES",
            "nomenclatura"=>"PA",
            "tipo_transparencia_id"=>12,
        ]);

        $d32 = ClaseDocumento::firstOrcreate([
            "nombre"=>"REPORTE DE SEGUIMIENTO DEL PLAN OPERATIVO INSTITUCIONAL (AÑO)",
            "nomenclatura"=>"RPOI",
            "tipo_transparencia_id"=>13,
        ]);

        $d33 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PLAN OPERATIVO INSTITUCIONAL (AÑO)",
            "nomenclatura"=>"POI",
            "tipo_transparencia_id"=>13,
        ]);

        $d34 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PLAN OPERATIVO INSTITUCIONAL MULTIANUAL(AÑO  - AÑO)",
            "nomenclatura"=>"POIM",
            "tipo_transparencia_id"=>13,
        ]);
        $d35 = ClaseDocumento::firstOrcreate([
            "nombre"=>"GRUPO GENERICO 1 PERSONAL Y OBLIGACIONES SOCIALES",
            "nomenclatura"=>"GG1",
            "tipo_transparencia_id"=>13,
        ]);
        $d36 = ClaseDocumento::firstOrcreate([
            "nombre"=>"GRUPO GENERICO 2 OBLIGACIONES PREVISIONALES",
            "nomenclatura"=>"GG2",
            "tipo_transparencia_id"=>13,
        ]);
        $d37 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PRIMER TRIMESTRE DEL GASTO CAS",
            "nomenclatura"=>"PTGC",
            "tipo_transparencia_id"=>13,
        ]);
        $d38 = ClaseDocumento::firstOrcreate([
            "nombre"=>"SEGUNDO TRIMESTRE DEL GASTO CAS",
            "nomenclatura"=>"STGC",
            "tipo_transparencia_id"=>13,
        ]);
        $d39 = ClaseDocumento::firstOrcreate([
            "nombre"=>"TERCER TRIMESTRE DEL GASTO CAS",
            "nomenclatura"=>"TTGC",
            "tipo_transparencia_id"=>13,
        ]);
        $d40 = ClaseDocumento::firstOrcreate([
            "nombre"=>"CUARTO TRIMESTRE DEL GASTO CAS",
            "nomenclatura"=>"CTGC",
            "tipo_transparencia_id"=>13,
        ]);
        $d41 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RELACION DEL PERSONAL ADMINISTRATIVO DEL REGIMEN 276",
            "nomenclatura"=>"RPR276",
            "tipo_transparencia_id"=>13,
        ]);
        $d42 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RELACION DEL PERSONAL DOCENTE PERMANENTE Y CONTRATADO",
            "nomenclatura"=>"RPD",
            "tipo_transparencia_id"=>13,
        ]);
        $d43 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RELACION DEL PERSONAL CAS",
            "nomenclatura"=>"RPCAS",
            "tipo_transparencia_id"=>13,
        ]);
        $d44 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RELACION DE AUTORIDADES, DIRECTORES Y JEFES DE UNI. ORG.",
            "nomenclatura"=>"RADJ",
            "tipo_transparencia_id"=>13,
        ]);
        $d45 = ClaseDocumento::firstOrcreate([
            "nombre"=>"AUTORIDADES DE ALTA DIRECCION D.L 30057",
            "nomenclatura"=>"AD30057",
            "tipo_transparencia_id"=>13,
        ]);
        $d46 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RELACION DE CESANTES ADMINISTRATIVOS Y DOCENTES",
            "nomenclatura"=>"RCAD",
            "tipo_transparencia_id"=>13,
        ]);
        $d47 = ClaseDocumento::firstOrcreate([
            "nombre"=>"NUMERO DE PERSONAL ADMINISTRATIVO POR GRUPO OCUPACIONAL",
            "nomenclatura"=>"NPA",
            "tipo_transparencia_id"=>13,
        ]);
        $d48 = ClaseDocumento::firstOrcreate([
            "nombre"=>"NUMERO DE PERSONAL DOCENTE POR CATEGORIA",
            "nomenclatura"=>"NPDC",
            "tipo_transparencia_id"=>13,
        ]);
        $d49 = ClaseDocumento::firstOrcreate([
            "nombre"=>"ESCALA PROMEDIO DE REMUNERACIÓN POR CATEGORÍA DEL PERSONAL ADMINISTRATIVO",
            "nomenclatura"=>"PRPA",
            "tipo_transparencia_id"=>13,
        ]);
        $d50 = ClaseDocumento::firstOrcreate([
            "nombre"=>"ESCALA PROMEDIO DE REMUNERACIÓN POR CATEGORÍA DEL PERSONAL DOCENTE",
            "nomenclatura"=>"PRPD",
            "tipo_transparencia_id"=>13,
        ]);
        $d51 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESUMEN DE GASTOS DE RETRIBUCIONES DE PERSONAL CAS",
            "nomenclatura"=>"RGCAS",
            "tipo_transparencia_id"=>13,
        ]);
        $d52 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESUMEN DE GASTO DEL PERSONAL DOCENTE Y ADMINISTRATIVO",
            "nomenclatura"=>"RGDA",
            "tipo_transparencia_id"=>13,
        ]);
        $d53 = ClaseDocumento::firstOrcreate([
            "nombre"=>"RESUMEN DEL GASTO DE PENSIONES DEL PERSONAL CESANTE DOCENTE Y ADMINISTRATIVO",
            "nomenclatura"=>"RGPCDA",
            "tipo_transparencia_id"=>13,
        ]);
        $d54 = ClaseDocumento::firstOrcreate([
            "nombre"=>"BECA DE ALIMENTOS",
            "nomenclatura"=>"BA",
            "tipo_transparencia_id"=>13,
        ]);
        $d55 = ClaseDocumento::firstOrcreate([
            "nombre"=>"BECA PRONABEC",
            "nomenclatura"=>"BP",
            "tipo_transparencia_id"=>13,
        ]);
        $d56 = ClaseDocumento::firstOrcreate([
            "nombre"=>"ORDEN DE SERVICIO",
            "nomenclatura"=>"OS",
            "tipo_transparencia_id"=>13,
        ]);
        $d57 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PENALIDADES",
            "nomenclatura"=>"P",
            "tipo_transparencia_id"=>13,
        ]);
        $d58 = ClaseDocumento::firstOrcreate([
            "nombre"=>"COMITE DE SELECCION",
            "nomenclatura"=>"CS",
            "tipo_transparencia_id"=>13,
        ]);
        $d59 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PLAN ANUAL DE CONTRATOS",
            "nomenclatura"=>"PAC",
            "tipo_transparencia_id"=>13,
        ]);
        $d60 = ClaseDocumento::firstOrcreate([
            "nombre"=>"PROCESO DE SELECCION",
            "nomenclatura"=>"PS",
            "tipo_transparencia_id"=>13,
        ]);
    }
}
