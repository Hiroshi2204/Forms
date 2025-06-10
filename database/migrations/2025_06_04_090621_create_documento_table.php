<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('numero')->nullable();
            $table->string('anio')->nullable();
            $table->string('num_anio')->nullable();
            $table->longText('resumen')->nullable();
            $table->string('detalle')->nullable();
            $table->date('fecha_doc')->nullable();
            $table->date('fecha_envio')->nullable();
            $table->string('oficina_remitente')->nullable();
            $table->foreignId('oficina_id')->nullable()->references('id')->on('oficina');
            $table->foreignId('clase_documento_id')->nullable()->references('id')->on('clase_documento');
            $table->foreignId('oficio_id')->nullable()->references('id')->on('oficio');
            $table->string('pdf_path')->nullable();
            $table->string('nombre_original_pdf')->nullable();
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
        Schema::dropIfExists('documento');
    }
}
