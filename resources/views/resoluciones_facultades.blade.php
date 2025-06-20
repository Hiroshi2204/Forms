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

    <h3>El si guiente reporte muestra todos los oficios que serán publicados en el portal de transparencia de la universidad</h3>


</body>

</html>