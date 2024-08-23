<?php
require_once 'vendor/autoload.php';
error_reporting(0);
$appId = '824113894745455'; //Identificador de la Aplicación
$appSecret = 'e6199f85761648d8e32c21eb009a2650'; //Clave secreta de la aplicación
/*$redirectURL = 'https://elegipcio.pe/script/fbConfig.php'; //Callback URL*/
if (isset($page)) {

    if ($page == 'carrito') {
        $redirectURL = 'https://elegipcio.pe/script/fbConfig.php?redirect=carrito'; //Callback URL
    } elseif ($page == 'inicio') {
        $redirectURL = 'https://elegipcio.pe/script/fbConfig.php'; //Callback URL
    } else {
        $redirectURL = 'https://elegipcio.pe/script/fbConfig.php'; //Callback URL
    }

} else {

    $redirectURL = 'https://elegipcio.pe/script/fbConfig.php'; //Callback URL
}

$fbPermissions = array('');  //Permisos opcionales

$fb = new Facebook\Facebook([
    'app_id' => $appId, // Replace {app-id} with your app id
    'app_secret' => $appSecret,
    'default_graph_version' => 'v3.2',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email'];
$loginUrl = $helper->getLoginUrl($redirectURL, $permissions);


?>


<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <div class="modal-header" align="center">
                <img id="img_logo" src="assets/img/navbar/logonegro.png" width="200">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Begin # DIV Form -->
            <div id="div-forms">

                <!-- Begin # Login Form -->
                <div id="login-form">
                    <form name="login-formx" id="login-formx" action="script/verificarUsuario.php" method="post"
                    >
                        <div class="modal-body">

                            <input autocomplete="username" onkeyup="return forceLower(this);" style="margin-top: 0"
                                   name="correo" id="login_username" class="form-control" type="email"
                                   placeholder="Correo" required>
                            <input autocomplete="current-password" name="contrasena" id="login_password"
                                   class="form-control" type="password"
                                   placeholder="Contraseña" required>
                        </div>

                        <button type="submit" style="border:2px solid red;margin-bottom: 10px;"
                                class="btn btn-outline-danger btn-lg btn-block">INICIAR SESIÓN
                        </button>
                        <button id="login_register_btn" type="button"
                                style="border:2px solid black; width:100% !important"
                                class="btn  btn-outline-dark btn-lg">REGISTRARSE
                        </button>
                        <button style="font-size:10px" id="login_lost_btn" type="button" class="btn btn-link">Olvidaste
                            tu contraseña?
                        </button>
                        <hr>
                        <!-- <div class="row">
                            <div class="col text-center">
                                <a href="<?php echo htmlspecialchars($loginUrl) ?>"
                                   class="btn btn-primary w-100 text-white"
                                   style="background-color: #4267B2;height: 44px">
                                    <i class="fa fa-facebook-official mx-2" style="font-size: 1.5rem"></i>
                                    Ingresar con Facebook </a>
                            </div>
                        </div> -->
                        <div class="row mb-3 ">
                            <div class="col text-center py-2">
                                <!--<div id="my-signin2"></div>-->
                                <div id="gSignInWrapper">
                                    <div id="customBtn" class="customGPlusSignIn">
                                        <span class="icon"></span>
                                        <span class="buttonText">Ingresar con Google</span>
                                    </div>
                                </div>
                                <div id="name"></div>
                                <script>startApp();</script>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End # Login Form -->

                <!-- Begin | Lost Password Form -->
                <form method="post" id="lost-form" action="script/passwordRecovery.php" style="display:none;">
                    <div class="modal-body">
                        <input onkeyup="return forceLower(this);" name="lostEmail" id="lost_email" class="form-control"
                               type="text"
                               placeholder="Escribe tu email." required>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button id="lost_login_btn" type="button" class="btn btn-link">INGRESAR</button>
                            <button id="lost_register_btn" type="button" class="btn btn-link">¡REGISTRATE!</button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">RECUPERAR</button>
                        </div>

                    </div>

                </form>

                <!-- End | Lost Password Form -->

                <!-- Begin | Register Form -->
                <div name="register-form" id="register-form" style="display:none;">
                    <form name="register-formx" id="register-formx" action="script/registerCustomer.php" method="post"
                    >


                        <div id="registerx" class="modal-body removeArrows">
                            <input name="nombre" id="ee_register_user" class="form-control" type="text"
                                   placeholder="Tu Nombre" required>
                            <input name="apellido" id="ee_register_user" class="form-control" type="text"
                                   placeholder="Tu Apellido" required>
                            <input autocomplete="username" onkeyup="return forceLower(this);" name="correo"
                                   id="ee_register_email" class="form-control" type="email"
                                   placeholder="E-Mail" required>
                            <input name="celular" id="ee_register_number" class="form-control"
                                   type="number" onkeypress="return isNumberKey(event)"
                                   placeholder="Número Fijo/Celular de Referencia" required>
                            <input autocomplete="new-password" name="password" id="ee_register_password"
                                   class="form-control"
                                   type="password" placeholder="Contraseña" required>
                            <input autocomplete="new-password" name="ee_register_password2" id="ee_register_password2"
                                   class="form-control"
                                   type="password" placeholder="Repetir Contraseña" required>

                        </div>
                        <div id="div-register-msg" class="text-center">
                            <div id="icon-register-msg" class="glyphicon glyphicon-chevron-right text-center"></div>
                            <h4 id="text-register-msg"></h4>
                        </div>
                        <div class="modal-footer">

                            <div>
                                <button id="register_login_btn" type="button" class="btn btn-link">Iniciar</button>
                                <button id="register_lost_btn" type="button" class="btn btn-link">Olvidaste tu
                                    contraseña?
                                </button>
                            </div>
                            <div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block">Registrarse</button>
                            </div>

                        </div>

                    </form>
                </div>
                <!-- End | Register Form -->

            </div>
            <!-- End # DIV Form -->

        </div>
    </div>
</div>
<div class="fixed-top animated fadeIn faster">

    <nav class="navbar  navbar-expand-lg navbar-dark bg-transparent p-0">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03"
                aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            Menú
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="javascript:;" onclick="openAddressSelectorModal()"
           class="p-2 d-block d-sm-block d-md-block d-lg-none d-xl-none">
            <img style="width: 50px; height: 50px" src="assets/img/icons/icono-de-ubicacion.png" alt="">
        </a>
        <a onclick="mostrarLoading()" href="egipcio-pago.php"
           class="p-2 d-block d-sm-block d-md-block d-lg-none d-xl-none">
            <img style="width: 50px; height: 50px" src="assets/img/navbar/comprar-mobile.png" alt="">
        </a>


        <?php if (!isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) { ?>
            <!--<a href="" class="p-2 d-block d-sm-block d-md-block d-lg-none d-xl-none" data-toggle="modal"
               data-target="#login-modal">
                <img style="width: 50px; height: 50px" src="assets/img/navbar/usuario.png" alt="">
            </a>-->

           <div  class="p-2 d-block d-sm-block d-md-block d-lg-none d-xl-none" >
               <a href="javascript:;" data-toggle="modal"
                  data-target="#login-modal" class="btn bg-egipcio-yellow text-egipcio">
                   <i class="fa fa-user mr-1" aria-hidden="true"></i> <br>
                   INGRESAR
               </a>
            </div>
        <?php } ?>

        <?php if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {
            ?>
            <div class="btn-group dropleft">
                <a href="" class="p-2 d-block d-sm-block d-md-block d-lg-none d-xl-none dropdown-toggle"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img style="width: 50px; height: 50px" src="assets/img/navbar/usuario.png" alt="">
                </a>
                <div class="dropdown-menu">
                    <h6 class="dropdown-header text-egipcio">
                        Hola <?php echo $_SESSION['current_customer_nombre'] ?></h6>
                    <a class="dropdown-item" href="egipcio-mi-cuenta.php">Mi cuenta</a>
                    <a class="dropdown-item" href="script/logout.php">Cerrar Sesión</a>

                </div>
            </div>
        <?php } ?>
        <a class="navbar-brand p-0 d-none d-sm-none d-md-block d-xl-block d-lg-block ml-5" href="elegipcio.php">
            <img id="imgBrand" class="logoNavBar" src="assets/img/navbar/logo.png" alt="">
        </a>

        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav navbar-center mx-auto">
                <li class="nav-item ml-2">
                    <a class="nav-link <?php echo ($page == 'inicio') ? "link-activo" : ""; ?>" href="egipcio-carta.php">INICIO</a>
                </li>
                <!-- <li class="nav-item ml-2">
                    <a class="nav-link <?php echo ($page == 'inicio') ? "link-activo" : ""; ?>"
                       href="elegipcio.php">INICIO</a>
                </li> -->
                <!-- <li class="nav-item ml-2">
                    <a class="nav-link <?php echo ($page == 'giftCards') ? "link-activo" : ""; ?>"
                       href="egipcio-gift-cards.php">GIFT CARDS</a>
                </li> -->
                <li class="nav-item ml-2">
                    <a class="nav-link <?php echo ($page == 'promociones') ? "link-activo" : ""; ?>"
                       href="egipcio-combos.php">PROMOCIONES</a>
                </li>
                <!-- <li class="nav-item ml-2">
                    <a class="nav-link <?php echo ($page == 'carta') ? "link-activo" : ""; ?>" href="egipcio-carta.php">CARTA</a>
                </li> -->
                <li class="nav-item ml-2">
                    <a class="nav-link <?php echo ($page == 'reparto') ? "link-activo" : ""; ?>"
                       href="egipcio-reparto.php">REPARTO</a>
                </li>
                <li class="nav-item ml-2">
                    <a class="nav-link <?php echo ($page == 'contacto') ? "link-activo" : ""; ?>"
                       href="egipcio-contacto.php">CONTACTO</a>
                </li>
                <!--<li class="nav-item ml-2 animated infinite heartBeat slow mt-3 d-none d-sm-none d-md-none d-lg-block d-xl-block">
                    <a href="egipcio-carta.php" class="boton ">DELIVERY</a>
                </li>-->

                <li class="nav-item ml-2">
                    <a onclick="openAddressSelectorModal()" class=" d-none cursor-pointer
                    d-sm-none d-md-none d-lg-block d-xl-block">
                        <img style="width: 50px; height: 50px" src="assets/img/icons/icono-de-ubicacion.png" alt="">
                    </a>
                </li>

                <li class="nav-item ml-2">
                    <a href="egipcio-pago.php" class=" d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <img style="width: 50px; height: 50px" src="assets/img/navbar/comprar-mobile.png" alt="">
                    </a>
                </li>
                <?php if (!isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) { ?>
                    <li class="nav-item ml-2">
                        <!-- <a href="" class=" d-none d-sm-none d-md-none d-lg-block d-xl-block" data-toggle="modal"
                            data-target="#login-modal">
                             <img style="width: 50px; height: 50px" src="assets/img/navbar/usuario.png" alt="">
                         </a>-->
                        <a href="javascript:;" data-toggle="modal"
                           data-target="#login-modal" class="btn bg-egipcio-yellow text-egipcio">
                            <i class="fa fa-user mr-1" aria-hidden="true"></i> <br>
                            INGRESAR
                        </a>
                    </li>

                <?php } ?>
                <?php if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {
                    ?>
                    <li class="nav-item ml-2 dropdown d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"
                           href="#" role="button" aria-haspopup="true" aria-expanded="true">
                            <img style="width: 50px; height: 50px" src="assets/img/navbar/usuario.png" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <h6 class="dropdown-header text-egipcio">
                                Hola <?php echo $_SESSION['current_customer_nombre'] ?></h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropDrown-link" href="egipcio-mi-cuenta.php">Mi Cuenta</a>
                            <a class="dropdown-item dropDrown-link" href="script/logout.php">Cerrar Sesión</a>
                        </div>
                    </li>

                <?php } ?>

            </ul>
        </div>
    </nav>

</div>

