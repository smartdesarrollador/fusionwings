<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Error en el pago :(</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">
</head>
<body>
<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">

    <div class="row mb-3 justify-content-center">
        <div class="col-6 col-sm-6 col-md-4 col-xl-3 col-lg-3 text-center">
            <img class="img-fluid" src="assets/img/payment_error.png" alt="">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col font-weight-bolder">
            <h2 class="text-danger text-center">Hubo un problema al procesar su pago</h2>
            <h5 class="text-danger text-center">Nos disculpamos por cualquier inconveniente causado</h5>
            <h6 class="text-center">
                Por favor contactanos contáctanos para resolver tu problema
            </h6>
        </div>
    </div>



    <div class="row mt-5">
        <div class="col text-center">
            <a href="egipcio-carta.php" class="btn btn-secondary">Volver a la carta</a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col text-center">
            <h4>
                Nuestro Delivery Web atiende de Lunes a Sábado de 12:30 pm a 9:00 pm
            </h4>
            <h6>
                Mientras tanto, puedes escoger lo que deseas ordenar hoy y guardarlo en tu bolsa de
                compras.
            </h6>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col text-center">

        </div>
    </div>

</div>
<?php include 'shared/footer.php' ?>
</body>
</html>
