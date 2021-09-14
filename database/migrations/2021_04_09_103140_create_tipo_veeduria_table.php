<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoVeeduriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('dinamico')->create('tipo_veeduria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_registro');
            $table->bigInteger('usuario_creador');
            $table->tinyInteger('estado');
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
        Schema::connection('dinamico')->dropIfExists('tipo_veeduria');
    }
}
