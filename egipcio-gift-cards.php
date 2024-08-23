<?php
session_start();
$page = 'giftCards';


require 'class/ProductoClass.php';
require 'class/TiendaClass.php';
$objTienda = new TiendaClass();
$objProducto = new ProductoClass();
$lista = $objProducto->getTipoProductos(3);
$estadoTienda = trim($objTienda->getEstadoTienda()['estado']);

if (count($lista) < 1) {
    header("Status: 302 Found");
    header('location: egipcio-carta.php');
    exit();
}

//GENERANDO LOS META TAGS
$nombres = '';
foreach ($lista as $item) {
    $nombres = $nombres . ', ' . $item['nombreProducto'];
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Gift Cards</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">


    <!--Seo Meta Tags-->
    <meta name="title" content="Promociones - El Egipcio">
    <meta name="description" content="<?php echo substr($nombres, 0, 151) ?>">
    <meta name="keywords" content="<?php echo $nombres ?>">


    <meta property="og:description"
          content="<?php echo substr($nombres, 0, 151) ?>">
    <link rel="stylesheet" href="assets/css/seleccion_multiple.css">

</head>
<body>
<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">
    <div class="row mb-3">
        <div class="col">
            <h2 class="titulo">GIFT CARDS</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="separador"></div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3 mb-4" id="productsDataContainer">

    </div>
    <div class="row mb-5">
        <div class="col text-center">
            <small>▲ FOTOS REFERENCIALES ▲</small>

        </div>
    </div>

</div>
<div class="modal fade modalArmaTuBowl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="formSeleccion" method="post" action="script/cartAction.php">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h3 class="text-center text-egipcio m-0">¿A quien va dirigido el gift card?</h3>
                    <!--  <h5 class="text-center">A quien va dirigido el gift card ?<i
                                  class="fa fa-arrow-down animated bounce infinite slow" aria-hidden="true"></i></h5>-->

                    <input type="hidden" class="form-control" id="idModal" name="id">

                    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-3  p-3 justify-content-center">

                        <div class="col mb-2 mx-auto justify-content-center d-flex mt-2">
                            <div class="card h-100 card-products">
                                <div class="p-4">
                                    <img src="assets/img/icons/deposito.png" class="card-img-top"
                                         alt="...">

                                </div>

                                <div class="card-body p-2 d-flex flex-column">
                                    <h5 class="card-title titulo-cards">ES PARA MI</h5>
                                    <input value="personal" name="dirigidoA" class="d-none" type="radio"
                                           id="panIntegral">
                                    <label for="panIntegral"
                                           class="ingrediente-button w-100 align-self-end mt-auto">Elegir
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-2 mx-auto justify-content-center d-flex mt-2">
                            <div class="card h-100 card-products">
                                <div class="p-4">
                                    <img src="assets/img/icons/regalo.png" class="card-img-top"
                                         alt="...">

                                </div>

                                <div class="card-body p-2 d-flex flex-column">
                                    <h5 class="card-title titulo-cards">ES UN REGALO</h5>
                                    <input value="regalo" name="dirigidoA" class="d-none" type="radio"
                                           id="panFinasYerbas">
                                    <label for="panFinasYerbas"
                                           class="ingrediente-button w-100 align-self-end mt-auto">Elegir
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-2 justify-content-center animated fadeIn" id="correoDestinatarioRow">
                        <div class="col-12 col-sm-12 col-md-6 col-xl-4 col-lg-4 text-center">
                            <div class="form-group">
                                <label for="emailGift">Correo electrónico del destinatario:</label>
                                <input onkeyup="return forceLower(this);" id="emailGift" class="form-control m-0"
                                       type="text" name="emailGift">
                            </div>

                            <div class="form-group">
                                <label for="dedicatoriaGift">Dedicatoria:</label>
                                <input id="dedicatoriaGift" class="form-control m-0" type="text" name="dedicatoriaGift">
                            </div>

                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="col text-center">
                            <input type="hidden" name="action" value="addToCart">
                            <input type="hidden" name="cantidad" value="1">
                            <button type="submit" class="btn btn-success btn-lg">COMPRAR</button>
                        </div>
                    </div>

                </form>
            </div>


        </div>
    </div>
</div>
<?php include 'shared/footer.php' ?>
<script>

    const data = <?= json_encode($lista) ?>;
    let dataContainer = document.getElementById('productsDataContainer');


    if (localStorage.getItem('addressIsSelected')) {
        if (localStorage.getItem('addressIsSelected') === '1') {
            renderData(parseInt(localStorage.getItem('store')));
        }

    }

    function renderData(storeId) {
        data.filter(value => value.store_id * 1 === storeId).forEach(product => {
            dataContainer.innerHTML += objectToProductoCard(product);
        })
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
        card += '<p class="card-price">S/ ' + Number.parseFloat(product.precioProducto).toFixed(2)  + '</p>';


        if (product.stock === 'YES') {

            if (product.productoObservaciones === 'GIFT_CARD') {
                card += '<a data-toggle="modal" ' +
                    'data-target=".modalArmaTuBowl" ' +
                    'data-whatever="' + product.idProducto + '" href="#" ' +
                    ' class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
            } else {

                card += '<a onclick="mostrarLoading()"\n' +
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

    function isNull(stringData) {
        return stringData ? stringData : '';

    }


    $('.modalArmaTuBowl').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recipient = button.data('whatever'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body #idModal').val(recipient)
    });

    $(document).ready(function () {
        $('#emailGift').prop('required', false);
        $('#emailGift').prop("type", "text");
        $('#correoDestinatarioRow').hide();


        $('#formSeleccion input[type="radio"]').on('change', function (e) {

            /*console.log(this.value);*/
            if ($(this).val() == 'regalo') {
                $('#correoDestinatarioRow').show();
                $('#emailGift').prop('required', true);

                $('#emailGift').prop("type", "email")
            } else {
                $('#correoDestinatarioRow').hide();
                $('#emailGift').prop('required', false);
                $('#emailGift').prop("type", "text")
            }

        });


        $("#formSeleccion").submit(function () {
            console.log($('#formSeleccion input[name="dirigidoA"]:checked').length);
            if ($('#formSeleccion input[name="dirigidoA"]:checked').length == 0) {
                alert('Por favor seleccione una opción antes de continuar');
                return false;
            } else {
                if (isNull(localStorage.getItem('address')).length > 2
                    && isNull(localStorage.getItem('lat')).length > 2
                    && isNull(localStorage.getItem('lng')).length > 0) {
                    return true;
                }
                openAddressSelectorModal();
                return false;

            }

        });

    });


</script>
</body>
</html>
