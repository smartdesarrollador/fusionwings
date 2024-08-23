<?php
session_start();
error_reporting(0);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - pagar</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/carrito.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <style>
        .buybutton {
            width: 139px;
            color: #fff !important;
            background: #9C0001;
            border-radius: 10px;
            font-family: "Oswald";
            font-size: 31px;
            font-weight: bold;
            margin-left: 16px;
            cursor: pointer;
            border: transparent;
            text-decoration: none !important;
            padding: 10px;

        }

        html {
            scroll-behavior: smooth;
        }
    </style>

</head>
<body>
<?php if ($_GET['code'] == "success") {
    ?>
    <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
        <div class="alert alert-success  alert-dismissible fade show text-center animated tada slow" role="alert">
            <strong>Correcto!</strong> Tu solicitud se ha enviado correctamente, nos pondremos en contacto contigo.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>


        </div>
    </div>
    <?php
} ?>

<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">

</div>
<div class="container mb-5">
    <div class="row mb-3">
        <div class="col">
            <h2 class="titulo">TRABAJA CON NOSOTROS</h2>
        </div>
    </div>

    <div class="row ">
        <div class="col">
            <div class="separador-subrayado-titulo"></div>
        </div>
    </div>
    <form  method="post" action="script/procesarCV.php" enctype="multipart/form-data">
    <div class="row">

        <div class="col">
            <div class="row mt-4">
                <div class="col"><h5>Nombre:</h5></div>
                <div class="col">
                    <div class="form-group mx-sm-3 mb-2 w-75">
                        <label for="direccion" class="sr-only">Dirección De Entrega</label>
                        <input name='nombre' required value="" type="text" class="form-control m-0" id="nombre"
                               placeholder="Nombre">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col"><h5>Apellidos:</h5></div>
                <div class="col">

                    <div class="form-group mx-sm-3 mb-2 w-75">
                        <input name='apellido' required value="" type="text" class="form-control m-0" id="apellido"
                               placeholder="Apellidos">
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col"><h5>Edad:</h5></div>
                <div class="col">

                    <div class="form-group mx-sm-3 mb-2 w-75">

                        <input name='edad' required onkeypress="return isNumberKey(event)"  value="" type="number" class="form-control m-0" id="edad"
                               placeholder="Edad">
                    </div>

                </div>
            </div>

            <div class="row mt-4">
                <div class="col"><h5>Correo:</h5></div>
                <div class="col">

                    <div class="form-group mx-sm-3 mb-2 w-75">
                        <input name='correo' required  value="" type="email" class="form-control m-0" id="correo"
                               placeholder="Correo">
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col"><h5>Nro Fijo/Celular:</h5></div>
                <div class="col">
                    <div class="form-group mx-sm-3 mb-2 w-75">
                        <label for="telefono" class="sr-only">Nro Fijo/Celular</label>
                        <input name="cel" onkeypress="return isNumberKey(event)" required min="0" value="" type="text" class="form-control m-0" id="telefono"
                               placeholder="Nro Fijo/Celular">
                    </div>

                </div>
            </div>
            <div class="row mt-4 justify-content-center">
                <div class="col">
                    CV:
                </div>
                <div class="col">
                    <div class="text-center text-lg-left text-xl-left mx-sm-3 mb-2">
                        <input onchange="return fileValidation(this)" name="archivo" required type="file" class="p-3 " style="border: 1px solid rgb(156, 0, 1) !important" id="pdf">
                    </div>
                </div>
            </div>
            <input name="action" type="hidden" value="upload" />
            <div class="row mt-4 mb-4 justify-content-center">
                <div class="col">
                </div>
                <div class="col">
                    <button type="submit"  class="btn btn-primary btn-lg">ENVIAR</button>
                </div>
            </div>
        </div>

    </div>
</form>
    <div class="row ">
        <div class="col">
            <div class="separador-subrayado-titulo"></div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col text-center">

        </div>
    </div>

</div>
<?php include 'shared/footer.php' ?>
<script src="assets/js/cv.js"></script>
</body>
</html>
