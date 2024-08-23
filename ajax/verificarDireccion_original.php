<?php
session_start();
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

error_reporting(0);
include '../class/Cart.php';
include_once '../class/const.php';
include '../class/ClienteClass.php';
include '../class/Delivery.php';
include '../class/TiendaClass.php';
$cart = new Cart;
$objCliente = new ClienteClass();
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
$storeId = $_POST['localId'];


$deliveryZone = $objDelivery->getDeliveryZoneById($_SESSION['deliveryZoneId']);

$costoEnvio = 0;
if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
    $costoEnvio = 0;
} else {
    $costoEnvio = $deliveryZone['price'];
}

if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
} else {
    if ($direccion == '') {
        echo '<strong  class="text-center" style="color: red">Falta la direccion de Envío</strong>';
        exit();
    }
}
if ($telefono == '') {
    echo '<strong  class="text-center" style="color: red">Falta el teléfono</strong>';
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

    echo '<strong class="text-center" style="color: red">Falta fecha de Nacimiento</strong>';
    exit();
}
if ($distrito == '') {

    echo '<strong class="text-center" style="color: red">Ingresa un distrito válido</strong>';
    exit();
}
$idCliente = $_SESSION['current_customer_idCliente'];


if (strlen($_POST['lat']) > 2) {
    $clienteActualizado =
        $objCliente->updateCustomerDetailsWithLatLng($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido, $_POST['lat'], $_POST['lng'], $_POST['distrito']);
    $_SESSION['current_customer_lat'] = trim($_POST['lat']);
    $_SESSION['current_customer_lng'] = trim($_POST['lng']);
} else {
    $clienteActualizado = $objCliente->updateCustomerDetails($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido, $_POST['distrito']);
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
?>

<?php

?>
<script>
    Culqi.publicKey = '<?= CULQI_PUBLIC_KEY ?>';

</script>
<?php
if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
    ?>
    <div class="row">
        <div class="col text-center">
            <p class="text-info"><strong>Click en pagar para completar tu pedido.</strong></p>
            <button type="button" class="buybutton" id="buyButton">PAGAR</button>
        </div>
    </div>
    <script>
        var finalShippingCost = <?= $costoEnvio ?>;
        console.warn(finalShippingCost);

        var storeId = '<?= $storeId ?>';
        console.log(storeId);

        Culqi.options({
            style: {
                logo: 'https://elegipcio.pe/assets/img/navbar/logo.png',
                maincolor: '#9C0001',
                buttontext: '#ffffff',
                maintext: '#4A4A4A',
                desctext: '#4A4A4A'
            }
        });


        Culqi.settings({
            title: 'EL EGIPCIO',
            currency: 'PEN',
            description: 'Delivery Web',
            amount: <?php echo $total?>
        });

        $('#buyButton').on('click', function (e) {
            // Abre el formulario con la configuración en Culqi.settings
            Culqi.open();
            e.preventDefault();
        });
    </script>

    <?php
} else {
    ?>
    <script>
        var finalShippingCost = <?= $costoEnvio ?>;
        console.warn(finalShippingCost);
        var storeId = <?= $storeId ?>;
        console.warn(storeId);
        document.getElementById("checkout").style.display = "none";

        var direccion = '<?php echo $direccion . ' ' . $distrito; ?>';


        var hasNumber = /\d/;

        document.getElementById("checkout").style.display = "block";


        document.getElementById("direccionFormateada").value = '<?= $direccion ?>';
        Culqi.options({
            style: {
                logo: 'https://elegipcio.pe/assets/img/navbar/logo.png',
                maincolor: '#9C0001',
                buttontext: '#ffffff',
                maintext: '#4A4A4A',
                desctext: '#4A4A4A'
            }
        });


        Culqi.settings({
            title: 'EL EGIPCIO',
            currency: 'PEN',
            description: 'Delivery Web',
            amount: <?php echo $total?> +finalShippingCost * 100
        });

        $('#buyButton').on('click', function (e) {
            // Abre el formulario con la configuración en Culqi.settings
            Culqi.open();
            e.preventDefault();
        });


    </script>

    <div id="checkout" class="text-center">
        <h3 id="mensajeExito" style="color: green">Felicidades! Estas en la zona de reparto</h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                                                    aria-hidden="true"></i></span>
            </div>
            <input id="direccionFormateada" readonly type="text" class="form-control" aria-label="Username"
                   aria-describedby="basic-addon1">
        </div>


        <button type="button" class="buybutton" id="buyButton">PAGAR</button>
    </div>

<?php } ?>
<script>

    function culqi() {
        if (Culqi.token) {

            let token = Culqi.token.id;
            console.log('Se ha creado un token:' + token);
            let url = "script/checkout.php";

            document.getElementById("loading").style.display = "block";


            let datos = new FormData();

            datos.append('finalShippingCost', finalShippingCost);


            window.location = 'script/checkout.php?token=' + token + '&store=' + storeId


        } else {
            console.log(Culqi.error);
            alert('Error 500, contacte al administrador');
            console.log(Culqi.error.user_message);
        }

    }

</script>
<div style="display: none" id="loading" class="loading">Loading&#8230;</div>
