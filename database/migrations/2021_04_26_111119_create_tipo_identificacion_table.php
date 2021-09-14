<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoIdentificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('dinamico')->create('tipo_identificacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50)->nullable();
            $table->integer('usuario_creador')->nullable();
            $table->integer('estado')->default(1); // 0: inactivo, 1: activo, 2: pendiente
            $table->date('fecha_registro')->nullable();
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
        Schema::connection('dinamico')->dropIfExists('tipo_identificaion');
    }
}
