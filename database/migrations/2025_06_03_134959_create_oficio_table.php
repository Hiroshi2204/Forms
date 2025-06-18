<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficio', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->string('oficina_remitente')->nullable();
            $table->string('codigo')->nullable();
            //$table->date('fecha_ofi')->nullable();
            $table->date('fecha_envio')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('nombre_original_pdf')->nullable();
            $table->boolean('estado_publicacion')->default(false);
            $table->date('fecha_publicacion')->nullable();
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
        Schema::dropIfExists('oficio');
    }
}
