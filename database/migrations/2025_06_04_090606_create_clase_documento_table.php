<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaseDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clase_documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('nomenclatura')->nullable();
            $table->foreignId('tipo_transparencia_id')->nullable()->references('id')->on('tipo_transparencia');
            $table->foreignId('oficina_id')->nullable()->references('id')->on('oficina');
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
        Schema::dropIfExists('clase_documento');
    }
}
