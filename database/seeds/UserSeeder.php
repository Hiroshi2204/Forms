<?php

use App\Models\Oficina;
use App\Models\Persona;
use App\Models\UserRol;
use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Oficina::firstOrCreate(
            [
                "nombre" => "ADMIN",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user->id,
                "username" => "admin",
                "rol_id" => 1,

            ],
            [
                "password" => "admin123",
            ]
        );
        //------------------------------------------------
        $user1 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ciencias administrativas",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user1->id,
                "username" => "fca",
                "rol_id" => 2,

            ],
            [
                "password" => "fca123",
            ]
        );
        //------------------------------------------------
        $user2 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ciencias contables",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user2->id,
                "username" => "fcc",
                "rol_id" => 2,

            ],
            [
                "password" => "fcc123",
            ]
        );
        //------------------------------------------------
        $user3 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ciencias económicas",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user3->id,
                "username" => "fce",
                "rol_id" => 2,

            ],
            [
                "password" => "fce123",
            ]
        );
        //------------------------------------------------
        $user4 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ciencias naturales y matemáticas",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user4->id,
                "username" => "fcnm",
                "rol_id" => 2,

            ],
            [
                "password" => "fcnm123",
            ]
        );
        //------------------------------------------------
        $user5 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ciencias de la salud",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user5->id,
                "username" => "fcs",
                "rol_id" => 2,

            ],
            [
                "password" => "fcs123",
            ]
        );
        //------------------------------------------------
        $user6 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ingeniería ambiental y recursos naturales",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user6->id,
                "username" => "fiarn",
                "rol_id" => 2,

            ],
            [
                "password" => "fiarn123",
            ]
        );
        //------------------------------------------------
        $user7 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ingeniería eléctrica y electrónica",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user7->id,
                "username" => "fiee",
                "rol_id" => 2,

            ],
            [
                "password" => "fiee123",
            ]
        );
        //------------------------------------------------
        $user8 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ingeniería industrial y de sistemas",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user8->id,
                "username" => "fiis",
                "rol_id" => 2,

            ],
            [
                "password" => "fiis123",
            ]
        );
        //------------------------------------------------
        $user9 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ingeniería mecánica y energía",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user9->id,
                "username" => "fime",
                "rol_id" => 2,

            ],
            [
                "password" => "fime123",
            ]
        );
        //------------------------------------------------
        $user10 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ingeniería pesquera y alimentos",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user10->id,
                "username" => "fipa",
                "rol_id" => 2,

            ],
            [
                "password" => "fipa123",
            ]
        );
        //------------------------------------------------
        $user11 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ingeniería química",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user11->id,
                "username" => "fiq",
                "rol_id" => 2,

            ],
            [
                "password" => "fiq123",
            ]
        );
        //------------------------------------------------
        $user12 = Oficina::firstOrCreate(
            [
                "nombre" => "Facultad de ciencias de la educación",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user12->id,
                "username" => "fced",
                "rol_id" => 2,

            ],
            [
                "password" => "fced123",
            ]
        );
        //------------------------------------------------
        $user13 = Oficina::firstOrCreate(
            [
                "nombre" => "Secretaría General",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user13->id,
                "username" => "secretaria",
                "rol_id" => 2,

            ],
            [
                "password" => "secretaria123",
            ]
        );
        //------------------------------------------------
        $user14 = Oficina::firstOrCreate(
            [
                "nombre" => "Unidad de Grados y Titulos",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user14->id,
                "username" => "unidad",
                "rol_id" => 2,

            ],
            [
                "password" => "unidad123",
            ]
        );
        //------------------------------------------------
        $user15 = Oficina::firstOrCreate(
            [
                "nombre" => "Tribunal de Honor",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user15->id,
                "username" => "tribunal",
                "rol_id" => 2,

            ],
            [
                "password" => "tribunal123",
            ]
        );
        //------------------------------------------------
        $user16 = Oficina::firstOrCreate(
            [
                "nombre" => "Comision Permanente de Fiscalizacion",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user16->id,
                "username" => "comision",
                "rol_id" => 2,

            ],
            [
                "password" => "comision123",
            ]
        );
        //------------------------------------------------
        $user17 = Oficina::firstOrCreate(
            [
                "nombre" => "Comite Electoral Universitario",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user17->id,
                "username" => "comite",
                "rol_id" => 2,

            ],
            [
                "password" => "comite123",
            ]
        );
        //------------------------------------------------
        $user18 = Oficina::firstOrCreate(
            [
                "nombre" => "Escuela de Postgrado",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user18->id,
                "username" => "escuela",
                "rol_id" => 2,

            ],
            [
                "password" => "escuela123",
            ]
        );
        //------------------------------------------------
        $user19 = Oficina::firstOrCreate(
            [
                "nombre" => "Vice Rectorado de Investigación (VRI)",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user19->id,
                "username" => "vri",
                "rol_id" => 2,

            ],
            [
                "password" => "vri123",
            ]
        );
        //------------------------------------------------
        $user20 = Oficina::firstOrCreate(
            [
                "nombre" => "Vice Rectorado Academico (VRA)",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user20->id,
                "username" => "vra",
                "rol_id" => 2,

            ],
            [
                "password" => "vra123",
            ]
        );
        //------------------------------------------------
        $user21 = Oficina::firstOrCreate(
            [
                "nombre" => "Defensoria Universitaria (ODU)",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user21->id,
                "username" => "odu",
                "rol_id" => 2,

            ],
            [
                "password" => "odu123",
            ]
        );
        //------------------------------------------------
        $user22 = Oficina::firstOrCreate(
            [
                "nombre" => "Unidad de Contabilidad",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user22->id,
                "username" => "unidad1",
                "rol_id" => 2,

            ],
            [
                "password" => "unidad1234",
            ]
        );
        //------------------------------------------------
        $user23 = Oficina::firstOrCreate(
            [
                "nombre" => "Unidad Ejecutora de Inversiones",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user23->id,
                "username" => "unidad2",
                "rol_id" => 2,

            ],
            [
                "password" => "unidad12345",
            ]
        );
        //------------------------------------------------
        $user24 = Oficina::firstOrCreate(
            [
                "nombre" => "Oficina de Planeamiento y Presupuesto",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user24->id,
                "username" => "oficina",
                "rol_id" => 2,

            ],
            [
                "password" => "oficina123",
            ]
        );
        //------------------------------------------------
        $user25 = Oficina::firstOrCreate(
            [
                "nombre" => "Unidad de Recursos humanos",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user25->id,
                "username" => "urh",
                "rol_id" => 2,

            ],
            [
                "password" => "urh123",
            ]
        );
        //------------------------------------------------
        $user26 = Oficina::firstOrCreate(
            [
                "nombre" => "Bienestar Universitario (OBU)",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user26->id,
                "username" => "obu",
                "rol_id" => 2,

            ],
            [
                "password" => "obu123",
            ]
        );
        //------------------------------------------------
        $user27 = Oficina::firstOrCreate(
            [
                "nombre" => "Unidad de Abastecimiento",
                "cargo_oficina_id" => 1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id" => $user27->id,
                "username" => "ua",
                "rol_id" => 2,

            ],
            [
                "password" => "ua123",
            ]
        );
    }

    
}
