<?php
// header('Pragma: public');
// header('Expires: 0');
// $filename = 'ReporteVeedurias.xls';
// header('Content-type: application/x-msdownload');
// header("Content-Disposition: attachment; filename=$filename");
// header('Pragma: no-cache');
// header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <table border="1">
        <thead>
            <th>Nombre de la veeduría</th>
            <th>Descripción</th>
            <th>Tipo de veeduría</th>
            <th>Departamento de la veeduría</th>
            <th>Ciudad de la veeduría</th>
            <th>Radicado CNE</th>
            <th>Fecha de realización</th>
            <th>id integrante</th>
            <th>Tipo de identificación</th>
            <th>nombre de integrante</th>
            <th>Número de documento del integrante</th>
            <th>Dirección</th>
            <th>teléfono</th>
            <th>correo electrónico</th>
        </thead>
        <tbody>
            @foreach ($veeduria as $i)
                @if (sizeof($i->veeduriaIntegrante) > 0)
                    @foreach ($i->veeduriaIntegrante as $row)
                        <tr>
                            {{-- <td>{{ $i->id }}</td> --}}
                            <td>{{ $i->nombre_tema }}</td>
                            <td>{{ $i->descripcion }}</td>
                            <td>{{ $i->tipo_veeduria->nombre ?? "" }}</td>
                            <td>{{ $i->departamento->nombre ?? "No aplica" }}</td>
                            <td>{{ $i->ciudad->nombre ?? "No aplica" }}</td>
                            <td>{{ $i->radicado_CNE }}</td>
                            <td>{{ $i->fecha_realizacion }}</td>
                            <td>{{ $row->integrante->id }}</td>
                            <td>{{ $row->integrante->tipoIdentificacion->nombre }}</td>
                            <td>{{ $row->integrante->nombre }}</td>
                            <td>{{ $row->integrante->documento }}</td>
                            <td>{{ $row->integrante->direccion }}</td>
                            <td>{{ $row->integrante->telefono }}</td>
                            <td>{{ $row->integrante->email }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $i->nombre_tema }}</td>
                        <td>{{ $i->descripcion }}</td>
                        <td>{{ $i->tipo_veeduria->nombre ?? "" }}</td>
                        <td>{{ $i->departamento->nombre ?? "No aplica" }}</td>
                        <td>{{ $i->ciudad->nombre ?? "No aplica" }}</td>
                        <td>{{ $i->radicado_CNE }}</td>
                        <td>{{ $i->fecha_realizacion }}</td>
                        <td>No hay integrantes</td>
                        <td>No aplica</td>
                        <td>No aplica</td>
                        <td>No aplica</td>
                        <td>No aplica</td>
                        <td>No aplica</td>
                        <td>No aplica</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
