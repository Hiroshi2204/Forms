<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    body {
        /* background-color: #EF4343; */
        background: url('https://markepymes.com/wp-content/uploads/2021/08/que-tipo-de-aire-acondicionado-es-mejor-para-un-negocio.jpg') no-repeat center center fixed;
        background-size: cover;
        /* Hace que la imagen cubra toda la pantalla */
        background-position: center;
        /* Centra la imagen en la pantalla */
        background-attachment: fixed;
    }

    .contact {
        padding: 4%;
        height: 400px;
    }

    .col-md-3 {
        background: #E6FFA5;
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
        height: 25%;
        display: block;
        margin: 0 auto;
    }

    .contact-info h2 {
        margin-bottom: 10%;
    }

    .col-md-9 {
        background-color: #A5FFEF;
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
<form action="{{ route('destinatario_eliminar') }}" method="post">
    @csrf
    <div class="container contact">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-info">
                    <img src="https://cdn.icon-icons.com/icons2/1526/PNG/512/checklist_106575.png" alt="image" />
                    <h2>Elimina un destinatario !!!</h2>
                    <h4>Cada rol es importante para el personal . . .</h4>
                </div>
            </div>
            <div class="col-md-9">
                <div class="contact-form">
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="id">Selecciona el Destinatario para eliminar:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="id" name="id">
                                <option value="">Selecciona un Destinatario</option>
                                <?php
                                $conexion = new mysqli("localhost", "root", "", "lucky");

                                if ($conexion->connect_error) {
                                    die("Conexión fallida: " . $conexion->connect_error);
                                }

                                $consulta = "SELECT id, destinatario FROM destinatario";
                                $resultado = $conexion->query($consulta);

                                while ($fila = $resultado->fetch_assoc()) {
                                    echo "<option value='{$fila['id']}'>{$fila['destinatario']}</option>";
                                }
                                $conexion->close();
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <br>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Eliminar</button>
                        </div>
                        <br>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" id="btnCancelar" style="background-color: #B92727;">Cancelar</button>
                        </div>
                        <script>
                            document.getElementById('btnCancelar').onclick = function() {
                                // Redirigir a la vista anterior (usando el historial del navegador)
                                window.history.back();
                            };
                        </script>
                    </div>
                </div>
            </div>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </div>
        <br><br>
    </div>
    <br>
</form>