<?php

namespace Database\Seeders;

use App\Models\Subserie;
use Illuminate\Database\Seeder;

class SubSerieSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subserie = new Subserie();
        $subserie->id = 1;
        $subserie->id_serie = 1;
        $subserie->num_subserie = 1243;
        $subserie->nombre = 'turri prueba';
        $subserie->estado = 1;
        $subserie->save();
    }
}
