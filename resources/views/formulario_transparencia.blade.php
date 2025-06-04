<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar</title>

  <!-- Bootstrap y jQuery -->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="//code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" crossorigin="anonymous">

  <style>
    body {
      background-color: #ffffcc;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container-flex {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      padding: 30px;
    }

    .card,
    .buscador {
      background-color: white;
      border-radius: 50px;
      padding: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 400px;
    }

    #resultados {
      font-size: 14px;
      max-height: 200px;
      overflow-y: auto;
      margin-top: 15px;
      padding: 10px;
      border: 1px solid #ddd;
      background-color: #f9f9f9;
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <div class="text-center pt-4">
    <h2 style="color: blue;">FORMULARIO DE RESOLUCIONES</h2>
  </div>

  <div class="container-flex">
    <!-- Formulario -->
    <div class="card">
      <form action="{{ route('mostrar_formulario', ['id' => $id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <h4 class="card-title mb-4 mt-1">Subir Resolución</h4>

        <div class="form-group">
          <label for="numero">Número de Resolución</label>
          <input name="numero" class="form-control" placeholder="número" type="number" required>
        </div>

        <div class="form-group">
          <label for="anio">Año de Resolución</label>
          <input name="anio" class="form-control" placeholder="número" type="number" required>
        </div>

        <div class="form-group">
          <label for="nombre">Nombre de Resolución</label>
          <input name="nombre" class="form-control" placeholder="nombre" type="text" required>
        </div>
        

        <div class="form-group">
          <label for="asunto">Asunto</label>
          <input name="asunto" class="form-control" placeholder="asunto" type="text" required>
        </div>

        <div class="form-group">
          <label for="resumen">Resumen</label>
          <input name="resumen" class="form-control" placeholder="resumen" type="text" required>
        </div>

        <div class="form-group">
          <label for="fecha_doc">Fecha de publicación</label>
          <input name="fecha_doc" class="form-control" type="date" required>
        </div>

        <div class="form-group">
          <label for="clase_documento_id">Tipo de Documento</label>
          <input name="clase_documento_id" class="form-control" placeholder="tipo de documento" type="number" required>
        </div>

        <div class="form-group">
          <label for="pdf">Subir PDF</label>
          <input name="pdf" type="file" class="form-control" accept="application/pdf" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block" onclick="mostrarAlerta()">Subir Resolución</button>
      </form>

      <br>
      <!-- <button type="button" class="btn btn-danger btn-block" id="btnCancelar">Salir</button> -->
      <a href="{{ route('login') }}" class="btn btn-danger btn-block">Salir</a>

    </div>

    <!-- Buscador -->
    <div class="buscador">
      <h4>Buscar Resoluciones</h4>
      <input type="text" id="busqueda" class="form-control" placeholder="Buscar por número, asunto o PDF">
      <div id="resultados">
      </div>
    </div>
  </div>

  <script>
    function mostrarAlerta() {
      var mensaje = "Registro guardado correctamente!";
      var tipoAlerta = "success";

      var alerta = `<div class="alert alert-${tipoAlerta} alert-dismissible fade show" role="alert">
                      ${mensaje}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>`;

      $('body').append(alerta);
    }
  </script>
  <script>
    $('#busqueda').on('keyup', function() {
      let q = $(this).val();

      if (q.length >= 3) {
        $.get('/buscar', {
          q: q
        }, function(data) {
          let html = '';

          if (data.length === 0) {
            html = '<p>No se encontraron resultados.</p>';
          } else {
            data.forEach(function(item) {
              html += `<div class="card mb-1" style="padding: 8px; font-size: 0.85rem; width: 337px;">
                                <div class="card-body py-2 px-3" style="padding: 10px;">
                                <h6 style="margin-bottom: 4px; font-size: 0.9rem;">${item.numero}-${item.fecha_doc} ${item.nombre}</h6>
                                <h6 style="margin-bottom: 4px; font-size: 0.9rem;">${item.asunto}</h6>
                                <p style="margin-bottom: 6px; font-size: 0.75rem;">Archivo: ${item.nombre_original_pdf}</p>
                                <a href="/storage/${item.pdf_path}" target="_blank" style="font-size: 0.8rem;">Ver PDF</a>
                            </div>
                    </div>`;
            });
          }

          $('#resultados').html(html);
        });
      } else {
        $('#resultados').html('');
      }
    });
  </script>
</body>

</html>