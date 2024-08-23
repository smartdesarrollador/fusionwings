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
    <link rel="stylesheet" href="assets/css/cards.css">
</head>
<body>
<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">
    <div class="row mb-3">
        <div class="col">
            <h2 class="titulo">BLOG</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="separador"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col text-center">
            <a href="#">Iniciar Sesión</a>
        </div>
    </div>

    <div class="row mb-5 mt-5">
        <div class="col">
            <div class="row">
                <div class="col-12 col-md-12 col-xl-4 col-lg-4 text-center p-4">
                    <img class="img-fluid" src="assets/img/blogImages/falafeljpg5d7d578e77e70.jpg" alt="">
                </div>
                <div class="col-12 col-md-12 col-xl-8 col-lg-8">
                    <div class="row">
                        <div class="col text-center">
                            <h4 class="text-dark"><a class="text-decoration-none" href="ver-blog.php">Falafel, el éxito gastronómico sano y sencillo llegado de Oriente</a></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col ">
                            <p class="text-muted">2019-09-14
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col ">
                            <p>
                                Esta especie de croqueta o albóndiga de garbanzos o habas triunfa en los menús de occidente
                                gracias a los restaurantes especializados en comida Árabe y vegetariana.....
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
<?php include 'shared/footer.php' ?>
</body>
</html>
