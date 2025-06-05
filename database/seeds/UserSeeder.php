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
        $user1 = Oficina::firstOrCreate(
            [
                "nombre"=>"Facultades",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user1->id,
                "username"=>"facultades",

            ],
            [
                "password"=>"facultades123",
            ]
        );
        //------------------------------------------------
        $user2 = Oficina::firstOrCreate(
            [
                "nombre"=>"Secretaría General",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user2->id,
                "username"=>"secretario",

            ],
            [
                "password"=>"secretario123",
            ]
        );
        //------------------------------------------------
        $user3 = Oficina::firstOrCreate(
            [
                "nombre"=>"Unidad de Grados y Titulos",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user3->id,
                "username"=>"unidad",

            ],
            [
                "password"=>"unidad123",
            ]
        );
        //------------------------------------------------
        $user4 = Oficina::firstOrCreate(
            [
                "nombre"=>"Tribunal de Honor",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user4->id,
                "username"=>"tribunal",

            ],
            [
                "password"=>"tribunal123",
            ]
        );
        //------------------------------------------------
        $user5 = Oficina::firstOrCreate(
            [
                "nombre"=>"Comision Permanente de Fiscalizacion",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user5->id,
                "username"=>"comision",

            ],
            [
                "password"=>"comision123",
            ]
        );
        //------------------------------------------------
        $user6 = Oficina::firstOrCreate(
            [
                "nombre"=>"Comite Electoral Universitario",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user6->id,
                "username"=>"comite",

            ],
            [
                "password"=>"comite123",
            ]
        );
        //------------------------------------------------
        $user7 = Oficina::firstOrCreate(
            [
                "nombre"=>"Escuela de Postgrado",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user7->id,
                "username"=>"escuela",

            ],
            [
                "password"=>"escuela123",
            ]
        );
        //------------------------------------------------
        $user8 = Oficina::firstOrCreate(
            [
                "nombre"=>"Vice Rectorado de Investigación (VRI)",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user8->id,
                "username"=>"vri",

            ],
            [
                "password"=>"vri123",
            ]
        );
        //------------------------------------------------
        $user9 = Oficina::firstOrCreate(
            [
                "nombre"=>"Vice Rectorado Academico (VRA)",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user9->id,
                "username"=>"vra",

            ],
            [
                "password"=>"vra123",
            ]
        );
        //------------------------------------------------
        $user10 = Oficina::firstOrCreate(
            [
                "nombre"=>"Defensoria Universitaria (ODU)",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user10->id,
                "username"=>"odu",

            ],
            [
                "password"=>"odu123",
            ]
        );
        //------------------------------------------------
        $user11 = Oficina::firstOrCreate(
            [
                "nombre"=>"Unidad de Contabilidad",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user11->id,
                "username"=>"unidad1",

            ],
            [
                "password"=>"unidad1234",
            ]
        );
        //------------------------------------------------
        $user12 = Oficina::firstOrCreate(
            [
                "nombre"=>"Unidad Ejecutora de Inversiones",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user12->id,
                "username"=>"unidad2",

            ],
            [
                "password"=>"unidad12345",
            ]
        );
        //------------------------------------------------
        $user13 = Oficina::firstOrCreate(
            [
                "nombre"=>"Oficina de Planeamiento y Presupuesto",
                "cargo_oficina_id"=>1
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "oficina_id"=>$user13->id,
                "username"=>"oficina",

            ],
            [
                "password"=>"oficina123",
            ]
        );
    }
}
