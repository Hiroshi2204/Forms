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
    }
}
