<?php
session_start();
$page = 'contacto';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Contáctanos</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">
    <link rel="stylesheet" href="assets/css/contacto.css">
    <meta property="og:image" content="https://elegipcio.pe/assets/img/OpenGraph/ogContacto.jpg"/>
</head>
<body>
<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">
    <div class="row mb-3">
        <div class="col">
            <h2 class="titulo">CONTÁCTANOS</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="separador"></div>
        </div>
    </div>

    <section class="content-info py-3">


        <div class="text-center px-lg-5">
            <?php
            error_reporting(0);
            if ($_GET['code'] == "success") {
                ?>
                <style>

                    .alertaCorreo {
                        right: 0%;
                        left: 0%;
                    }


                    @media (min-width: 992px) {

                        .alertaCorreo {
                            right: 20%;
                            left: 16%;
                            margin-left: auto;
                            margin-right: auto;
                            max-width: 600px;
                        }
                    }

                </style>
                <div class="container alertaCorreo  ">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Mensaje enviado correctamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="title-desc text-center px-lg-5">

                <p>contactanos@elegipcio.pe</p>
               <!-- <p><i class="fa fa-phone" aria-hidden="true"></i> (01) 693 - 7012
                </p>-->
                <p><i class="fa fa-phone" aria-hidden="true"></i> 981 344 827 / (01) 7753323
                </p>
                <p>
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    Jr. Julio Cesar Tello 872 / 886 Lince, Lima - Perú
                </p>


            </div>
        </div>
        <div class="contact-w3pvt-form mt-5">
            <form onsubmit="mostrarLoading();" action="script/sendMail.php" class="w3layouts-contact-fm" method="post">
                <div class="row">
                    <div class="col-lg-6" style="">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" name="nombres" placeholder="" required="">
                        </div>
                        <div class="form-group">
                            <label>Apellido</label>
                            <input class="form-control" type="text" name="apellidos" placeholder="" required="">
                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input style="text-transform: none !important;" class="form-control m-0" type="email"
                                   name="correo" placeholder="" required="">
                        </div>
                        <div class="form-group removeArrows">
                            <label>Numero de Contacto</label>
                            <input style="text-transform: none !important;" class="form-control soloNumeros m-0" type="number"
                                   onkeypress="return isNumberKey(event)" name="celular" placeholder="" required="" min="1">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Escribe tu Mensaje</label>
                            <textarea class="form-control" name="mensaje" placeholder="" required=""></textarea>


                        </div>
                    </div>

                    <div class="col-lg-12 text-center">
                        <div style="display: inline-block" data-theme="dark" class="g-recaptcha "
                             data-sitekey="6Ld-sMcUAAAAAEgCFmhMra757oUJfa6oKLVBijr_"></div>

                        <div class="form-group ">
                            <button name="submit" style="color: white" type="submit" class="btn submit">Enviar</button>
                        </div>
                    </div>

                </div>

            </form>
        </div>

    </section>

    <div class="map-w3layouts">

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.369786496327!2d-77.04410198561739!3d-12.086817845936729!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c85862c99101%3A0x69d99ceb3f73a507!2sEL%20EGIPCIO!5e0!3m2!1ses-419!2spe!4v1587684443794!5m2!1ses-419!2spe"
                allowfullscreen ></iframe>
    </div>

    <div class="row mb-5">
        <div class="col text-center">

        </div>
    </div>

</div>
<?php include 'shared/footer.php' ?>
</body>
</html>
