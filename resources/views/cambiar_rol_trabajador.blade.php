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
<form action="{{ route('cambiar_rol_trabajador', ['id' => $user->id]) }}" method="post">
    @csrf
    <img style="width: 350px;" src="https://i1.wp.com/seindelperu.com/wp-content/uploads/2019/01/cropped-SEINDEL-PERU-01-crop.png?fit=1574%2C369&ssl=1" alt="Logo">
    <div class="container contact">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-info">
                    <img src="https://cdn.icon-icons.com/icons2/1526/PNG/512/checklist_106575.png" alt="image" />
                    <h2>Actualiza tu rol !!!</h2>
                    <h4>Cada rol es importante para el personal . . .</h4>
                </div>
            </div>
            <div class="col-md-9">
                <div class="contact-form">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="rol_id" id="rol_id">Rol:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="rol_id" name="rol_id">
                            <option value="">Selecciona un Rol</option>
                            <?php
                            $conexion = new mysqli("localhost", "root", "", "lucky");

                            if ($conexion->connect_error) {
                                die("Conexión fallida: " . $conexion->connect_error);
                            }

                            $consulta = "SELECT id, nombre FROM rol WHERE estado_registro = 'A'";
                            $resultado = $conexion->query($consulta);

                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<option value='{$fila['id']}'>{$fila['nombre']}</option>";
                            }
                            $conexion->close();
                            ?>
                        </select>
                    </div>
                </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Guardar</button>
                        </div>
                        <br>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" id="btnCancelar" style="background-color: #B92727;">Salir</button>
                        </div>
                        <script>
                            document.getElementById('btnCancelar').onclick = function() {
                                window.history.back();
                            };
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>