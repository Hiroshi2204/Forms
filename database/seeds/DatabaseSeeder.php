<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                $this->call(CargoOficinaseeder::class);
                $this->call(UserSeeder::class);
                $this->call(TipoTransparenciaSeeder::class);
                $this->call(TipoTransparenciaDetalleSeeder::class);
                $this->call(ClaseDocumentoSeeder::class);
        }
}
