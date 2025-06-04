<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransparenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transparencia', function (Blueprint $table) {
            $table->id();
            $table->string('num_documento')->nullable();
            $table->string('asunto')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->string('pdf_path')->nullable(); //ruta de archivo pdf
            $table->string('nombre_original')->nullable();
            $table->longText('contenido_pdf')->nullable();
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
        Schema::dropIfExists('transparencia');
    }
}
