<?php

namespace App\Http\Controllers;

use App\Models\TipoIdentificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TipoIdentificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('tipoIdentificacion.index');
    // }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tipoIdentificacion = TipoIdentificacion::orderBy('id', 'desc')->paginate(10);
        }else{
            $tipoIdentificacion = TipoIdentificacion::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total'        => $tipoIdentificacion->total(),
                'current_page' => $tipoIdentificacion->currentPage(),
                'per_page'     => $tipoIdentificacion->perPage(),
                'last_page'    => $tipoIdentificacion->lastPage(),
                'from'         => $tipoIdentificacion->firstItem(),
                'to'           => $tipoIdentificacion->lastItem(),
            ],
            'tipoIdentificacion' => $tipoIdentificacion
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json(['status' => 200, 'msg' => $request->all()]);
        $tipoIdentificacion = new TipoIdentificacion();
        $tipoIdentificacion->nombre = $request->nombre;
        $tipoIdentificacion->usuario_creador = Auth::user()->nombre;
        if ($tipoIdentificacion->save()) :
            return response()->json(['status' => 200, 'msg' => 'Tipo de Identificación creado con éxito', 'tipoIdentificacion' => $tipoIdentificacion]);
        else :
            return response()->json(['status' => 500, 'msg' => 'Algo salió mal']);
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // return response()->json(['status' => 200, 'msg' => $request->all()]);
        $tipoIdentificacion = TipoIdentificacion::find($request->id);
        return response()->json(['status' => 200, 'tipoIdentificacion' => $tipoIdentificacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return response()->json(['msg' => $request->all()]);
        $tipoIdentificacion = TipoIdentificacion::find($request->id);
        $tipoIdentificacion->nombre = $request->nombre;
        if ($tipoIdentificacion->save()) :
            // $tipoIdentificacion = TipoIdentificacion::where('estado', 1)->get();
            return response()->json(['status' => 200, 'msg' => 'editado correctamente', 'tipoIdentificacion' => $tipoIdentificacion]);
        else :
            return response()->json(['status' => 500, 'msg' => 'Algo salió mal']);
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return response()->json(['status' => 200, 'msg' => $request->all()]);
        // $id = $request->tipo_id;
        $tipoIdentificacion = TipoIdentificacion::find($id);
        $tipoIdentificacion->estado = 3;
        if ($tipoIdentificacion->save()) :
            $tipoIdentificacion = TipoIdentificacion::where('estado', 1)->get();
            return response()->json([
                'status' => 200,
                'msg' => 'Tipo de identificación eliminado con éxito',
                'tipoIdentificacion' => $tipoIdentificacion
            ]);
        else :
            return response()->json(['status' => 500, 'msg' => 'Algo salió mal']);
        endif;
    }

    public function buscar_tipoIdentificacion($nombre)
    {
        // return response()->json(['status' => 200, 'msg' => $request->all()]);
        // $post = $request;
        $tipoIdentificacion = TipoIdentificacion::where('estado', 1)
            ->where(function ($query) use ($nombre) {
                if (isset($nombre)) {
                    if (!empty($nombre))
                        $query->orwhere('tipo_identificaion.nombre', 'like', "%" . $nombre . "%");
                }
            })->get();
        return response()->json(['status' => 200, 'tipoIdentificacion' => $tipoIdentificacion]);
    }

    public function modal_eliminar_tipoIdentificacion(Request $request)
    {
        return response()->json(['id' => $request->id]);
    }
}
