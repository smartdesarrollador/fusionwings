<?php
session_start();
error_reporting(0);
function limpiar($s)
{
    $s = str_replace('á', 'a', $s);
    $s = str_replace('Á', 'A', $s);
    $s = str_replace('é', 'e', $s);
    $s = str_replace('É', 'E', $s);
    $s = str_replace('í', 'i', $s);
    $s = str_replace('Í', 'I', $s);
    $s = str_replace('ó', 'o', $s);
    $s = str_replace('Ó', 'O', $s);
    $s = str_replace('Ú', 'U', $s);
    $s = str_replace('ú', 'u', $s);

//Quitando Caracteres Especiales
    $s = str_replace('"', '', $s);
    $s = str_replace(':', '', $s);
    $s = str_replace('.', '', $s);
    $s = str_replace(',', '', $s);
    $s = str_replace(';', '', $s);
    return $s;
}

include '../class/Cart.php';
$cart = new Cart;
include '../class/ClienteClass.php';
$objCliente = new ClienteClass();

include '../class/Delivery.php';
include '../class/TiendaClass.php';
$objDelivery = new Delivery();
$objTienda = new TiendaClass();
if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
    $direccion = $_SESSION['current_customer_direccion'];
} else {
    $direccion = $_POST['direccion'];
}

$dni = limpiar($_POST['dni']);
$fechaNacimiento = $_POST['fechaNacimiento'];
$mensaje = $_POST['mensaje'];
$apellido = $_POST['apellido'];
$telefono = limpiar($_POST['telefono']);
$total = $_POST['total'] * 100;
$distrito = $_POST['distrito'];
$storeId = (isset($_POST['localId'])) ? $_POST['localId'] : 0;

$distritosConCosto = $objDelivery->getCostoPorDistritos();
if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
} else {
    if ($direccion == '') {
        echo '<h5  class="text-center text-danger">Falta la direccion de Envío</h5>';
        exit();
    }
}
if ($telefono == '') {
    echo '<h5  class="text-center text-danger">Falta el teléfono</h5>';
    exit();
}
if ($_POST['tipoDocumento'] == 'boleta') {
    if (strlen($dni) < 8) {
        echo '<strong class="text-center" style="color: red">DNI Invalido</strong>';
        exit();
    }
} else {
    $_SESSION['current_customer_ruc'] = $_POST['ruc'];
    $_SESSION['current_customer_razonSocial'] = $_POST['razonSocial'];
    $_SESSION['current_customer_direccionFiscal'] = $_POST['direccionFiscal'];
}
if ($fechaNacimiento == '') {

    echo '<h5 class="text-center text-danger">Falta fecha de Nacimiento</h5>';
    exit();
}
if (!isset($_SESSION['current_customer_idCliente'])) {
    echo '<h5 class="text-center text-danger">Error de autorización, por favor refresca la pagina e intentalo de nuevo</h5>';
    exit();
}
if ($distrito == '') {

    echo '<strong class="text-center" style="color: red">Ingresa un distrito válido</strong>';
    exit();
}
$idCliente = $_SESSION['current_customer_idCliente'];


if (strlen($_POST['lat']) > 2) {
    $clienteActualizado = $objCliente->
    updateCustomerDetailsWithLatLng($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido, $_POST['lat'], $_POST['lng'], $_POST['distrito']);
    $_SESSION['current_customer_lat'] = trim($_POST['lat']);
    $_SESSION['current_customer_lng'] = trim($_POST['lng']);
} else {
    $clienteActualizado =
        $objCliente->updateCustomerDetails($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido, $_POST['distrito']);
    $_SESSION['current_customer_lat'] = trim($_POST['lat']);
    $_SESSION['current_customer_lng'] = trim($_POST['lng']);
}


$_SESSION['current_customer_tipoDocumento'] = $_POST['tipoDocumento'];
$_SESSION['current_customer_DNI'] = $dni;
$_SESSION['current_customer_fechaNacimiento'] = $fechaNacimiento;
$_SESSION['current_customer_direccion'] = $direccion;
$_SESSION['current_customer_mensaje'] = $mensaje;
$_SESSION['current_customer_telefono'] = $telefono;
$_SESSION['current_customer_apellido'] = $apellido;
$_SESSION['$current_customer_distrito'] = $distrito;
$estadosTiendas = $objTienda->getEstadoTiendas();

if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {

    ?>
    <script>
        var finalShippingCost = 0;
        var storeId = '<?= $storeId ?>';

    </script>
    <div class="row">
        <div class="col text-center">
            <button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-primary btn-lg"
                    id="buyButton">
                PAGAR
            </button>
            <strong class="text-info d-block">Tienes saldo suficiente para realizar esta compra</strong>
        </div>
    </div>

    <?php
} else {
    ?>

    <div id="checkout" class="text-center">
        <h3 id="mensajeExito" style="color: green">Felicidades! Estas en la zona de reparto</h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                                                    aria-hidden="true"></i></span>
            </div>
            <input value="<?= $direccion ?>" id="direccionFormateada" readonly type="text" class="form-control"
                   aria-label="Username"
                   aria-describedby="basic-addon1">
        </div>


        <button data-toggle="modal" data-target="#exampleModal" type="button" class="buybutton" id="buyButton">PAGAR
        </button>
        <strong class="text-info d-block">Tienes saldo suficiente para realizar esta compra</strong>
    </div>

<?php } ?>
<div class="modal fade" data-backdrop="static" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col text-center">
                        <img style="width: 130px" src="assets/img/logonegro.png" alt="">
                    </div>
                </div>

                <div class="row">
                    <div class="col text-center">
                        <h6>Tienes saldo suficiente en tu cuenta para realizar este pedido, se te descontará el total
                            del pedido de tu saldo</h6>
                        <h6>Puedes revisar tu saldo en tu cuenta</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a onclick="checkountConSaldo()" class="btn btn-primary btn-lg text-white">Realizar Pedido</a>
            </div>
        </div>
    </div>
</div>
<script>
    function checkountConSaldo() {


        /*window.location = 'script/checkoutConSaldo.php?token=' + '2zKcGKn5dF7xGXCAuyw89v1j9D1b48N8h0XOIYX2sVbVTsAiL5WAw7nUL6w4' + '&store=' + storeId;*/
        console.log(window.location = 'script/checkoutConSaldo.php?token=' + '2zKcGKn5dF7xGXCAuyw89v1j9D1b48N8h0XOIYX2sVbVTsAiL5WAw7nUL6w4' + '&store=' + storeId);

    }
</script>
<div style="display: none" id="loading" class="loading">Loading&#8230;</div>
