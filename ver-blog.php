<?php
session_start();
$page = 'blog';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Blog</title>
    <?php include "shared/libraries.php"; ?>

    <style>

    </style>
</head>
<body>
<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">
    <div class="row mb-3">
        <div class="col text-center">
            <h2 class="">Falafel, el éxito gastronómico sano y sencillo llegado de Oriente
            </h2>
        </div>
    </div>


    <div class="row ">
        <div class="col text-center p-5">
            <img class="img-fluid" src="assets/img/blogImages/falafeljpg5d7d578e77e70.jpg" alt="">
        </div>
    </div>

    <div class="row mb-5">
        <div class="col p-5">
            <p>
                Esta especie de croqueta o albóndiga de garbanzos o habas triunfa en los menús de occidente gracias a
                los restaurantes especializados en comida Árabe y vegetariana.
            </p>
            <p>
                Un producto sano y sencillo de elaborar, con tantos siglos de historia que ya aparece en los textos
                bíblicos y con tantas modalidades de preparación como formas de presentarlo. Es el falafel, un plato
                tradicional típico de Oriente Medio, aunque de origen incierto, que se ha extendido con éxito por todo
                el mundo y que es imprescindible en la gastronomía árabe.
            </p>
            <p>
                Pero la globalización también ha dejado su huella en el falafel, introduciendo variedades de todo tipo,
                lo que ha enriquecido su sabor y también su nombre al acondicionarlo a cada lugar del mundo. De esta
                forma, hemos descubierto que existe el falafel en el chucrut alemán, en la berenjena frita iraquí, o
                presentado con salsa india de mango y salsa picante yemení.
            </p>
            <p>
                Como curiosidad, el falafel más grande del mundo, que pesa 74,8 kilogramos y supera el metro y medio de
                algo con 152 centímetros de altura, se elaboró en el Hotel Landmark de Amman, en Jordania, y tuvo que
                freírse durante 25 minutos.
            </p>
        </div>
    </div>


</div>
<?php include 'shared/footer.php' ?>
</body>
</html>
