<?php

namespace Database\Seeders;

use App\Models\Serie;
use Illuminate\Database\Seeder;

class SerieSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serie = new Serie();
        $serie->id = 1;
        $serie->num_serie = 1;
        $serie->nombre = 'Turri prueba';
        $serie->estado = 1;
        $serie->save();
    }
}
