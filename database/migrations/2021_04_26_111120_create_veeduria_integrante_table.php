<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeeduriaIntegranteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('dinamico')->create('veeduria_integrante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_veeduria')->nullable()->constrained('veeduria')->onDelete('restrict');
            $table->foreignId('id_integrante')->nullable()->constrained('integrante')->onDelete('restrict');
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
        Schema::connection('dinamico')->dropIfExists('veeduria_integrante');
    }
}
