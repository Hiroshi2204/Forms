<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoTransparenciaDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_transparencia_detalle', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->foreignId('tipo_transparencia_id')->nullable()->references('id')->on('tipo_transparencia');
            $table->char('estado_registro')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_transparencia_detalle');
    }
}
