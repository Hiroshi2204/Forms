<?php

// namespace Database\Seeders;

use App\Models\CargoOficina;
use Illuminate\Database\Seeder;

class CargoOficinaseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CargoOficina::firstOrcreate([
            "carg_nombre"=>"Jefe General",
            "responsable"=>"Pepito"
        ]);

        CargoOficina::firstOrcreate([
            "carg_nombre"=>"Administrador",
            "responsable"=>"Juan"
        ]);

        CargoOficina::firstOrcreate([
            "carg_nombre"=>"Líder",
            "responsable"=>"Pedro"
        ]);
    }
}
