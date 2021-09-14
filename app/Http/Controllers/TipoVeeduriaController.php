<?php

namespace App\Http\Controllers;

use App\Models\TipoVeeduria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoVeeduriaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = TipoVeeduria::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = TipoVeeduria::where($criterio, 'like', '%' . $buscar . '%')
                ->orderBy('id', 'desc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $departamentos->total(),
                'current_page' => $departamentos->currentPage(),
                'per_page'     => $departamentos->perPage(),
                'last_page'    => $departamentos->lastPage(),
                'from'         => $departamentos->firstItem(),
                'to'           => $departamentos->lastItem(),
            ],
            'departamentos' => $departamentos
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = new TipoVeeduria();
        $departamento->nombre = $request->nombre;
        $departamento->fecha_registro = date('Y-m-d');
        $departamento->usuario_creador = Auth::user()->id_persona;
        $departamento->estado = '1';
        $departamento->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = TipoVeeduria::findOrFail($request->id);
        $departamento->nombre = $request->nombre;
        $departamento->estado = '1';
        $departamento->save();
    }

    public function inactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = TipoVeeduria::findOrFail($request->id);
        $departamento->estado = '0';
        $departamento->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = TipoVeeduria::findOrFail($request->id);
        $departamento->estado = '1';
        $departamento->save();
    }
}
