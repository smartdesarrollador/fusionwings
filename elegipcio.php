<?php
session_start();
unset($_SESSION['estado_cupon']);
error_reporting(0);
$page = 'inicio';
?>
<!doctype html>
<html lang="en">

<head>
    <title>El egipcio, shawarma, falafel - comida árabe</title>
    <?php include "shared/libraries.php"; ?>
    <script src="assets/js/registerWorker.js"></script>
    <link rel="stylesheet" href="vendor/swiper/swiper.min.css">
    <link rel="stylesheet" href="vendor/videojs/video-js.css">
    <link rel="stylesheet" href="vendor/videojs/cityVideoJs.css">
    <meta name="title" content="El egipcio, shawarma,  falafel - comida árabe">
    <meta name="description" content="Shawarma El Egipcio te trae toda la experiencia de la cocina árabe a tu mesa. Aléjate de la monotonía, ven y prueba de la gran variedad de productos que tenemos para ti. Somos pioneros en comida de origen árabe en el Perú">
    <meta name="keywords" content="el egipcio, shawarma lima, falafel lima, shawarma el egipcio lima, comida arabe lima, shawerma lima, shawarma y falafel, bowl,vegetariano,vegano,elegipcio,
    elegipciolima,elegipcio lince, shawarma bowl, shawerma bowl">
    <meta property="og:image" content="https://elegipcio.pe/assets/img/OpenGraph/logoGrandeOG.png" />


    <link rel="stylesheet" href="assets/css/index.css">
    <style>
        a.bg-danger {
            background-color: #9C0001 !important;
            border-color: #9C0001 !important;
        }
    </style>
</head>

<body>
    <?php if ($_GET['code'] == "emailExiste") {
    ?>
        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-danger emailExiste alert-dismissible fade show text-center animated tada slow" role="alert">
                <strong>Error!</strong> El correo ya esta registrado.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
        </div>
        <?php
    } ?><?php if ($_GET['code'] == "incorrectPass") {
        ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-danger emailExiste alert-dismissible fade show text-center animated tada slow" role="alert">
                <strong>Error!</strong> Tu contraseña es incorrecta, intentalo de nuevo.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <?php
        } ?><?php if ($_GET['code'] == "notExistUser") {
            ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  text-center animated tada slow">
            <div class="alert alert-danger emailExiste alert-dismissible fade show" role="alert">
                <strong>Error!</strong> El Correo no existe,por favor regístrate.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php
            } ?>
    <?php if ($_GET['code'] == "sendResetMail") {
    ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-success  alert-dismissible fade show animated tada slow" role="alert">
                <strong>Correcto!</strong> Se ha enviado un link de recuperación a tu correo.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php
    } ?>

    <?php if ($_GET['code'] == "passChanged") {
    ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-success  alert-dismissible fade show animated tada slow" role="alert">
                <strong>Correcto!</strong> Se ha cambiado la contraseña correctamente.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php
    } ?>
    <?php include 'shared/navBar.php' ?>
    <div class="container main-container animated fadeIn slow">

        <!-- Slider main container -->
        <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
               <!--  <div class="swiper-slide">
                    <a href="egipcio-carta.php">
                        <img class="img-fluid d-none d-md-block" src="assets/img/index/BANNER-DELIVERY-GRATIS.jpg" alt="">
                        <img class="img-fluid d-block d-md-none" src="assets/img/index/banner-movil.jpg" alt=""> 
                       

                    </a>
                </div> -->

                <div class="swiper-slide">
                    <a href="egipcio-carta.php">
                        <img class="img-fluid d-none d-md-block" src="assets/img/index/banner3horizontal.jpg" alt="">
                        <img class="img-fluid d-block d-md-none" src="assets/img/index/movil-3.jpg" alt="">


                    </a>
                </div>
                <!--    <div class="swiper-slide">
                    <a href="egipcio-carta.php">
                        <img class="img-fluid d-none d-md-block" src="assets/img/index/banner-de-descuento.jpg" alt=""> 
                        <img class="img-fluid d-block d-md-none" src="assets/img/index/BANNER_MOVIL_4.jpg" alt="">


                    </a>
                </div> -->
                <!--       <div class="swiper-slide">
                    <a href="egipcio-carta.php">
                        <img class="img-fluid d-none d-md-block" src="assets/img/index/BANNER_5.jpg" alt="">
                        <img class="img-fluid d-block d-md-none" src="assets/img/index/BANNER_MOVIL_5.jpg" alt="">
                    </a>
                </div> -->




            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>


        </div>

        <div class="row mb-3">
            <div class="col">
                <h2 class="titulo">EL EGIPCIO</h2>

            </div>
        </div>
        <div class="row mx-0 px-0 my-5">
            <div class="col-sm-12 col-sm-12 text-center mx-0 px-0">
                <a href="egipcio-carta.php" class="btn btn-danger bg-danger text-white font-weight-bolder">
                    <h3>ORDENA AQUÍ</h3>
                </a>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">

                <!-- <h2 class="titulo">▼ VIDEO ▼</h2> -->
                <h2 class="titulo">ZONA DE REPARTO</h2>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <!-- <video style="width: 100%" id="my-video" class="video-js vjs-theme-city" controls preload="auto" height="400" poster="assets/img/logo-grande.png" data-setup="{}">
                    <source src="assets/videos/video_elegipcio.mp4" type="video/mp4" />
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video> -->
                <iframe style="width: 100%" src="https://www.google.com/maps/d/embed?mid=12Xsx08UCym6oC2_5SNNJ7Z4Ye1AohUU&hl=es-419&ehbc=2E312F" height="580"></iframe>
            </div>
        </div>
    </div>
    <!--redes sociales a la derecha-->
    <div class="social">
        <ul>
            <li><a style="padding: 22px " href="https://www.facebook.com/elegipcio.pe" target="_blank" class="icon-facebook">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a></li>
            <li><a href="https://www.instagram.com/elegipcio.pe/" target="_blank" class="icon-instagram">
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </a></li>
            <!-- <li>
                <a href="https://api.whatsapp.com/send?phone=51981344827" target="_blank" class="icon-whatsapp">
                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                </a>
            </li> -->
            <li><a style="padding: 17px " href="https://api.whatsapp.com/send?phone=51981344827" target="_blank" class="icon-whatsapp">
                    <i class="fa fa-whatsapp"></i><br>
                    <span style="font-size:10px;margin:0px;padding:0%;">Lince</span>
                </a>
            </li>
            <li><a style="padding: 16px; background-color:#1fb154;" href="https://api.whatsapp.com/send?phone=51901236995" target="_blank" class="icon-whatsapp-san-borja">
                    <i class="fa fa-whatsapp"></i><br>
                    <span style="font-size:10px;margin:0px;padding:0px;">Surco</span><br>

                </a>

            </li>
        </ul>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center m-3" style="color: red;">
                <h3>¿Por qué comprar en elegipcio.pe?</h3>
            </div>

            <div class="col-md-4 mb-3"><img src="assets/tarjetas/icon-1.png" alt=""></div>
            <div class="col-md-4 mb-3"><img src="assets/tarjetas/icon-2.png" alt=""></div>
            <div class="col-md-4 mb-3"><img src="assets/tarjetas/icon-3.png" alt=""></div>
        </div>
    </div>

    <!-- Modal HTML -->
    <!-- <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-login">
            <div class="modal-content">
                
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <img src="assets/img/modal/avisodecuponweb.jpg" class="img-fluid" alt="">
                </div>

            </div>
        </div>
    </div> -->
    <?php include 'shared/footer.php' ?>
    <script src="vendor/swiper/swiper.min.js"></script>
    <script src="vendor/videojs/video.js"></script>
    <script src="assets/js/index.js?v=2"></script>
    <script>
        $(document).ready(function() {
            $('#myModal').modal('toggle')
        });
    </script>
</body>

</html>