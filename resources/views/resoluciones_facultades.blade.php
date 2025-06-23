<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Oficios</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin-top: 110px;
            /* espacio para encabezado */
        }

        header {
            position: fixed;
            top: -10px;
            left: 0;
            right: 0;
            height: 90px;
            text-align: center;
        }

        .header-content {
            text-align: center;
        }

        .header-content img {
            float: left;
            margin: 10px 30px;
            width: 70px;
        }

        .header-content h1,
        .header-content h2,
        .header-content h3 {
            margin: 0;
            padding: 0;
            font-weight: normal;
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
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            margin-top: 30px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <header>
        <div class="header-content">
            <img src="{{ public_path('img/logo_header.png') }}" alt="Logo">
            <h2>UNIVERSIDAD NACIONAL DEL CALLAO</h2>
            <h4>OFICINA DE TECNOLOGÍAS DE INFORMACIÓN</h4>
            <h5>“Año de la recuperación y consolidación de la economía peruana”</h5>
            <hr style="margin-top: 5px; border: 1px solid black;">
        </div>
    </header>

    @foreach($reportePorOficina as $oficina)
    <div class="@if(!$loop->first) page-break @endif">
        <p style="text-align: right;">Bellavista, {{ \Carbon\Carbon::now()->locale('es')->translatedFormat('d \d\e F \d\e\l Y') }}</p>

        <p><strong><u>Oficio Nº 470-OTI-{{ date('Y') }}</u></strong></p>

        <p><strong>Sr.<br>
                DR. VICTOR HUGO DURAN HERRERA<br>
                DECANO DE LA {{ $oficina['nombre'] }}<br>
                <u>Presente.-</u></strong></p>

        <p><strong>Asunto:</strong> Envío de Información para publicación en el Portal de Transparencia y acceso a la información Pública (Ley Nº 27806 DS Nº 043-2003-PCM)</p>

        <p><em><strong>De mi mayor consideración:</strong></em></p>

        <p>Es grato dirigirme a usted para expresarle un cordial saludo e informar a su despacho la información remitida a esta oficina para su publicación en el portal de Transparencia, el cual consta de:</p>

        <ul style="margin-left: 30px;">
            <li>Resoluciones de Consejo de Facultad.</li>
            <li>Resoluciones de Decanato.</li>
            <li>Actas de Consejo de Facultad.</li>
        </ul>

        <p>Su despacho a la fecha ha cursado para su publicación en el Portal de Transparencia la siguiente información:</p>

        <h2>{{ $oficina['nombre'] }}</h2>

        <table>
            <thead>
                <tr>
                    <th>Año</th>
                    <th>Resoluciones Decanales</th>
                    <th>Resoluciones de Consejo de Facultad</th>
                    <th>Actas de Consejo de Facultad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($oficina['datos'] as $anio => $fila)
                <tr>
                    <td>{{ $anio }}</td>
                    <td>
                        {!! nl2br(e($fila['resoluciones_decanales']['numeros'])) !!}
                        @if($fila['resoluciones_decanales']['fecha'])
                        <br><small><strong>Fecha:</strong> {{ $fila['resoluciones_decanales']['fecha'] }}</small>
                        @endif
                    </td>
                    <td>
                        {!! nl2br(e($fila['resoluciones_consejo']['numeros'])) !!}
                        @if($fila['resoluciones_consejo']['fecha'])
                        <br><small><strong>Fecha:</strong> {{ $fila['resoluciones_consejo']['fecha'] }}</small>
                        @endif
                    </td>
                    <td>
                        {!! nl2br(e($fila['actas_consejo']['numeros'])) !!}
                        @if($fila['actas_consejo']['fecha'])
                        <br><small><strong>Fecha:</strong> {{ $fila['actas_consejo']['fecha'] }}</small>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

</body>

</html>