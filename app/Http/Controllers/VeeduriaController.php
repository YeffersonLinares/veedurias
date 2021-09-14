<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Departamento;
use App\Models\Documento;
use App\Models\VeeduriaSoporte;
use App\Models\Integrante;
use App\Models\Ciudad;
use App\Models\TipoDocumento;
use App\Models\TipoDocumento2;
use App\Models\TipoIdentificacion;
use App\Models\TipoVeeduria;
use App\Models\Veeduria;
use App\Models\VeeduriaIntegrante;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Block\Element\Document;

class VeeduriaController extends Controller
{

    public function edit($id)
    {
        $veeduria = Veeduria::find($id);
        $departamentos = Departamento::where('estado', 1)->get();
        $ciudades = Ciudad::where('estado', 1)->get();
        $TipoDocumentos = TipoDocumento2::where('estado', 1)->get();
        $TipoIdentificacion = TipoIdentificacion::where('estado', 1)->get();
        $tipoVeeduria = TipoVeeduria::where('estado', 1)->get();
        $archivos = DB::table('documento')
            ->select(
                'documento.*',
                'tipo_documento.nombre as tipo_nombre'
            )->join('veeduria_soporte', 'veeduria_soporte.id_documento', 'documento.id')
            ->join('tipo_documento','tipo_documento.id','documento.id_tipo_documento')
            ->where('documento.estado', 1)
            ->where('veeduria_soporte.id_veeduria', $id)->get();
        $integrantes = DB::table('veeduria_integrante')
            ->select(
                'integrante.*'
            )->join('integrante', 'integrante.id', 'veeduria_integrante.id_integrante')
            ->where('integrante.estado', 1)
            ->where('veeduria_integrante.id_veeduria', $id)
            ->get();
        return response()->json([
            'veeduria' => $veeduria,
            'integrantes' => $integrantes,
            'departamentos' => $departamentos,
            'ciudades' => $ciudades,
            'tipodocumentos' => $TipoDocumentos,
            'tipoIdentificacion' => $TipoIdentificacion,
            'archivos' => $archivos,
            'tipoDocumentos' => $TipoDocumentos,
            'tipo_veeduria' => $tipoVeeduria,
        ]);
    }

    public function detalles_veeduria($id)
    {
        $veeduria = Veeduria::find($id);
        $departamentos = Departamento::where('estado', 1)->get();
        $ciudades = Ciudad::where('estado', 1)->get();
        $integrantes = DB::table('veeduria_integrante')
            ->select(
                'integrante.*'
            )->join('integrante', 'integrante.id', 'veeduria_integrante.id_integrante')
            ->where('integrante.estado', 1)
            ->where('veeduria_integrante.id_veeduria', $id)
            ->get();
        return response()->json([
            'veeduria' => $veeduria,
            'integrantes' => $integrantes,
            'departamentos' => $departamentos,
            'ciudades' => $ciudades,
        ]);
    }

    public function documentoxveeduria($id)
    {
        // return $id;
        $documentos = DB::table('documento')
            ->select(
                'documento.*',
                'tipo_documento.nombre as tipo_nombre'
            )->join('veeduria_soporte', 'veeduria_soporte.id_documento', 'documento.id')
            ->join('tipo_documento', 'tipo_documento.id', 'documento.id_tipo_documento')
            ->where('documento.estado', 1)
            ->where('veeduria_soporte.id_veeduria', $id)->get();
        return response()->json([
            'documentos' => $documentos,
        ]);
    }

    public function munxdep($id)
    {
        $ciudades = Ciudad::where('id_departamento', $id)->get();
        return response()->json(['ciudades' => $ciudades]);
    }
    public function nuevaVeeduria()
    {
        return view('veeduria.nueva_veeduria');
    }

    public function nuevaVeeduriaData()
    {
        $departamentos = Departamento::where('estado', 1)->get();
        $TipoDocumentos = TipoDocumento2::where('estado', 1)->get();
        $TipoIdentificacion = TipoDocumento::where('estado', 1)->get();
        $tipoVeeduria = TipoVeeduria::where('estado', 1)->get();
        return response()->json([
            'departamentos' => $departamentos,
            'tipodocumentos' => $TipoDocumentos,
            'tipoidentificacion' => $TipoIdentificacion,
            'tipo_veeduria' => $tipoVeeduria,
        ]);
    }

    public function filtrar_veeduria(Request $request)
    {
        // return $request->all();
        $post = $request;
        // return $post;
        $veeduria = $this->tabla($post);
        return response()->json(['status' => 200, 'veeduria' => $veeduria]);
    }

    public function consulta()
    {
        $veeduria = DB::table('veeduria')
            ->select(
                'veeduria.*',
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre'),
                DB::raw('tipo_veeduria.nombre as tipo_nombre')
            )->leftJoin('departamentos', 'departamentos.id', 'veeduria.dep_id')
            ->leftJoin('ciudades', 'ciudades.id', 'veeduria.ciu_id')
            ->join('tipo_veeduria','tipo_veeduria.id','veeduria.tipo_id')
            ->where('veeduria.estado', 1)
            ->get();
        return $veeduria;
    }

    public function consulta_filtro_lista($post)
    {
        $veeduria = DB::table('veeduria')
            ->select(
                'veeduria.*',
                DB::raw('tipo_veeduria.nombre as tipo_nombre'),
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre')
            )->leftJoin('departamentos', 'departamentos.id', 'veeduria.dep_id')
            ->leftJoin('ciudades', 'ciudades.id', 'veeduria.ciu_id')
            ->join('tipo_veeduria', 'tipo_veeduria.id', 'veeduria.tipo_id')
            ->where('veeduria.estado', 1)
            ->where(function ($query) use ($post) {
                if (isset($post['nombre'])) {
                    if (!empty($post['nombre']))
                        $query->orwhere('veeduria.nombre_tema', 'like', "%" . $post['nombre'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['departamento'])) {
                    if (!empty($post['departamento']))

                        $query->orwhere('veeduria.dep_id', $post['departamento']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['tipo'])) {
                    if (!empty($post['tipo']))
                        $query->orwhere('veeduria.tipo_id',$post['tipo']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['estado'])) {
                    if (!empty($post['estado']))
                        $query->orwhere('veeduria.fecha_realizacion', 'like', "%" . $post['estado'] . "%");
                }
            })->get();
        return $veeduria;
        // return response()->json([
        //     'veedurias' => $veeduria,
        // ]);
    }

    public function tabla($post)
    {
        $veeduria = DB::table('veeduria')
            ->select(
                'veeduria.*',
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre')
            )->leftJoin('departamentos', 'departamentos.id', 'veeduria.dep_id')
            ->leftJoin('ciudades', 'ciudades.id', 'veeduria.ciu_id')
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

    public function informeVeeduria(Request $request)
    {
        return view('veeduria.informe_veeduria');
    }

    public function informeVeeduriaData(Request $request)
    {
        $veeduria = $this->consulta();
        $departamentos = Departamento::where('estado', 1)->get();
        $municipios = Ciudad::where('estado', 1)->get();
        $tipoVeeduria = TipoVeeduria::where('estado', 1)->get();
        return response()->json([
            'veeduria' => $veeduria,
            'departamentos' => $departamentos,
            'municipios' => $municipios,
            'tipo_veeduria' => $tipoVeeduria,
        ]);
    }

    public function listaVeeduria()
    {
        return view('veeduria.lista_veeduria');
    }

    public function listaVeeduriaData()
    {
        $departamentos = Departamento::all();
        $tipoArchivo = TipoDocumento::all();
        $tipoVeeduria = TipoVeeduria::where('estado',1)->get();

        $veeduria = $this->consulta();
        return response()->json([
            'veedurias' => $veeduria,
            'departamentos' => $departamentos,
            'tipoArchivo' => $tipoArchivo,
            'tipo_veeduria' => $tipoVeeduria,
        ]);
    }

    public function filtrar_lista_veeduria(Request $request)
    {
        // return $request->all();
        $post = $request;
        $veeduria = $this->consulta_filtro_lista($post);
        return response()->json(['status' => 200, 'veeduria' => $veeduria]);
    }

    public function insertarVeeduria(Request $request)
    {
        // return $request->all();

        $rules = [
            'nombre_tema' => 'required|max:50|string',
            'descripcion' => 'required|max:500',
            'radicado_CNE' => 'required',
            'fecha_realizacion' => 'required|date',
            'direccion' => 'required|max:255',
            'telefono' => 'required|integer',
            'tipo_veeduria' => 'required|integer',
            'correo' => 'required|max:255|email',
        ];

        if ($request->tipo_veeduria == 2 || $request->tipo_veeduria == 3 || $request->tipo_veeduria == 4) {
            $rules['dep_id'] = 'required|numeric';
        }
        if ($request->tipo_veeduria == 3 || $request->tipo_veeduria == 4) {
            $rules['ciu_id'] = 'required|numeric';
        }

        $messages = [
            'nombre_tema.required' => 'El nombre es requerido',
            'nombre_tema.max:50' => 'El nombre no puede superar los 50 carácteres',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.max:500' => 'La descripción no debe exceder los 500 carácteres',
            'dep_id.required' => 'El departamento es requerido',
            'ciu_id.required' => 'La ciudad es requerido',
            'radicado_CNE.required' => 'El radicado CNE es requerido',
            'fecha_realizacion.required' => 'la fecha es requerida',
            'direccion.required' => 'La dirección es requerida',
            'direccion.max' => 'La dirección máximo debe tener 255 caracteres',
            'telefono.required' => 'El teléfono es requerido',
            'telefono.integer' => 'El teléfono debe ser numérico',
            'tipo_veeduria.required' => 'El tipo de veeduría es requerido',
            'tipo_veeduria.integer' => 'El tipo de veeduría debe ser numérico',
            'correo.required' => 'El correo es requerido',
            'correo.max' => 'El correo debe tener máximo 255 caracteres',
            'correo.email' => 'Formato de correo no valido',
        ];

        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        }


        $veeduria = new Veeduria();
        $veeduria->nombre_tema = $request->nombre_tema;
        $veeduria->descripcion = $request->descripcion;
        $veeduria->dep_id = $request->dep_id;
        $veeduria->ciu_id = $request->ciu_id;
        $veeduria->radicado_CNE = $request->radicado_CNE;
        $veeduria->fecha_realizacion = $request->fecha_realizacion;
        $veeduria->direccion = $request->direccion;
        $veeduria->telefono = $request->telefono;
        $veeduria->tipo_id = $request->tipo_veeduria;
        $veeduria->correo = $request->correo;
        $veeduria->estado = 1;
        $veeduria->save();

        for ($x = 0; $x < $request->cantidad; $x++) {
            $file = $request->file("archivo$x");
            $fileName = time() . '_' . $file->getClientOriginalName();

            $documento = new Documento();
            $documento->id_subserie = 1;
            $documento->id_tipo_documento = $request["tipo_archivo$x"];
            $documento->nombre = $fileName;
            $documento->ruta = 'uploads/' . $fileName;
            $documento->estado = 1;
            $documento->save();

            $soporte = new VeeduriaSoporte();
            $soporte->id_veeduria = $veeduria->id;
            $soporte->id_documento = $documento->id;
            $soporte->estado = 1;
            $soporte->save();

            $request["archivo$x"]->move(public_path('uploads/'), $fileName);
        }

        for ($z = 0; $z < $request->cantidad_integrantes; $z++) {
            $integrante = new Integrante();
            $integrante->id_tipo_identificacion = $request["integrante_tipo_identificacion$z"];
            $integrante->nombre = $request["integrante_nombre$z"];
            $integrante->documento = $request["integrante_identificacion$z"];
            $integrante->direccion = $request["integrante_direccion$z"];
            $integrante->telefono = $request["integrante_telefono$z"];
            $integrante->email = $request["integrante_correo$z"];
            $integrante->estado = 1;
            $integrante->save();

            $pivote = new VeeduriaIntegrante();
            $pivote->id_veeduria = $veeduria->id;
            $pivote->id_integrante = $integrante->id;
            $pivote->estado = 1;
            $pivote->save();
        }
        return response()->json([
            'status' => 200,
            'msg' => 'Veeduría agregada éxitosamente'
        ]);
    }

    public function descargarExcel()
    {
        //
    }

    public function descargarPDF()
    {
        //
    }

    public function eliminarVeeduria($id)
    {
        $veeduria = Veeduria::find($id);
        $veeduria->estado = 0;
        if ($veeduria->save()) :
            $veedurias = Veeduria::where('estado', 1)->get();
            return response()->json(['status' => 200, 'msg' => 'Veeduría eliminada correctamente', 'veedurias' => $veedurias]);
        else :
            return response()->json(['status' => 500, 'msg' => 'Algo salió mal']);
        endif;
    }

    public function viewEditVeeduria()
    {
        return view('veeduria.editar_veeduria');
    }

    public function editarVeeduria($id)
    {
        // return $id;
        $documents = Documento::select('documento.*')
            ->leftjoin("veeduria_soporte", "veeduria_soporte.id_documento", "documento.id")
            ->where('veeduria_soporte.id_veeduria', $id)
            ->where('documento.estado', 1)
            ->get();

        $type_document = Documento::select('documento.id_tipo_documento', 'tipo_documento.nombre')
            ->leftjoin("veeduria_soporte", "veeduria_soporte.id_documento", "documento.id")
            ->leftjoin("tipo_documento", "tipo_documento.id", "documento.id_tipo_documento")
            ->where('veeduria_soporte.id_veeduria', $id)
            ->where('documento.estado', 1)
            ->first();


        $veeduria = Veeduria::find($id);
        // $integrantes = $veeduria->veeduriaIntegrante[0]->integrante->tipoIdentificacion;
        $integrantes = [];
        $x = 0;
        foreach ($veeduria->veeduriaIntegrante as $row) {
            $integrantes[$x] = $row->integrante;
            $x++;
        }
        // return response()->json(['msg' => $integrantes]);

        $departamentos = Departamento::where('estado', 1)->get();
        $Municipios = Ciudad::where('estado', 1)->where('id_departamento', $veeduria->dep_id)->get();
        $TipoDocumentos = TipoDocumento::where('estado', 1)->get();
        $TipoIdentificacion = TipoIdentificacion::where('estado', 1)->get();

        return response()->json([
            'data' =>  $veeduria,
            'type_document' =>  $type_document,
            'departamentos' =>  $departamentos,
            'municipios' =>  $Municipios,
            'documents' =>  $documents,
            'tipodocumentos' =>  $TipoDocumentos,
            'tipoidentificacion' =>  $TipoIdentificacion,
            'integrantes' => $integrantes
        ]);
    }

    public function editDocument(Request $r)
    {
        $e = Documento::find($r->id);
        $e->estado = 3;
        $e->save();
    }

    public function editarVeeduriaData(Request $r)
    {
        // return $r;
        $rules = [
            // 'nombre_tema' => 'required',
            // 'descripcion' => 'required',
            // 'dep_id' => 'required|numeric',
            // 'mun_id' => 'required|numeric',
            // 'radicado_CNE' => 'required',
            // 'tipoArchivo' => 'required|numeric',
            // 'fecha_realizacion' => 'required'
        ];
        $messages = [
            'nombre_tema.required' => 'El nombre es requerido',
            'descripcion.required' => 'La descripción es requerida',
            'dep_id.required' => 'El departamento es requerido',
            'mun_id.required' => 'El municipio es requerido',
            'radicado_CNE.required' => 'El radicado CNE es requerido',
            'tipoArchivo.required' => 'El tipo de documento es requerido',
            'fecha_realizacion.required' => 'la fecha es requerida'
        ];
        // if (!isset($r->file)) {
        //     return response()->json(['msg' => 'Debe ingresar al menos un documento']);
        // }
        $validator = Validator::make($r->all(), $rules, $messages);

        // $veeduria = Veeduria::find($r->id_record);
        $veeduria = Veeduria::find($r->id);
        $veeduria->nombre_tema = $r->nombre_tema;
        $veeduria->descripcion = $r->descripcion;
        $veeduria->dep_id = $r->dep_id;
        $veeduria->ciu_id = $r->mun_id;
        $veeduria->radicado_CNE = $r->radicado_CNE;
        $veeduria->fecha_realizacion = $r->fecha_realizacion;

        $type =  $r->tipoArchivo;
        // return response()->json(['vee' => $veeduria]);
        if ($veeduria->save()) {
            return response()->json(['status' => 200, 'msg' => 'editado correctamente']);
            if (isset($r->file)) {
                foreach ($r->file as $i) {
                    $path =  $i->store('uploads', 'public');
                    $doc = new Documento();
                    $doc->nombre = $i->getClientOriginalName();
                    $doc->ruta = $path;
                    $doc->id_tipo_documento = $type;
                    $doc->save();

                    $x = new VeeduriaSoporte();
                    $x->id_veeduria = $veeduria->id;
                    $x->id_documento = $r->doc;
                    $x->save();
                }
            }

            $data = $r->input();
            for ($i = 1; $i <= $r->integrantes; $i++) {

                $integrantes = new Integrante();
                $integrantes->id_tipo_identificacion = $data['tipo_' . $i];
                $integrantes->nombre = $data['nombre_' . $i];
                $integrantes->documento = $data['identificacion_' . $i];
                $integrantes->direccion = $data['direccion_' . $i];
                $integrantes->telefono = $data['telefono_' . $i];
                $integrantes->email = $data['correo_' . $i];
                $integrantes->estado = $data['estado_' . $i];
                $integrantes->save();

                $veeduriaIntegrante = new VeeduriaIntegrante();
                $veeduriaIntegrante->id_veeduria = $veeduria->id;
                $veeduriaIntegrante->id_integrante = $integrantes->id;
                $veeduriaIntegrante->estado = $data['estado_' . $i];
                $veeduriaIntegrante->save();
            }

            if ($validator->fails()) {
                return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
            } else {
                return response()->json(['msg' => 'Datos guardados correctamente', 'status' => 200,]);
            }
        } else {
            return response()->json(['status' => 406, 'msg' => 'Error al guardar']);
        }
    }

    public function update_veeduria(Request $request)
    {
        // return $request->all();

        $rules = [
            'nombre_tema' => 'required|max:50|string',
            'descripcion' => 'required|max:500',
            'radicado_CNE' => 'required',
            'fecha_realizacion' => 'required|date',
            'direccion' => 'required|max:255',
            'telefono' => 'required|integer',
            'tipo_veeduria' => 'required|integer',
            'correo' => 'required|max:255|email',
        ];

        if ($request->tipo_veeduria == 2 || $request->tipo_veeduria == 3 || $request->tipo_veeduria == 4) {
            $rules['dep_id'] = 'required|numeric';
        }
        else{
            $request->dep_id = null;
        }
        if ($request->tipo_veeduria == 3 || $request->tipo_veeduria == 4) {
            $rules['ciu_id'] = 'required|numeric';
        }else{
            $request->ciu_id = null;
        }

        $messages = [
            'nombre_tema.required' => 'El nombre es requerido',
            'nombre_tema.max:50' => 'El nombre no puede superar los 50 carácteres',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.max:500' => 'La descripción no debe exceder los 500 carácteres',
            'dep_id.required' => 'El departamento es requerido',
            'ciu_id.required' => 'El municipio es requerido',
            'radicado_CNE.required' => 'El radicado CNE es requerido',
            'fecha_realizacion.required' => 'la fecha es requerida',
            'direccion.required' => 'La dirección es requerida',
            'direccion.max' => 'La dirección máximo debe tener 255 caracteres',
            'telefono.required' => 'El teléfono es requerido',
            'telefono.integer' => 'El teléfono debe ser numérico',
            'tipo_veeduria.required' => 'El tipo de veeduría es requerido',
            'tipo_veeduria.integer' => 'El tipo de veeduría debe ser numérico',
            'correo.required' => 'El correo es requerido',
            'correo.max' => 'El correo debe tener máximo 255 caracteres',
            'correo.email' => 'Formato de correo no valido',
        ];

        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }

        // return '1';

        for ($x = 0; $x < $request->cant_eliminados; $x++) {
            $documento = Documento::find($request["a_eliminados$x"]);
            $documento->estado = '0';
            $documento->save();
        }

        $veeduria = Veeduria::find($request->id);
        $veeduria->nombre_tema = $request->nombre_tema;
        $veeduria->descripcion = $request->descripcion;
        $veeduria->dep_id = $request->dep_id;
        $veeduria->ciu_id = $request->ciu_id;
        $veeduria->radicado_CNE = $request->radicado_CNE;
        $veeduria->fecha_realizacion = $request->fecha_realizacion;
        $veeduria->direccion = $request->direccion;
        $veeduria->telefono = $request->telefono;
        $veeduria->tipo_id = $request->tipo_veeduria;
        $veeduria->correo = $request->correo;
        $veeduria->save();

        for ($x = 0; $x < $request->cantidad; $x++) {
            if ($request->hasFile(["archivo$x"])) :
                $file = $request->file("archivo$x");
                $documento = new Documento();
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request["tipo_archivo$x"];
                $documento->estado = '1';
                $fileName = time() . '_' . $file->getClientOriginalname();
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/' . $fileName;
                $documento->save();

                $soporte = new VeeduriaSoporte();
                $soporte->id_veeduria = $veeduria->id;
                $soporte->id_documento = $documento->id;
                $soporte->estado = '1';
                $soporte->save();

                $request["archivo$x"]->move(public_path('uploads'), $fileName);
            endif;
        }

        // return '1';


        for ($z = 0; $z < $request->cantidad_integrantes; $z++) {
            if (!empty($request["id$z"]) && !is_null($request["id$z"])) {
                $integrante = Integrante::find($request["id$z"]);;
                $integrante->id_tipo_identificacion = $request["integrante_tipo_identificacion$z"];
                $integrante->nombre = $request["integrante_nombre$z"];
                $integrante->documento = $request["integrante_identificacion$z"];
                $integrante->direccion = $request["integrante_direccion$z"];
                $integrante->telefono = $request["integrante_telefono$z"];
                $integrante->email = $request["integrante_correo$z"];
                $integrante->estado = 1;
                $integrante->save();
            } else {
                $integrante = new Integrante();
                $integrante->id_tipo_identificacion = $request["integrante_tipo_identificacion$z"];
                $integrante->nombre = $request["integrante_nombre$z"];
                $integrante->documento = $request["integrante_identificacion$z"];
                $integrante->direccion = $request["integrante_direccion$z"];
                $integrante->telefono = $request["integrante_telefono$z"];
                $integrante->email = $request["integrante_correo$z"];
                $integrante->estado = 1;
                $integrante->save();

                $pivote = new VeeduriaIntegrante();
                $pivote->id_veeduria = $veeduria->id;
                $pivote->id_integrante = $integrante->id;
                $pivote->estado = 1;
                $pivote->save();
            }
        }
        return response()->json(['status' => 200, 'msg' => 'Editado correctamente']);
    }


    public function viewDocuments(Request $r)
    {
        $documents = Documento::select('documento.*')
            ->leftjoin("veeduria_soporte", "veeduria_soporte.id_documento", "documento.id")
            ->where('veeduria_soporte.id_veeduria', $r->id)
            ->where('documento.estado', 1)
            ->get();

        return response()->json([
            'data' => $documents
        ]);
    }
}
