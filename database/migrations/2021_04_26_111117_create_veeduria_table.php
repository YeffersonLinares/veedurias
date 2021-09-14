<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeeduriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('dinamico')->create('veeduria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tema',50)->nullable();
            $table->text('descripcion')->nullable();
            $table->foreignId('dep_id')->nullable()->constrained('departamentos')->onDelete('restrict');
            $table->foreignId('ciu_id')->nullable()->constrained('ciudades')->onDelete('restrict');
            $table->foreignId('tipo_id')->nullable()->constrained('tipo_veeduria')->onDelete('restrict');
            $table->string('direccion')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono',15)->nullable();
            $table->string('radicado_CNE')->nullable();
            $table->date('fecha_realizacion')->nullable();
            $table->integer('estado')->default(1); // 0: inactivo, 1: activo, 2: pendiente
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
        Schema::connection('dinamico')->dropIfExists('veeduria');
    }
}
