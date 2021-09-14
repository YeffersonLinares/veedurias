<?php

namespace App\Http\Controllers;

use App\Models\Veeduria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function excelVeeduria(Request $request)
    {
        // return $request->all();
        $post = $request;
        $veeduria = $this->tabla($post);
        // return $veeduria;
        return view('report.veeduria')->with('veeduria', $veeduria);
    }

    public function tabla($post)
    {
        $veeduria = $veeduria = Veeduria::where('estado', 1)
            ->where('veeduria.estado', 1)
            ->where(function ($query) use ($post) {
                if (isset($post['tema'])) {
                    if (!empty($post['tema']))
                        $query->orwhere('veeduria.nombre_tema', 'like', "%" . $post['tema'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['descripcion'])) {
                    if (!empty($post['descripcion']))
                        $query->orwhere('veeduria.descripcion', 'like', "%" . $post['descripcion'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['departamento'])) {
                    if (!empty($post['departamento']))

                        $query->orwhere('veeduria.dep_id', $post['departamento']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['tipo_veeduria'])) {
                    if (!empty($post['tipo_veeduria']))

                        $query->orwhere('veeduria.tipo_id', $post['tipo_veeduria']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['municipio'])) {
                    if (!empty($post['municipio']))

                        $query->orwhere('veeduria.ciu_id', $post['municipio']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['estado'])) {
                    if (!empty($post['estado']))

                        $query->orwhere('veeduria.estado', $post['estado']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha'])) {
                    if (!empty($post['fecha']))
                        $query->orwhere('veeduria.fecha_realizacion', 'like', "%" . $post['fecha'] . "%");
                }
            })->get();
        $filtros = [];
        $x = 0;
        foreach ($veeduria as $row) {
            if (is_null($post->fecha_desde) && is_null($post->fecha_hasta)) {
                $filtros[$x] = $row;
                $x++;
            }
            if (is_null($post->fecha_desde) && !is_null($post->fecha_hasta)) {
                if ($post->fecha_hasta >= $row->fecha_realizacion) {
                    $filtros[$x] = $row;
                    $x++;
                }
            }
            if (!is_null($post->fecha_desde) && is_null($post->fecha_hasta)) {
                if ($post->fecha_desde <= $row->fecha_realizacion) {
                    $filtros[$x] = $row;
                    $x++;
                }
            }
            if (!is_null($post->fecha_desde) && !is_null($post->fecha_desde)) {
                if ($post->fecha_desde <= $row->fecha_realizacion && $post->fecha_hasta >= $row->fecha_realizacion) {
                    $filtros[$x] = $row;
                    $x++;
                }
            }
        }
        $veeduria = $filtros;
        return $veeduria;
    }
}
