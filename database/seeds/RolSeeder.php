<?php

// namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::firstOrcreate([
            "rol"=>"ADMIN",
            "fecha"=> "09/06/2025",
        ]);

        Rol::firstOrcreate([
            "rol"=>"USUARIO",
            "fecha"=> "09/06/2025",
        ]);
    }
}
