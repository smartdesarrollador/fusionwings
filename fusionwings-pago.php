<?php
session_start();
unset($_SESSION['estado_cupon']);
error_reporting(0);
$page = 'carrito';
include 'class/Cart.php';
error_reporting(0);
$cart = new Cart;

$cartItems = $cart->contents();
require 'class/TiendaClass.php';
require 'class/ProductoClass.php';
$objTienda = new TiendaClass();
$objProducto = new ProductoClass();

$estadoTienda = trim($objTienda->getEstadoTienda()['estado']);
$costoEnvio = trim($objTienda->getCostoEnvio()['costoDelivery']);
$adicionales = $objProducto->getAdicionales();


/*DESCUENTO POR PUNTOS*/
$descuento = 0;


if ($_SESSION['current_customer_puntos'] >= 100) {
    $descuento = 10;
}

/*if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {

}else{
    header('location: index.php');
    exit();
}*/

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fusion Wings - Bolsa de compras</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">
    <link rel="stylesheet" href="assets/css/carrito.css">
</head>

<body>

    <?php include 'shared/navBar.php' ?>
    <div class="container main-container animated fadeIn slow mb-5">

        <div class="row m-2">
            <div class="col-12 col-sm-12 col-md-12 col-xl-9 col-lg-9">
                <div class="row">
                    <div class="col contenedor-carrito p-2">
                        <div class="row mb-3">
                            <div class="col">
                                <h2 class="titulo">BOLSA DE COMPRAS</h2>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="separador"></div>
                            </div>
                        </div>


                        <?php
                        $subtotal = 0;
                        $puntosAacumular = 0;
                        if ($cart->total_items() > 0) {


                            $nAdicionalesCart = 0;
                            foreach ($cartItems as $itemCarrito) {

                                if ($itemCarrito['productoObservaciones'] == 'ADICIONAL') {
                                    $nAdicionalesCart = $nAdicionalesCart + 1;
                                }

                                $subtotal = $subtotal + $itemCarrito['subtotal'];


                                $puntosAacumular = $puntosAacumular + $itemCarrito['subtotalPuntos'];


                        ?>

                                <div class="row mt-3">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 text-center">
                                        <h4><?php echo $itemCarrito['name'] ?></h4>
                                        <small class="text-lowercase d-block text-muted"><?php echo substr($itemCarrito['productoIngredientes'], 0, -2) ?></small>

                                        <?php
                                        if (strlen($itemCarrito['emailGift']) > 0) {
                                        ?>
                                            <small class=" d-block text-muted">Para: <?php echo $itemCarrito['emailGift'] ?></small>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (strlen($itemCarrito['dedicatoriaGift']) > 0) {
                                        ?>
                                            <small class=" d-block text-muted">Dedicatoria: <?php echo $itemCarrito['dedicatoriaGift'] ?></small>
                                        <?php
                                        }
                                        ?>

                                        <img class="cart-image" src="assets/img/promos/<?php echo $itemCarrito['imagenProducto'] ?>" alt="">
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 d-flex justify-content-center align-items-center">
                                        <div>
                                            <h5 class="text-center">Cantidad</h5>
                                            <div class="row mt-1">
                                                <div class="col text-center">
                                                    <a onclick="mostrarLoading()" href="script/cartAction.php?action=updateCartItem&id=<?php echo $itemCarrito['rowid']; ?>&qty=<?php echo $itemCarrito['qty'] - 1; ?>" class="btn btn-sm"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                    <input readonly class="text-center" style="width: 60px" type="text" value="<?php echo $itemCarrito['qty']; ?>">
                                                    <a onclick="mostrarLoading()" href="script/cartAction.php?action=updateCartItem&id=<?php echo $itemCarrito['rowid']; ?>&qty=<?php echo $itemCarrito['qty'] + 1; ?>" class="btn btn-sm "><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 text-center d-flex justify-content-center align-items-center">
                                        <div>
                                            <h5>Precio</h5>
                                            <h5><?php echo number_format($itemCarrito['price'], 2, '.', ''); ?></h5>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 text-center d-flex justify-content-center align-items-center">
                                        <div>
                                            <h5 class="font-weight-bolder">SubTotal</h5>
                                            <h5 class="font-weight-bolder">S/ <?php echo number_format($itemCarrito['subtotal'], 2, '.', ''); ?>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1 text-center d-flex justify-content-center align-items-center">
                                        <div>
                                            <a onclick="mostrarLoading();" href="script/cartAction.php?action=removeCartItem&id=<?php echo $itemCarrito['rowid']; ?>" class="btn btn-sm btn-outline-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </div>
                                    </div>

                                </div>
                                <hr class=" d-sm-block d-md-block d-xl-none d-lg-none">


                            <?php
                            }
                            ?>
                            <div class="row mt-3">
                                <div class="col text-center">
                                    <a onclick="mostrarLoading();" class="" href="script/cartAction.php?action=destroyCart">Vaciar
                                        Carrito</a>
                                </div>

                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="row mb-3">
                                <div class="col col-12 text-center mt-4">
                                    <i style="font-size: 100px;color: #fff000" class="fa fa-shopping-cart"></i>
                                    <h5 class="py-3">Tu carrito está vacío</h5>
                                    <a href="fusionwings-carta.php" class="comprar-button">IR A COMPRAR</a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </div>
                </div>
                <div class="row mt-5 mb-4">
                    <div class="col text-center text-xl-left text-lg-left">
                        <a class="btn btn-lg btn-danger animated infinite bounce slow btn-seguirComprando" href="fusionwings-carta.php">
                            SEGUIR COMPRANDO
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col contenedor-carrito p-5 ">
                        <div class="row mb-3">
                            <div class="col">
                                <h2 class="titulo ">TOTAL A PAGAR:</h2>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="separador-subrayado-titulo"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5>Subtotal:</h5>

                            </div>
                            <div class="col">
                                <h5>S/ <?php echo number_format($subtotal, 2, '.', ''); ?></h5>

                            </div>
                        </div>


                        <?php
                        if ($_SESSION['solo_gift_cards'] == 'false') {
                        ?>
                            <div class="row mt-4">
                                <div class="col">
                                    <h5>Método de envío: </h5>

                                </div>
                                <div class="col">

                                    <div id="orderTypeDescription"></div>
                                    <a style="cursor: pointer" class="text-info" onclick="openAddressSelectorModal()">Cambiar<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                </div>

                            </div>
                        <?php

                        }
                        ?>


                        <div class="row mb-3 mt-1">
                            <div class="col">
                                <div class="separador-subrayado-titulo"></div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <h5>TOTAL A PAGAR:</h5>

                            </div>
                            <div class="col">
                                <h5 class="font-weight-bolder">S/. <?php echo number_format($cart->total(), 2, '.', ''); ?></h5>

                            </div>
                        </div>


                        <div class="row mt-4">

                            <div class="col">
                                <h5 class="font-weight-bolder text-success">Con esta compra
                                    acumulas <?php echo $puntosAacumular; ?> puntos</h5>
                            </div>
                        </div>


                        <div class="row mt-5">
                            <div class="col text-center">
                                <!--  <h3>
                                Nuestro Delivery Web atiende de Lunes a Sábado de 12:30 pm a 9:00 pm
                            </h3> -->

                                <div id="ContainerJesusMaria"></div>
                                <h6>
                                    Mientras tanto, puedes escoger lo que deseas ordenar hoy y guardarlo en tu bolsa de
                                    compras.
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col text-center text-xl-left text-lg-left">

                        <?php
                        if ($subtotal > 0) {


                            if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {
                        ?>

                                <?php
                                if ($subtotal < 18 && $_SESSION['envio'] != 'recojo') {
                                ?>
                                    <a onclick="pedidoMinimoAdvertencio()" class="btn btn-lg btn-danger animated infinite tada slow btn-pedir font-weight-bolder">
                                        PAGAR
                                    </a>
                                <?php
                                } else {
                                ?>
                                    <a onclick="goToCheckout()" class="btn btn-lg btn-danger animated infinite tada slow btn-pedir font-weight-bolder">
                                        PAGAR
                                    </a>

                                <?php
                                }
                                ?>


                            <?php } else {
                            ?>
                                <a class="btn btn-lg btn-danger animated infinite tada slow btn-pedir font-weight-bolder" href="" data-toggle="modal" data-target="#login-modal">
                                    PEDIR
                                </a>

                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-xl-3 col-lg-3">
                <div class="row mb-3 mt-4 mt-md-4 mt-xl-1 mt-lg-1">
                    <div class="col text-center">
                        <h3 class="titulo">Complementos</h3>
                    </div>
                </div>


                <?php
                $progressWidth = round(($nAdicionalesCart / 3) * 100, 2)
                ?>
                <div class="row mb-3">
                    <div class="col text-center">
                        <div class="progress" style="border: 2px solid #9C0001;">
                            <div class="progress-bar progress-bar-complementos progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $progressWidth; ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>


                <div id="adicionalesContainer" class="p-3"></div>

            </div>
        </div>


    </div>

    <?php include 'shared/footer.php' ?>
    <div class="" id="productsDataContainerModal">

    </div>
    <script>
        function pedidoMinimoAdvertencio() {
            Swal.fire(
                'El pedido mínimo es 18 soles',
                '',
                'info'
            )
        }


        function goToCheckout() {
            if (localStorage.getItem('addressIsSelected') === '1') {
                Promise.all([setMetodoDenvio(localStorage.getItem('shippingType')), setDeliveryZoneId(isNull(localStorage.getItem('deliveryZoneId')))])
                    .then(value => value.map(value1 => value1.text())).then(value2 => {
                        value2[1].then(value3 => {

                            const store = JSON.parse(value3);

                            if (store.ok === 'true') {
                                if (store.data.acepta_pedidos === 'TRUE') {
                                    window.location = 'pagar.php';
                                } else {
                                    Swal.fire(
                                        'Lo sentimos',
                                        'En este momento, nuestras tiendas no están disponibles',
                                        'info'
                                    )
                                }
                            } else {
                                openAddressSelectorModal();
                            }

                        })
                    });
            } else {
                openAddressSelectorModal();
            }
        }

        function setShippingCost() {

        }
    </script>
    <script>
        const data = <?= json_encode($adicionales) ?>;
        let dataContainer = document.getElementById('adicionalesContainer');

        let dataContainerJesusMaria = document.getElementById('ContainerJesusMaria');

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

            /* if(storeId == 2){
                            dataContainerModal.innerHTML += objectToModalSurco();
                        } */

            if (storeId == 3) {
                dataContainerJesusMaria.innerHTML += objectToJesusMaria();
            } else if (storeId == 2) {
                dataContainerJesusMaria.innerHTML += objectToSurco();
            } else {
                dataContainerJesusMaria.innerHTML += objectToLocales();
            }
        }

        function objectToProductoCard(product) {
            let card = '<div class="col mb-5 animated fadeIn"><div class="card h-100 card-products">' +
                '<img src="assets/img/promos/' + product.imagenProducto + '" class="card-img-top" alt="...">\n' +
                '                    <div class="card-body p-2 d-flex flex-column">';
            if (product.esNuevo === 'TRUE') {
                card += '<h5 class="text-fusionwings mt-2">\n' +
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
            card += '<p class="card-price">S/ ' + Number.parseFloat(product.precioProducto).toFixed(2) + '</p>';


            if (product.stock === 'YES') {

                if (product.productoObservaciones === 'MULTI_BOWL') {
                    card += '<a\n' + 'href="fusionwings-shawerma-bowl.php"\n' +
                        'class="comprar-button w-100 align-self-end mt-auto">Arma tu Bowl</a>'
                } else if (product.productoObservaciones === 'MULTI_SHAWERMA') {
                    card += ' <a onclick="buyProductAndValidate(event)"\n' + ' data-whatever="' + product.idProducto + '"\n' +
                        '                             href="fusionwings-shawerma-premium.php"\n' +
                        '                           class="comprar-button w-100 align-self-end mt-auto">Arma tu Shawerma</a>'
                } else if (product.productoObservaciones === 'MULTI_FALAFEL') {
                    card += '<a onclick="buyProductAndValidate(event)"\n' +
                        '                                            href="fusionwings-falafel-premium.php"\n' +
                        '                                            class="comprar-button w-100 align-self-end mt-auto">Arma tu Falafel</a>'
                } else if (product.productoObservaciones === 'MULTI_COMBO_AL_PESO1') {
                    card += ' <a href="fusionwings-combo-al-peso-pollo.php" class="comprar-button w-100 align-self-end mt-auto">' +
                        'Arma tu Combo</a>'
                } else if (product.productoObservaciones === 'MULTI_COMBO_AL_PESO2') {
                    card += '<a onclick="buyProductAndValidate(event)" href="fusionwings-combo-al-peso-mixto.php"\n' +
                        '                                       class="comprar-button w-100 align-self-end mt-auto">Arma tu Combo</a>'
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

        /* function objectToModalSurco() {
                           let modal = '<div id="modal_comunicado" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><img class="img-fluid" src="assets/img/comunicado-surco.jpg" height="600px" width="100%"/></div></div></div></div>'; 
                                
                                return modal;
                        } */

        function objectToJesusMaria() {
            let horario = '<h3>Nuestro Delivery Web atiende de Lunes a Sábado de 12:00 pm a 10:00 pm</h3>';

            return horario;
        }

        function objectToSurco() {
            let horario = '<h3>Nuestro Delivery Web atiende de Lunes a Sábado de 12:30 pm a 9:30 pm</h3>';

            return horario;
        }

        function objectToLocales() {
            let horario = '<h3>Nuestro Delivery Web atiende de Lunes a Sábado de 12:30 pm a 9:30 pm</h3>';

            return horario;
        }

        function renderShippingMethod() {
            const orderTypeDescription = document.getElementById('orderTypeDescription');
            console.log(orderTypeDescription);
            if (localStorage.getItem('addressIsSelected') !== '1') {
                return false;
            }
            if (localStorage.getItem('shippingType') === 'DELIVERY') {
                orderTypeDescription.innerHTML = `
               <h5>Delivery <i class="fa fa-motorcycle" aria-hidden="true"></i></h5>
            `;
            }
            if (localStorage.getItem('shippingType') === 'RECOJO') {
                orderTypeDescription.innerHTML = `
               <h5>Recojo en tienda</h5>
            `;
            }
        }

        renderShippingMethod();
    </script>
</body>

</html>