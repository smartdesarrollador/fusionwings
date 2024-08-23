<?php
session_start();
error_reporting(0);
if (!isset($_GET['mail'], $_GET['tkn'])) {
    echo "no tiene autorizacion para ver esta pagina";
    exit();
} else {
    include 'class/ClienteClass.php';
    $objCliente = new ClienteClass();

    $email = trim($_GET['mail']);
    $tkn = trim($_GET['tkn']);
    $userExist = $objCliente->getUserByTknTokenAndEmail($tkn, $email);

    if ($userExist['passRecoveryToken'] == $tkn && $userExist['email'] == $email) {
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
        </head>
        <body>
        <?php include 'shared/navBar.php' ?>
        <div class="container main-container animated fadeIn slow mb-5">
            <div class="row mb-3">
                <div class="col">
                    <h2 class="titulo">RECUPERAR CONTRASEÑA</h2>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="separador"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form id="resetPasswordForm" action="script/resetPassword.php" method="post">
                        <br style="clear:both">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Correo</label>
                                    <input readonly type="text" class="form-control" id="email" name="email"
                                           value="<?php echo $email; ?>"
                                           required>

                                    <input readonly type="hidden" name="tkn" value="<?php echo $tkn; ?>"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="passwordReset">Nueva Contraseña</label>
                                    <input value="" type="password"
                                           class="form-control" id="passwordReset" name="password"
                                           placeholder=""
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="passwordReset2">Repite tu nueva contraseña </label>
                                    <input value="" type="password"
                                           class="form-control" id="passwordReset2"
                                           placeholder=""
                                           required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <strong id="nocoinciden" class="text-center" style="color: red">Las contraseñas no
                            coinciden</strong>
                        <button type="submit" id="btnVerificar" name="submit" class="btn btn-primary btn-lg pull-right">
                            Cambiar
                        </button>

                    </form>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col text-center">

                </div>
            </div>

        </div>
        <?php include 'shared/footer.php' ?>
        <script src="assets/js/resetPass.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "no tiene autorización para ver esta pagina";
        exit();
    }
}
?>
