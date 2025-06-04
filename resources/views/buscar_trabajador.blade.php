<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    body {
        background-color: #C7C7C7;
        /* background: url('https://theliftco.eu/wp-content/uploads/2019/09/Empresa-de-aires-acondicionados-1.jpg') no-repeat center center fixed; */
    }

    .contact {
        padding: 4%;
        height: 400px;
    }

    .col-md-3 {
        background: #ff9b00;
        padding: 4%;
        border-top-left-radius: 0.5rem;
        border-bottom-left-radius: 0.5rem;
    }

    .contact-info {
        margin-top: 10%;
    }

    .contact-info img {
        margin-bottom: 15%;
        width: 80%;
        height: 40%;
        display: block;
        margin: 0 auto;
    }

    .contact-info h2 {
        margin-bottom: 10%;
    }

    .col-md-9 {
        background-color: #E6FFA5;
        /* background: url('https://theliftco.eu/wp-content/uploads/2019/09/Empresa-de-aires-acondicionados-1.jpg') no-repeat center center fixed; */
        padding: 3%;
        border-top-right-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }

    .contact-form label {
        font-weight: 600;
    }

    .contact-form button {
        background: #25274d;
        color: #fff;
        font-weight: 600;
        width: 25%;
    }

    .contact-form button:focus {
        box-shadow: none;
    }
</style>
<form action="/buscar_trabajador" method="get">
    @csrf
    <!-- <h2>SEINDEL PERU</h2> -->
    <img style="width: 350px;" src="https://i1.wp.com/seindelperu.com/wp-content/uploads/2019/01/cropped-SEINDEL-PERU-01-crop.png?fit=1574%2C369&ssl=1" alt="Logo">
    <div class="container contact">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-info">
                    <img src="https://cdn.icon-icons.com/icons2/1526/PNG/512/checklist_106575.png" alt="image" />
                    <h2>Encuentra al trabajador!</h2>
                    <h4>Cada rol es importante para el personal . . .</h4>
                </div>
            </div>
            <div class="col-md-9">
                <div class="contact-form">
                    <label class="control-label col-sm-3" for="numero_documento">Usuario o DNI:</label>

                    <input type="text" name="numero_documento" style="width: 550px;" class="form-control" placeholder="Buscar...">

                    <br>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="numero_documento">Tabla de Resultados:</label>
                        @if($datos)
                        <table border="2" class="center-table1">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Celular</th>
                                    <th>Correo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$datos['nombres']}}</td>
                                    <td>{{$datos['apellido_paterno']}} {{$datos['apellido_materno']}}</td>
                                    <td>{{$datos['celular']}}</td>
                                    <td>{{$datos['correo']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <p>No hay trabajadores por mostrar . . .</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <br>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                        <br>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" id="btnCancelar" style="background-color: #B92727;">Salir</button>
                        </div>
                        <script>
                            document.getElementById('btnCancelar').addEventListener('click', function() {
                                window.history.back();
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>