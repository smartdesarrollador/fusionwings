<?php
session_start();
error_reporting(0);
if (isset($_GET['id'], $_GET['token'])) {
} else {
    echo "Esta cuenta ya a sido configurada, si no recuerdas la contraseña, por favor usa la opcion de recuperar contraseña en https://elegipcio.pe";
    exit();
}


include "class/ClienteClass.php";
$objCliente = new ClienteClass();
$cliente = $objCliente->getClienteByIDAndConfigurationToken($_GET['id'], $_GET['token']);

if ($cliente['configAccountToken'] != $_GET['token'] || $cliente['idCliente'] != $_GET['id']) {

    echo "Esta cuenta ya a sido configurada, si no recuerdas la contraseña, por favor usa la opcion de recuperar contraseña en https://elegipcio.pe";
    exit();
}
if ($cliente['cuentaConfigurada'] =='true' ) {

    echo "Esta cuenta ya a sido configurada, si no recuerdas la contraseña, por favor usa la opcion de recuperar contraseña en https://elegipcio.pe";
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Configura tu Cuenta</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">
</head>
<body>
<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">
    <div class="row mb-3">
        <div class="col">
            <h2 class="titulo">BIENVENIDO A <br> EL EGIPCIO</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="separador"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <h4>Nos alegra que estes aquí</h4>
            <h6>Tu regalo ya a sido cargado automaticamente a tu cuenta, configura tu nueva cuenta y prueba de la gran
                variedad de productos que tenemos para ti.

            </h6>
        </div>
    </div>

    <div class="row mb-3 ">
        <div class="col">
            <div class="form-row">
                <div class="form-group col-md-6 px-4">
                    <label for=" perfilEmail
                ">Email</label>
                    <input readonly type="email" value="<?php echo $cliente['email'] ?>" class="form-control m-0"
                           id="perfilEmail">
                </div>
            </div>
        </div>
    </div>
    <form id="formConfigAccount" action="script/configNewCustomerProfile.php" method="post">
        <div class="row ">
            <div class="col">

                <div class="form-row">
                    <div class="form-group col-md-6 px-4 removeArrows">
                        <label for="perfilCelular">Teléfono / Celular</label>
                        <input required onkeypress="return isNumberKey(event)" name="celular" type="number" value=""
                               class="form-control m-0" id="perfilCelular">
                    </div>
                    <div class="form-group col-md-6 px-4">
                        <label for="nombre">Nombre</label>
                        <input required type="text" value="" name="nombre" class="form-control m-0" id="nombre">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-6 px-4 removeArrows">
                        <label for="contrasena">Contraseña</label>
                        <input required name="contrasena" type="password" value="" class="form-control m-0"
                               id="contrasena">
                    </div>
                    <div class="form-group col-md-6 px-4">
                        <label for="repiteContrasena">Repite tu contraseña</label>
                        <input type="password" value="" class="form-control m-0" id="repiteContrasena">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="noCoinciden" class="col text-center text-danger"><strong>Las Contraseñas no coinciden</strong></div>
        </div>
        <div class="row mb-3 mt-2 ">
            <div class="col text-right px-4">
                <input type="hidden" name="token" value="<?php echo $cliente['configAccountToken'] ?>">
                <input type="hidden" name="id" value="<?php echo $cliente['idCliente'] ?>">
                <button type="submit" class="btn btn-primary btn-lg ">GUARDAR DATOS</button>
            </div>
        </div>

    </form>

    <div class="row mb-5">
        <div class="col text-center">

        </div>
    </div>
</div>
<?php include 'shared/footer.php' ?>
<script>
    $(document).ready(function () {
        $('#noCoinciden').hide();

        $('#formConfigAccount').submit(function () {
            let pass1 = $('#contrasena').val();
            let pass2 = $('#repiteContrasena').val();
            if (pass1 !== pass2){
                $('#noCoinciden').show();
                return false;
            }else{
                mostrarLoading();
                return true;
            }
        })

    });

</script>
</body>
</html>
