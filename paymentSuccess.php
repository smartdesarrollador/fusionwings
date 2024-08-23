<?php
session_start();
$page = 'paymentSuccess';
include "class/Pedido.php";
include "class/PedidoItems.php";
$objPedido = new Pedido();
$objPedidoItems = new PedidoItems();
if (isset($_GET['orderId']) && $_GET['orderId'] != '') {
} else {
    echo 'No autorizado';
    die(404);
}

$idPedido = $_GET['orderId'];
$pedido = $objPedido->getPedidoByIdPedido($idPedido);
$pedidoItems = $objPedidoItems->getPedidoIems(trim($_GET['orderId']));

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Pago exitoso</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">
</head>

<body>
    <?php include 'shared/navBar.php' ?>
    <div class="container main-container animated fadeIn slow mb-5">

        <div class="row mb-3 justify-content-center">
            <div class="col-6 col-sm-6 col-md-4 col-xl-3 col-lg-3 text-center">
                <img class="img-fluid" src="assets/img/success.png" alt="">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col font-weight-bolder">
                <h2 class="text-success text-center">¡Tu pedido ha sido realizado con éxito!</h2>
                <h5 class="text-success text-center">Los pedidos con recojo en tienda se atienden dentro de 30 a 40 minutos de haber realizado tu compra.</h5>

            </div>
        </div>


        <div class="row mb-3 justify-content-center">
            <div class="col-11 col-sm-11 col-md-6 col-xl-4 col-lg-4">
                <table class="table">
                    <tbody>
                        <tr>


                            <td>Codigo: </td>
                            <td><?php echo str_pad($pedido['idPedido'], 8, "0", STR_PAD_LEFT); ?></td>

                        </tr>
                        <tr>


                            <td>Dirección de entrega:</td>
                            <td><?php echo $pedido['direccionPedido'] ?></td>
                        </tr>
                        <tr>
                            <td>Fijo / Celular:</td>
                            <td><?php echo $pedido['pedidoTelefono'] ?></td>
                        </tr>
                        <tr>
                            <td>Pedido:</td>
                            <td><?php foreach ($pedidoItems as $item) {
                                ?>
                                    <ul>
                                        <li><small><?php echo $item['nombreProducto'] ?>(x <?php echo $item['cantidad'] ?>)</small></li>
                                    </ul>
                                <?php
                                }

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Precio Total:</td>
                            <?php if ($pedido['estado_descuento'] == 'true') { ?>
                                <td><strong>S/. <?php echo $pedido['precio_con_descuento'] ?></strong></td>
                            <?php } else { ?>
                                <td><strong>S/. <?php echo $pedido['precioTotal'] ?></strong></td>
                            <?php } ?>

                        </tr>
                    </tbody>
                </table>
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