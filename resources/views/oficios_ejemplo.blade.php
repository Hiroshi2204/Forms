<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Oficios</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin-top: 90px;
            /* espacio para la cabecera */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h4 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <h2 style="text-align: center; max-width: 550px; margin: 0 auto; line-height: 1.4;">
        <strong>SOLICITUDES REMITIDAS PARA ENVÍO DE INFORMACIÓN PARA PUBLICACIÓN EN EL PORTAL DE TRANSPARENCIA</strong>
    </h2>

    <br>
    <h3 style="text-align: left;">Mes de {{ ucfirst($nombreMes) }} del {{$anio}}</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Oficina</th>
                <th>N° de Oficio</th>
                <th>Asunto</th>
                <th>Fecha de Envío</th>
                <!-- <th>Estado</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach ($oficios as $i => $oficio)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $oficio->oficina_remitente }}</td>
                <td>{{ $oficio->codigo }}</td>
                <td>Envío de Información para
                    publicación en el Portal de
                    Transparencia y acceso a la
                    información Pública </td>
                <td>{{ \Carbon\Carbon::parse($oficio->fecha_envio)->format('d/m/Y') }}</td>
                <!-- <td>{{ $oficio->estado_publicacion ? 'Publicado' : 'No Publicado' }}</td> -->
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>