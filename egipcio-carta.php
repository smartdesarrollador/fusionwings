<?php
session_start();
unset($_SESSION['estado_cupon']);
$page = 'carta';
require 'class/ProductoClass.php';
require 'class/TiendaClass.php';
$objTienda = new TiendaClass();
$objProducto = new ProductoClass();
$lista = $objProducto->getTipoProductosAndOrderByPosicion(2);


$estadoTienda = trim($objTienda->getEstadoTienda()['estado']);

//GENERANDO LOS META TAGS
$nombres = '';
foreach ($lista as $item) {
    $nombres = $nombres . ', ' . $item['nombreProducto'];
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta property="og:image" content="https://elegipcio.pe/assets/img/OpenGraph/ogCarta.png" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta https-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Carta</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">
    <link rel="stylesheet" href="assets/css/seleccion_multiple.css">
    <link rel="stylesheet" href="vendor/swiper/swiper.min.css">
    <style>
        del {

            text-decoration: none;
            position: relative;
        }

        del:before {
            content: " ";
            display: block;
            width: 100%;
            border-top: 3px solid rgba(255, 0, 0, 0.8);
            height: 16px;
            position: absolute;
            bottom: 0;
            left: 0;
            transform: rotate(-16deg);
        }
    </style>
</head>

<body>
    <?php include 'shared/navBar.php' ?>
    <?php if ($_GET['valor'] == "ordena") { ?>

    <?php } else { ?>
        <div class="container main-container">
            <!-- Slider main container -->
            <div class="swiper-container">
                <!-- Additional required wrapper -->
               <!-- <div class="swiper-wrapper">
                    <div class="swiper-slide">
                         <a href="egipcio-carta.php">
                            <img class="img-fluid d-none d-md-block" src="assets/img/index/banner_descuento.jpg" alt="" width="100%">
                            <img class="img-fluid d-block d-md-none" src="assets/img/index/banner_descuento.jpg" alt="" width="100%">


                        </a> 
                    </div> -->
                    <!-- <div class="swiper-slide">
                         <a href="egipcio-carta.php">
                            <img class="img-fluid d-none d-md-block" src="assets/img/index/banner_aniversario.jpg" alt="" width="100%">
                            <img class="img-fluid d-block d-md-none" src="assets/img/index/banner_aniversario_movil.jpg" alt="" width="100%">


                        </a> 
                    </div> -->

                     <div class="swiper-slide">
                        <a href="egipcio-carta.php">
                            <img class="img-fluid d-none d-md-block" src="assets/img/index/banner3horizontal.jpg" alt="">
                            <img class="img-fluid d-block d-md-none" src="assets/img/index/movil-3.jpg" alt="">


                        </a>
                    </div> 
                     <!-- <div class="swiper-slide">
                        <a href="egipcio-carta.php">
                            <img class="img-fluid d-none d-md-block" src="assets/img/index/banner4horizontal.jpg" alt="">
                            <img class="img-fluid d-block d-md-none" src="assets/img/index/bannermovil.jpg" alt="">


                        </a>
                    </div> -->

                             <!--  <div class="swiper-slide">
                        <a href="egipcio-carta.php">
                            <img class="img-fluid d-none d-md-block" src="assets/img/index/banner-el-egipcio_cyber.jpg" alt="">
                            <img class="img-fluid d-block d-md-none" src="assets/img/index/banner-el-egipcio_cyber.jpg" alt="">


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
            <!--  <div class="row mx-0 px-0 my-1">
                <div class="col-sm-12 col-sm-12 text-center mx-0 px-0">
                    <a href="egipcio-carta.php?valor=ordena" class="btn btn-danger bg-danger text-white font-weight-bolder">
                        <h3>ORDENA AQUÍ</h3>
                    </a>
                </div>
            </div> -->
        </div>
    <?php } ?>

    <?php if ($_GET['valor'] == "ordena") { ?>
        <div class="container main-container animated fadeIn slow mb-5">
            <div class="row mb-3">
                <div class="col">
                    <h2 class="titulo">CARTA</h2>
                </div>
            </div>
        <?php } else { ?>
            <div class="container animated fadeIn slow mb-5">
            <?php } ?>

            <!-- <div class="row mb-3">
            <div class="col">
                <h2 class="titulo">CARTA</h2>
            </div>
        </div> -->

            <div class="row mt-3 mb-3">
                <div class="col">
                    <div class="separador"></div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 justify-content-center" id="productsDataContainer">

            </div>


            <div class="row mb-5">
                <div class="col text-center">
                    <small>▲ FOTOS REFERENCIALES ▲</small>

                </div>
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
            <div class="" id="productsDataContainerModal">

            </div>
            <script src="assets/js/egipcio-carta.js"></script>
            <script>
                $(document).ready(function() {
                    $('#myModal').modal('toggle')
                });
            </script>
            <script>
                const data = <?= json_encode($lista) ?>;
                let dataContainer = document.getElementById('productsDataContainer');

                let dataContainerModal = document.getElementById('productsDataContainerModal');


                if (localStorage.getItem('addressIsSelected')) {
                    if (localStorage.getItem('addressIsSelected') === '1') {
                        renderData(parseInt(localStorage.getItem('store')));
                    }

                }

                function renderData(storeId) {
                    data.filter(value => value.store_id * 1 === storeId).forEach(product => {
                        dataContainer.innerHTML += objectToProductoCard(product);

                    });

                    if (storeId == 2) {
                        dataContainerModal.innerHTML += objectToModalSurco();
                    }

                    dataContainerModal.innerHTML += objectToModalCombo();

                }

                function objectToProductoCard(product) {
                    let card = '<div class="col mb-5 animated fadeIn"><div class="card h-100 card-products">' +
                        '<img src="assets/img/promos/' + product.imagenProducto + '" class="card-img-top" alt="...">\n' +
                        '                    <div class="card-body p-2 d-flex flex-column">';
                    if (product.esNuevo === 'TRUE') {
                        card += '<h5 class="text-egipcio mt-2">\n' +
                            '                                !NUEVO PRODUCTO!\n' +
                            '                            </h5>'
                    }
                    card += '<h5 class="card-title titulo-cards">' + product.nombreProducto + '</h5>\n' +
                        '                        <p class="card-text">' + isNull(product.descripcionProducto) + '</p>\n' +
                        '                        <p class="card-points-description">';
                    if (product.acumulaNPuntos * 1 > 0) {
                        card += 'Acumula  ' + product.acumulaNPuntos + ' puntos';
                    }
                    card += '</p>'
                    if (product.precioDescuento * 1 > 0) {
                        card += '<h5 class="card-price">\n' +
                            '                                <del>S/. ' + product.precioDescuento + '</del>\n' +
                            '                            </h5>'
                    }
                 /* if (product.store_id === '1' || product.store_id === '2') { 
                        
                            card += '<p class="card-price">S/ <del>' + Number.parseFloat(product.precioTachado).toFixed(2) + '</del></p>';
                        
                     }*/

                    /*if (product.idProducto == 222 || product.idProducto == 322 || product.idProducto == 380) {
                        card += '<p class="card-price">S/ <del>' + Number.parseFloat(product.precioTachado).toFixed(2) + '</del></p>';
                    } */


                    card += '<p class="card-price">S/ ' + Number.parseFloat(product.precioProducto).toFixed(2) + '</p>';


                    if (product.stock === 'YES') {

                        if (product.productoObservaciones === 'MULTI_BOWL') {
                            card += '<a onclick="buyProductAndValidate(event)"\n' + 'href="egipcio-shawerma-bowl.php?id=' + product.idProducto + '"\n' +
                                'class="comprar-button w-100 align-self-end mt-auto">Arma tu Bowl</a>'
                        } else if (product.productoObservaciones === 'MULTI_SHAWERMA') {
                            card += ' <a onclick="buyProductAndValidate(event)"\n' + ' data-whatever="' + product.idProducto + '"\n' +
                                '                             href="egipcio-shawerma-premium.php?id=' + product.idProducto + '"\n' +
                                '                           class="comprar-button w-100 align-self-end mt-auto">Arma tu Shawerma</a>'
                        } else if (product.productoObservaciones === 'MULTI_FALAFEL') {
                            card += '<a onclick="buyProductAndValidate(event)"\n' +
                                '                                            href="egipcio-falafel-premium.php?id=' + product.idProducto + '"\n' +
                                '                                            class="comprar-button w-100 align-self-end mt-auto">Arma tu Falafel</a>'
                        } else if (product.productoObservaciones === 'MULTI_COMBO_AL_PESO1') {
                            card += ' <a onclick="buyProductAndValidate(event)" href="egipcio-combo-al-peso-pollo.php?id=' + product.idProducto + '" class="comprar-button w-100 align-self-end mt-auto">' +
                                'Arma tu Combo</a>'
                        } else if (product.productoObservaciones === 'MULTI_COMBO_AL_PESO2') {
                            card += '<a onclick="buyProductAndValidate(event)" href="egipcio-combo-al-peso-mixto.php?id=' + product.idProducto + '"\n' +
                                '                                       class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
                        } else if (product.productoObservaciones === 'SALSA_ALITAS') {
                            card += '<a onclick="buyProductAndValidate(event)" href="egipcio-salsa-alitas.php?id=' + product.idProducto + '"\n' +
                                '                                       class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
                        } else if (product.productoObservaciones === 'PROMO_PERU') {
                            card += '<a onclick="buyProductAndValidate(event)" href="egipcio-promo-peru.php?id=' + product.idProducto + '"\n' +
                                '                                       class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
                        } else if (product.productoObservaciones === 'COMBO_FAMILIAR') {
                            card += '<a onclick="buyProductAndValidate(event)" href="egipcio-combo-familiar.php?id=' + product.idProducto + '"\n' +
                                '                                       class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
                        } else if (product.productoObservaciones === 'SHAWERMA_MIXTO') {
                            card += '<a onclick="buyProductAndValidate(event)" href="egipcio-shawerma-mixto.php?id=' + product.idProducto + '"\n' +
                                '                                       class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
                        } else if (product.productoObservaciones === 'COMBO_TENDERS') {
                            card += '<a onclick="buyProductAndValidate(event)" href="egipcio-combo-tenders.php?id=' + product.idProducto + '"\n' +
                                '                                       class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
                        } else {

                            card += '<a onclick="buyProductAndValidate(event)"\n' +
                                '                                       href="script/cartAction.php?action=addToCart&id=' + product.idProducto + '&cantidad=1"\n' +
                                '                                    class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
                        }

                    } else {

                        card += '<button type="button" class="comprar-button w-100 align-self-end mt-auto">AGOTADO\n' +
                            '                                </button>'

                    }

                    card += '</div>\n' +
                        '                </div>\n' +
                        '            </div>';
                    return card;
                }

                function objectToModalSurco() {
                    //let modal = '<div id="modal_comunicado" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><a href="#"><img class="img-fluid" src="assets/img/promo_combo_familiar.jpg" height="600px" width="100%"/></a></div></div></div></div>'; 
                    //let modal = '<div id="modal_comunicado" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><video class="embed-responsive-item" style="width: 100%; height: 100%; margin-right: 10px; margin-bottom: 10px;" autoplay controls><source src="assets/videos/video-barbie.mp4" type="video/mp4"></video></div></div></div></div>';
                    return modal;
                }

                function objectToModalCombo() {
                    //let modal = '<div id="modal_comunicado" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><a href="#"><img class="img-fluid" src="assets/img/promo_combo_familiar.jpg" height="600px" width="100%"/></a></div></div></div></div>'; 
                    //let modal = '<div id="modal_comunicado" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><video class="embed-responsive-item" style="width: 100%; height: 100%; margin-right: 10px; margin-bottom: 10px;" autoplay controls><source src="assets/videos/video-barbie.mp4" type="video/mp4"></video></div></div></div></div>';
                    return modal;
                }
            </script>

</body>

</html>