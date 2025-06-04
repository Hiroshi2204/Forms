<?php

use ColorSeeder as GlobalColorSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\ProductoSeeder;
use Illuminate\Database\Seeder;
use ProductoSeeder as GlobalProductoSeeder;
use TipoRolSeeder as GlobalTipoRolSeeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                $this->call(UserSeeder::class);
                $this->call(TipoDocumentoSeeder::class);
                $this->call(RolSeeder::class);
                $this->call(GlobalTipoRolSeeder::class);
        }
}
