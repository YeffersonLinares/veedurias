<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoDocumento2;

class TipoDocumento2Controller extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_tipo_documento')->only('index');
        $this->middleware('permission:add_tipo_documento')->only('store');
        $this->middleware('permission:edit_tipo_documento')->only('update');
        $this->middleware('permission:delete_tipo_documento')->only(['inactivar','activar']);
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tipoDocumentos = TipoDocumento2::orderBy('id', 'desc')->paginate(10);
        }else{
            $tipoDocumentos = TipoDocumento2::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total'        => $tipoDocumentos->total(),
                'current_page' => $tipoDocumentos->currentPage(),
                'per_page'     => $tipoDocumentos->perPage(),
                'last_page'    => $tipoDocumentos->lastPage(),
                'from'         => $tipoDocumentos->firstItem(),
                'to'           => $tipoDocumentos->lastItem(),
            ],
            'tipoDocumentos' => $tipoDocumentos
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            $tipoDocumentos = new TipoDocumento2();
            $tipoDocumentos->nombre = $request->nombre;           
            $tipoDocumentos->save();

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            $tipoDocumentos =TipoDocumento2::findOrFail($request->id);
            $tipoDocumentos->nombre = $request->nombre;
            $tipoDocumentos->estado = '1';
            $tipoDocumentos->save();

    }

    public function inactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            $tipoDocumentos = TipoDocumento2::findOrFail($request->id);
            $tipoDocumentos->estado = '0';
            $tipoDocumentos->save();

    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            $tipoDocumentos = TipoDocumento2::findOrFail($request->id);
            $tipoDocumentos->estado = '1';
            $tipoDocumentos->save();

    }
}
