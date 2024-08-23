<?php
session_start();
$page = 'reparto';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Zona de Reparto</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">
    <meta property="og:image" content="https://elegipcio.pe/assets/img/OpenGraph/ogZonaReparto.png" />

</head>

<body>
    <?php include 'shared/navBar.php' ?>
    <div class="container main-container animated fadeIn slow mb-5">
        <div class="row mb-3">
            <div class="col">
                <h2 class="titulo">ZONA DE REPARTO</h2>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <div class="separador"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <!-- <iframe style="width: 100%" src="https://www.google.com/maps/d/u/0/embed?mid=1LWREPtVKy1HfmByy1ZS9wwo25r48g46Q" height="580">

                </iframe> -->

                <!-- <iframe style="width: 100%" src="https://www.google.com/maps/d/embed?mid=12Xsx08UCym6oC2_5SNNJ7Z4Ye1AohUU&hl=es-419&ehbc=2E312F" height="580"></iframe> -->


                <iframe style="width: 100%" src="https://www.google.com/maps/d/embed?mid=12Xsx08UCym6oC2_5SNNJ7Z4Ye1AohUU&ehbc=2E312F" height="580"></iframe>


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