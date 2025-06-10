<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficinaDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficina_documento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oficina_id')->nullable()->references('id')->on('oficina');
            $table->foreignId('clase_documento_id')->nullable()->references('id')->on('clase_documento');
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
        Schema::dropIfExists('oficina_documento');
    }
}
