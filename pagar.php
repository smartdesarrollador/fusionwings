<?php

session_start();
error_reporting(0);
include 'class/Cart.php';
include 'class/ClienteClass.php';
include 'class/Pedido.php';
include 'class/TiendaClass.php';
include 'class/Delivery.php';

$objtienda = new TiendaClass();
$objCliente = new ClienteClass();
$objDelivery = new Delivery();
$objPedido = new Pedido();

$deliveryZone = $objDelivery->getDeliveryZoneById($_SESSION['deliveryZoneId']);

/* echo $deliveryZone['idTienda'];
exit(); */

$cliente = $objCliente->getAllInformationUserById($_SESSION['current_customer_idCliente']);

$tienda = $objtienda->getDatosTienda($deliveryZone);
//$codigo_cupon = $tienda['cupon'];

/* 1 - Promocion primer cliente PPC01  */
$numPedidosCliente = $objPedido->numPedidosCliente($_SESSION['current_customer_idCliente']);
/* /1 - Promocion primer cliente PPC01 */

/* echo $numPedidosCliente;
exit(); */

$codigo_cupon = $_SESSION['codigo_cupon'];



$cart = new Cart();
$cartItems = $cart->contents();
$cartTotal = $cart->total();

$cartTotalOriginal = $cartTotal;
$descuento_cupon = 0;

if ($_SESSION['estado_cupon']) {

    if ($_SESSION['estado_cupon'] == "activo" && $cartTotal >= $tienda['cantidadTotal']) {
        /* $cartTotal = $cartTotal + ((20/100) * $cartTotal); */
        $descuento_cupon = ($tienda["descuento"] / 100) * $cartTotal;
        /* echo $descuento_cupon;
        exit(); */
    } else {
        $descuento_cupon = 0;
    }
}

/* echo ($cartTotal + ((20/100) * $cartTotal));
exit(); */

$descuento_total = $descuento_cupon;

$page = 'pagar';
$faltanNPuntos = 100 - $_SESSION['current_customer_puntos'];

$descuento = 0;

if ($_SESSION['current_customer_puntos'] >= 100) {
    /* $descuento_total = 10 + $descuento_total; */
    $descuento_total = 0 + $descuento_total;
}

if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {
} else {
    header('location: index.php');
    exit();
}
if (count($cartItems) <= 0) {
    header('location: fusionwings-carta.php');
}

$saldoBilletera = round($cliente['saldoBilletera']);


$costoEnvio = 0;
if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
    $costoEnvio = 0;
} else {
    $costoEnvio = $deliveryZone['price'];
}

/*------------- Calcular valor total -----------*/

$total_izi = 1;

if ($descuento_total > 0) {
    $total_izi = $cartTotal - $descuento_total;
} else {
    $total_izi = $cartTotal;
}

if ($_SESSION['solo_gift_cards'] == 'true') {
    $total_izi = $cartTotal;
} else {

    if ($saldoBilletera < $total_izi) {
        $total_izi = $total_izi - $saldoBilletera;
    } elseif ($saldoBilletera >= $total_izi) {
        $total_izi = 1;
    }
}

if ($total_izi == 0) {
    $total_izi = 1;
}

if ($total_izi == 1) {
    $total_izi = 1;
} else {
    $total_izi = $total_izi + $costoEnvio;
}

/* if (is_int($total_izi)) {
    $total_izi = $total_izi . "00";
} else {
    $total_izi = $total_izi * 100;
} */

/*-------------/Calcular valor total ----------- */

/** ------------- 1  Izipay ----------- */
/**
 * Embbeded Form minimal integration example
 * 
 * To run the example, go to 
 * hhttps://github.com/lyra/rest-php-example
 */

/**
 * I initialize the PHP SDK
 */

$zona_tienda = $deliveryZone['idTienda'];

require_once __DIR__ . '/izipay_vendor/autoload.php';



if ($zona_tienda == '1') {
    require_once __DIR__ . '/keys_lince.php';

    //$total_izi = $total_izi . "00";
    if (is_int($total_izi)) {
        $total_izi = $total_izi . "00";
    } else {
        //$total_izi = round($total_izi, 2);
        $total_izi = $total_izi * 100;
    }
}

if ($zona_tienda == '2') {
    require_once __DIR__ . '/keys_surco.php';

    if (is_int($total_izi)) {
        $total_izi = $total_izi . "00";
    } else {
        //$total_izi = round($total_izi, 2);
        $total_izi = $total_izi * 100;
    }
}

if ($zona_tienda == '3') {
    require_once __DIR__ . '/keys_jesus_maria.php';

    //$total_izi = $total_izi . "00";
    if (is_int($total_izi)) {
        $total_izi = $total_izi . "00";
    } else {
        //$total_izi = round($total_izi, 2);
        $total_izi = $total_izi * 100;
    }
}

if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {


    if (is_int($total_izi)) {
        $total_izi = $total_izi . "00";
    } else {
        $total_izi = round($total_izi, 2);

        $total_izi = $total_izi * 1;
    }
}


$total_izi = round($total_izi);

//echo $total_izi;
//exit();

require_once __DIR__ . '/helpers.php';

/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();

/**
 * I create a formToken
 */

$email_pedido = $_SESSION['current_customer_email'];
$nombre_pedido = $_SESSION['current_customer_nombre'];
$apellido_pedido = $_SESSION['current_customer_apellido'];



if ($descuento_total > 0) {

    if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
        $_SESSION['monto_real'] = $cartTotal;
        $_SESSION['monto_con_descuento'] = $total_izi;
        $_SESSION['estado_descuento'] = 'true';
        $_SESSION['codigo_cupon'] = $codigo_cupon;
    } else {
        $_SESSION['monto_real'] = $cartTotal + $costoEnvio;
        $_SESSION['monto_con_descuento'] = $total_izi;
        $_SESSION['estado_descuento'] = 'true';
        $_SESSION['codigo_cupon'] = $codigo_cupon;
    }
} else {

    $_SESSION['monto_real'] = $total_izi;
    $_SESSION['estado_descuento'] = 'false';
    $_SESSION['monto_con_descuento'] = 0;
    $_SESSION['codigo_cupon'] = 'Sin cupon';
}

$store = array(
    "amount" => $total_izi,
    "currency" => "PEN",
    "orderId" => uniqid("MyOrderId"),
    "customer" => array(
        "email" => trim($email_pedido),
        "billingDetails" => array(
            "lastName" => $nombre_pedido,
            "firstName" => $nombre_pedido
        )
    )
);
$response = $client->post("V4/Charge/CreatePayment", $store);

/* I check if there are some errors */
if ($response['status'] != 'SUCCESS') {
    /* an error occurs, I throw an exception */
    display_error($response);
    $error = $response['answer'];
    throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage']);
}

/* everything is fine, I extract the formToken */
$formToken = $response["answer"]["formToken"];

/** ------- /1  Izipay ------------ */
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fusion Wings - pagar</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/carrito.css">
    <script src="https://checkout.culqi.com/js/v3"></script>
    <style>
        .buybutton {
            width: 139px;
            color: #fff !important;
            background: #FF6900;
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
    <!-- 2 izipay -->
    <!-- Javascript library. Should be loaded in head section -->
    <script src="<?php echo $client->getClientEndpoint(); ?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js" kr-public-key="<?php echo $client->getPublicKey(); ?>" kr-post-url-success="script/checkout.php">
    </script>

    <!-- theme and plugins. should be loaded after the javascript library -->
    <!-- not mandatory but helps to have a nice payment form out of the box -->
    <link rel="stylesheet" href="<?php echo $client->getClientEndpoint(); ?>/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script src="<?php echo $client->getClientEndpoint(); ?>/static/js/krypton-client/V4.0/ext/classic.js">
    </script>
    <!-- /2 izipay -->
</head>

<body>
    <?php include 'shared/navBar.php' ?>
    <div class="container main-container animated fadeIn slow mb-5">
    </div>
    <?php if ($_SESSION['current_customer_puntos'] < 100) { ?>
        <h5 class="bg-success text-white text-center p-4">
            <strong><?php echo $_SESSION['current_customer_nombre']; ?></strong>, Tienes
            <strong><?php echo $_SESSION['current_customer_puntos']; ?></strong> puntos. ¡Necesitas
            solo <?php echo $faltanNPuntos; ?> más para poder obtener un descuento de S/.10 en tu próxima compra!

        </h5>
    <?php } else { ?>
        <h5 class="bg-success text-white text-center p-4"><strong>Mauro, Tienes 100 puntos. ¡Cada 100 puntos es un
                descuento
                de S/.10 en una compra! ¡Felicidades!</h5>
        <h5 class="text-center">Se envio a tu correo un Codigo de Cupon de Descuento . Si no te llego el correo hacer click
            <a href="#">Aqui</a>
        </h5>

    <?php } ?>
    <div class="container mb-5">
        <div class="row mb-3">
            <div class="col">
                <h2 class="titulo">TU PEDIDO</h2>
            </div>
        </div>
        <div class="row ">
            <div class="col">
                <div class="separador-subrayado-titulo"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php
                if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
                ?>
                    <input type="hidden" value="-" class="form-control" id="direccion" name="name">
                    <input type="hidden" value="<?php echo (isset($cliente['distrito']) || strlen($cliente['distrito']) > 2) ? $cliente['distrito'] : '-' ?>" class="form-control" id="distrito" name="name"> <input type="hidden" value="-" class="form-control" id="referencia" name="name">
                    <input type="hidden" id="longitud" value="">
                    <input type="hidden" id="latitud" value="">
                <?php
                } else {
                ?>
                    <div class="row mt-4">
                        <div class="col-12 col-sm-12 col-md-6">
                            <h5>Dirección De Entrega:</h5>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="form-group mx-sm-3 mb-2 ">
                                <label for="direccion" class="sr-only">Dirección De Entrega</label>
                                <input readonly type="text" class="form-control m-0" id="direccion" placeholder="Dirección De Entrega">
                                <small><a href="javascript:;" onclick="openAddressSelectorModal()">Cambiar
                                        dirección</a></small>
                                <input type="hidden" id="longitud" value="">
                                <input type="hidden" id="latitud" value="">
                            </div>
                        </div>
                    </div>
                    <div id="map-title" class="d-none">
                        <small>
                            <strong>
                                Si es necesario, precisa tu ubicación en el mapa.
                            </strong>
                        </small>
                    </div>
                    <div id="map"></div>
                    <div class="row mt-4">
                        <div class="col">
                            <h5>Distrito:</h5>
                        </div>
                        <div class="col">
                            <div class="form-group mx-sm-3 mb-2  removeArrows">
                                <label for="distrito" class="sr-only">Distrito</label>
                                <input value="<?php echo $cliente['distrito']; ?>" type="text" class="form-control m-0" id="distrito" placeholder="distrito">
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row mt-4">
                    <div class="col">
                        <h5>Teléfono / celular:</h5>
                    </div>
                    <div class="col">
                        <div class="form-group mx-sm-3 mb-2  removeArrows">
                            <label for="telefono" class="sr-only">Teléfono</label>
                            <input onkeypress="return isNumberKey(event)" value="<?php echo $_SESSION['current_customer_telefono']; ?>" type="number" class="form-control m-0" id="telefono" placeholder="Teléfono/celular">
                        </div>
                    </div>
                </div>
                <?php
                if ($_SESSION['envio'] == 'recojo' && $_SESSION['solo_gift_cards'] == 'false') {
                ?>

                    <div class="row mt-4">
                        <div class="col-12 col-sm-12 col-md-6">
                            <h5>Lugar de Recojo:</h5>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="form-group mx-sm-3 mb-2 ">
                                <label for="direccion" class="sr-only">Local de Entrega</label>
                                <input readonly type="text" value="<?= $deliveryZone['direccion_tienda'] ?>" class="form-control m-0">
                                <small><a href="javascript:;" onclick="openAddressSelectorModal()">Cambiar
                                    </a></small>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="localId" value="<?= $deliveryZone['idTienda'] ?>">
                <?php
                } else {
                ?>
                    <input type="hidden" id="localId" value="1">

                <?php
                }
                ?>


                <div class="row mt-4 mb-4">
                    <div class="col-6">
                        <h4 class="text-fusionwings">Observaciones / Programacion de pedido:</h4>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <textarea class="form-control mx-sm-3 mb-2 " id="mensaje" rows="3"><?php echo $_SESSION['current_customer_mensaje'] ?></textarea>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="row ">
            <div class="col">
                <div class="separador-subrayado-titulo"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" required type="radio" name="documento" id="factura" value="factura">
                    <label class="form-check-label" for="factura">
                        Deseo factura
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="documento" id="boleta" value="boleta">
                    <label class="form-check-label" for="boleta">
                        Deseo Boleta
                    </label>
                </div>
            </div>
        </div>
        <div id="facturaContainer" class="m-0 p-0 animated fadeIn">
            <div class="row mt-4">
                <div class="col">
                    <h5>RUC:</h5>
                </div>
                <div class="col">
                    <div class="form-group removeArrows">
                        <input value="" type="text" onkeypress="return isNumberKey(event);" class="form-control mx-sm-3 mb-2 " id="rucInput" name="ruc" placeholder="Ingresa tu RUC" minlength="11" required>
                    </div>
                    <div class="text-center" id="loaderRuc">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Razón Social:</h5>
                </div>
                <div class="col">
                    <div class="form-group">

                        <input value="" type="text" class="form-control mx-sm-3 mb-2 " id="razSocialInput" name="razSocial" placeholder="Ingresa tu razón social" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Dirección fiscal:</h5>
                </div>
                <div class="col">
                    <div class="form-group">
                        <input value="" type="text" class="form-control mx-sm-3 mb-2 " id="dirFiscal" name="dirFiscal" placeholder="Ingresa dirección fiscal" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col">
                <div id="boletaContainer" class="m-0 p-0 animated fadeIn">
                    <div class="row mt-4">
                        <div class="col">
                            <h5>DNI:</h5>
                        </div>
                        <div class="col">
                            <div class="form-group removeArrows">
                                <input onkeypress="return isNumberKey(event)" value="<?php echo $_SESSION['current_customer_DNI'] ?>" id="dni" placeholder="Tu DNI" type="number" class="form-control mx-sm-3 mb-2 " aria-describedby="emailHelp">
                            </div>

                        </div>
                    </div>
                </div>
                <!-- <div class="row mt-4">
                    <div class="col">
                        <h5>Apellidos:</h5>
                    </div>
                     <div class="col">
                        <div class="form-group">
                            <input value="<?php echo $_SESSION['current_customer_apellido']; ?>" id="apellido" placeholder="Tus Apellidos" type="text" class="form-control mx-sm-3 mb-2 " aria-describedby="emailHelp">
                        </div>
                    </div> 
                </div> -->
                <?php if (empty($_SESSION['current_customer_apellido'])) { ?>
                    <input value="<?php echo $_SESSION['current_customer_nombre']; ?>" id="apellido" type="hidden">
                <?php } else { ?>
                    <input value="<?php echo $_SESSION['current_customer_apellido']; ?>" id="apellido" type="hidden">
                <?php } ?>

                <div class="row mt-4">
                    <div class="col">
                        <h5>Fecha de Nacimiento:</h5>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input value="<?php echo date('Y-m-d', strtotime($_SESSION['current_customer_fechaNacimiento'])) ?>" placeholder="Tu Fecha de Nacimiento" type="date" class="form-control mx-sm-3 mb-2 " id="fechaNacimiento" aria-describedby="emailHelp">
                        </div>
                    </div>
                </div>
                <div class="row mt-4">

                    <div class="col">
                        <h5>Código de Cupón:</h5>
                    </div>

                    <!--  <div class="col">
                        <div class="form-group">
                            <input value="" id="cupon" placeholder="Código de Cupón" type="text" class="form-control mx-sm-3 mb-2 " aria-describedby="emailHelp">
                        </div>
                    </div> -->

                    <?php if ($_SESSION['estado_cupon'] == "activo" && $cartTotal >= $tienda['cantidadTotal']) { ?>
                        <div class="col">
                            <a href="#" id="codigodecupon" class="btn btn-outline-secondary"><?php echo $codigo_cupon; ?></a>
                            <h5 class="text-success">Cupon Valido</h5>
                        </div>
                    <?php } elseif ($_SESSION['estado_cupon'] == "activo" && $cartTotal < $tienda['cantidadTotal']) { ?>
                        <div class="col">
                            <a href="#" id="codigodecupon" class="btn btn-outline-secondary"><?php echo $codigo_cupon; ?></a>
                            <h5 class="text-danger">Cupon no Valido</h5>
                        </div>


                    <?php } elseif ($_SESSION['estado_cupon'] == "inactivo") { ?>
                        <div class="col">
                            <a href="#" id="codigodecupon" class="btn btn-outline-secondary">Ingresa tu Código de Cupón</a>
                            <h5 class="text-danger">Cupon no Valido</h5>
                        </div>
                    <?php } elseif (!isset($_SESSION['estado_cupon'])) {  ?>
                        <div class="col">
                            <a href="#" id="codigodecupon" class="btn btn-outline-secondary">Ingresa tu Código de Cupón</a>
                        </div>
                    <?php }   ?>


                </div>
                <div class="row mt-4 mb-4">
                    <div class="col text-center">
                        <a href="javascript:;" id="btnVerificar" class="btn btn-primary btn-lg">Verificar Datos</a>
                    </div>

                </div>


            </div>

        </div>
        <div class="row ">
            <div class="col">
                <div class="separador-subrayado-titulo"></div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="row mt-4 mb-2">
                    <div class="col">
                        <h5>Saldo actual :</h5>
                    </div>
                    <div class="col">
                        <h5 class="text-info mx-sm-3 mb-2">
                            S/. <?php echo $saldoBilletera;
                                ?>
                        </h5>

                    </div>
                </div>


            </div>

        </div>
        <div class="row">
            <div class="col">
                <div class="row mt-4 mb-2">
                    <div class="col">
                        <h5>SUBTOTAL :</h5>
                    </div>
                    <div class="col">

                        <?php
                        $total = 0;
                        if ($descuento_total > 0) {
                        ?>

                            <h5 class="mx-sm-3 mb-2">


                                <?php if ($_SESSION['estado_cupon']) { ?>

                                    <?php if ($_SESSION['estado_cupon'] == "activo" && $cartTotal >= $tienda['cantidadTotal']) { ?>
                                        <del class="text-danger">S/. <?php echo $cartTotalOriginal ?></del>
                                    <?php } else { ?>
                                        <del class="text-danger">S/. <?php echo $cartTotal ?></del>
                                    <?php  } ?>

                                <?php } ?>

                                <strong>S/. <?php echo $total = $cartTotal - $descuento_total ?></strong>

                            </h5>
                            <p class="text-success m-0">¡ Tienes un Descuento del <?php echo $tienda['descuento']; ?> %!</p>

                        <?php } else { ?>

                            <h5 class="mx-sm-3 mb-2">

                                <strong>S/. <?php echo $total = $cartTotal; ?></strong>

                                <!--  2 - Promocion primer cliente PPC01 -->
                                <?php if ($numPedidosCliente == 0 && $total > 30 && $deliveryZone['idTienda'] == 3) { ?>

                                    <p class="text-success m-0">Tienes 1 Shawarma gratis por ser tu primera compra</p>

                                <?php } ?>
                                <!--  /2 - Promocion primer cliente PPC01 -->
                            </h5>
                        <?php
                        }

                        if ($_SESSION['solo_gift_cards'] == 'true') {
                            echo '<small class="text-danger">(No puedes usar tu saldo para comprar giftcards)</small>';
                            $total = $cartTotal;
                        } else {

                            if ($saldoBilletera < $total) {
                                $total = $total - $saldoBilletera;
                            } elseif ($saldoBilletera >= $total) {
                                $total = 0;
                            }
                        }


                        ?>


                    </div>
                </div>


            </div>

        </div>
        <?php if ($_SESSION['envio'] === 'recojo' && $_SESSION['solo_gift_cards'] === 'true') {
        } else { ?>

            <div class="row">
                <div class="col">
                    <div class="row mt-4 mb-2">

                        <div class="col">
                            <h5 class="">Costo de envío:</h5>

                        </div>

                        <div class="col">
                            <h5 class="mx-sm-3 mb-2">
                                S/. <?php echo $costoEnvio ?>
                            </h5>
                        </div>

                    </div>
                </div>
            </div>

        <?php } ?>
        <div class="row">
            <div class="col">
                <div class="row mt-4 mb-2">

                    <div class="col">
                        <h5 class="">TOTAL:</h5>
                        <small class="m-0 p-0 text-info">Aplicando el saldo actual</small>
                    </div>

                    <div class="col">
                        <h5 class="mx-sm-3 mb-2">
                            S/. <?php echo ($total == '0') ? $total : $total + $costoEnvio ?>
                        </h5>
                    </div>

                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col">
                <div class="separador-subrayado-titulo"></div>
            </div>
        </div>


        <div class="row mt-4 " id="resultContainer" style="height: 200px">
            <div class="col text-center">


                <div id="vista"></div>


            </div>
        </div>
        <div class="row mt-2 mb-4">
            <div class="col text-center" id="infoTienda">
                <h4>
                    Nuestro Delivery Web atiende de Lunes a Sábado de 12:30 pm a 9:30 pm
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
    <!-- 3 Izipay - Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <center>
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width:300px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><img src="assets/img/navbar/logo.png" style="width:50px"> Fusion Wings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- payment form -->
                        <div class="kr-embedded" kr-form-token="<?php echo $formToken; ?>">

                            <!-- payment form fields -->
                            <div class="kr-pan"></div>
                            <div class="kr-expiry"></div>
                            <div class="kr-security-code"></div>

                            <!-- payment form submit button -->
                            <button class="kr-payment-button"></button>

                            <!-- error zone -->
                            <div class="kr-form-error"></div>
                        </div>
                    </div>
                    <!--  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
                </div>
            </div>
        </center>
    </div>
    <!-- /3 Izipay - Modal -->



    <div class="modal" tabindex="-1" role="dialog" id="codigo_de_cupon">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresa tu Código de Cupón</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="procesar_cupon.php" method="POST">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="direccion">Código de Cupón</label>
                                <input type="text" value="" class="form-control" id="cupon" name="cupon" placeholder="Ingresa tu código de cupón" required>
                                <input type="hidden" name="idTienda" value="<?php echo $zona_tienda; ?>">
                            </div>
                        </div>
                        <p><button type="submit" class="form-control btn btn-primary">Guardar</button></p>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </form>

                </div>
                <!--  <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Guardar</button>

                </div> -->
            </div>
        </div>
    </div>



    <?php include 'shared/footer.php' ?>
    <script>
        $(document).ready(function() {
            $("#codigodecupon").on("click", function() {
                $('#codigo_de_cupon').modal('show')
            });
        });
    </script>
    <script>
        let rucInput = document.getElementById('rucInput');
        let razSocialInput = document.getElementById('razSocialInput');
        let dirFiscal = document.getElementById('dirFiscal');


        $(document).ready(function() {
            $('#boletaContainer').hide();
            $('#facturaContainer').hide();
            $('#loaderRuc').hide();
        });

        let tipoDocumento = '';
        $("input[name=documento]").click(function() {
            let elemento = this;
            if (elemento.value === 'factura') {
                tipoDocumento = 'factura';

                $('#boletaContainer').hide();
                $('#facturaContainer').show();
            }
            if (elemento.value === 'boleta') {
                tipoDocumento = 'boleta';
                $('#boletaContainer').show();
                $('#facturaContainer').hide();
            }
        });


        $('#btnVerificar').on('click', function() {


            let documento = $('input:radio[name=documento]:checked').val();
            if (!documento) {

                Swal.fire(
                    'Error',
                    'Seleccione si desea boleta o factura',
                    'error'
                );

                return false;
            }


            direccion = $("#direccion").val();
            dni = $("#dni").val();
            fechaNacimiento = $("#fechaNacimiento").val();
            mensaje = $("#mensaje").val();
            telefono = $("#telefono").val();
            apellido = $("#apellido").val();
            total = '<?php echo $total; ?>';
            distrito = $("#distrito").val();
            /* cupon = $("#cupon").val(); */
            <?php
            if ($total == 0) {
            ?>
                urlVerificarDatos = 'ajax/verificarDireccionPagarConSaldo.php';

            <?php
            } else {
            ?>
                urlVerificarDatos = 'ajax/verificarDireccion.php';

            <?php
            }
            ?>
            if (!$("#localId").val()) {
                Swal.fire(
                    'Error',
                    'Seleccione un local de recojo.',
                    'error'
                );

                return false;
            }


            let datos = {
                "direccion": direccion,
                "dni": dni,
                "fechaNacimiento": fechaNacimiento,
                'mensaje': mensaje,
                'telefono': telefono,
                'apellido': apellido,
                'total': total,
                'distrito': distrito,
                'tipoDocumento': tipoDocumento,
                'lat': $("#latitud").val(),
                'lng': $("#longitud").val(),
                'localId': $("#localId").val()
                /* 'cupon': $("#cupon").val() */
            };

            if (tipoDocumento === 'factura') {

                datos.ruc = rucInput.value;
                datos.razonSocial = razSocialInput.value;
                datos.direccionFiscal = dirFiscal.value;

                if (rucInput.value.length < 11 || razSocialInput.value.length === 0 || dirFiscal.value.length === 0) {
                    Swal.fire(
                        'Error',
                        'Rellena todos los campos de tu factura',
                        'error'
                    );
                    return false
                }
            }
            $.ajax({
                url: urlVerificarDatos,
                type: "post",
                data: datos,
                beforeSend: function() {
                    $("#vista").html("<div class=\"d-flex justify-content-center\">\n" +
                        "  <div style='width: 130px;height: 130px;margin-top: 60px' class=\"spinner-border\" role=\"status\">\n" +
                        "    <span class=\"sr-only\">Loading...</span>\n" +
                        "  </div>\n" +
                        "</div>");

                    $('#button').attr("disabled", true);

                },

                success: function(data) {
                    $("#vista").html(data);
                }
            });

            let elementPosition = $("#resultContainer").offset();
            window.scroll({
                top: elementPosition.top - 150,
                behavior: 'smooth'
            });
        });
    </script>

    <script>
        (function() {
            const latitudElement = document.getElementById('latitud');
            const longitudElement = document.getElementById('longitud');
            const direccionElement = document.getElementById('direccion');
            const localIdElement = document.getElementById('localId');

            let addressIsSelected = localStorage.getItem('addressIsSelected');


            if (!addressIsSelected) {
                localStorage.setItem('addressIsSelected', '0');
                openAddressSelectorModal();
            }
            if (addressIsSelected === '1') {
                direccionElement.value = localStorage.getItem('address');
                longitudElement.value = localStorage.getItem('lng');
                latitudElement.value = localStorage.getItem('lat');

                if (localStorage.getItem('shippingType') === 'DELIVERY') {
                    localIdElement.value = localStorage.getItem('store');
                }

            }
        })();
    </script>
</body>

</html>