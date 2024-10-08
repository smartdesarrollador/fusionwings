<?php
session_start();
error_reporting(0);
function my_simple_crypt($string, $action = 'e')
{
    // you may change these values to your own
    $secret_key = 'enfocussoluciones';
    $secret_iv = 'enfocussoluciones';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

/*$root = $_SERVER["DOCUMENT_ROOT"];*/
require_once("../class/ClienteClass.php");

$objUser = new ClienteClass();

/*RECIBIENDO LAS VARIABLES GLOBALES*/
$nombre = $_POST['nombre'];
if(isset($_POST['apellido'])){
    $apellido = $_POST['apellido'];
}else{
    $apellido = $_POST['nombre'];;
}
$email = trim($_POST['correo']);
$celular = trim($_POST['celular']);
$password = $_POST['password'];


$customer = $objUser->getEmailCustomerByEmail($email);
if (count($customer) > 0) {
        header("location: ../fusionwings.php" . "?code=emailExiste");
        exit();
} else {
    $encriptedPassword = password_hash($password . "" . $password[2], PASSWORD_DEFAULT, ['cost' => 10]);


    $addNewCustomer = $objUser->addNewCustomer($nombre, $apellido, $email, $celular, $encriptedPassword);
    if ($addNewCustomer > 0) {

        /* creando el codigo qr para cada cliente*/
        $idEncriptado = my_simple_crypt($addNewCustomer);
        $urlQR = 'https://fusionwings.pe/r.php?u=' . $idEncriptado;
        $nombreFoto = $idEncriptado . '.png';

        $apiQR = file_get_contents('https://worksafetytech.com/utils/qrGeneratorMaxSize.php?content=' . $urlQR);
        file_put_contents('../assets/img/qrCodes/' . $nombreFoto, $apiQR);
        $afecteado = $objUser->updateClienteQR($addNewCustomer, $nombreFoto);

        /* end*/

        $_SESSION['current_customer_idCliente'] = $addNewCustomer;
        $_SESSION['current_customer_email'] = strtolower($email);
        $_SESSION['current_customer_nombre'] = $nombre;
        $_SESSION['current_customer_apellido'] = $apellido;
        $_SESSION['current_customer_DNI'] = '';
        $_SESSION['current_customer_fechaNacimiento'] = '';
        $_SESSION['current_customer_telefono'] = $celular;
        $_SESSION['current_customer_direccion'] = '';
        /*    $_SESSION['current_customer_reputacion'] ='';*/
        $_SESSION['current_customer_puntos'] = 0;


        $mensaje = '<table cellspacing="0" cellpadding="0" border="0"
       style="color:#333;background:#fff;padding:0;margin:0;width:100%;font:15px/1.25em \'Helvetica Neue\',Arial,Helvetica">
    <tbody>
    <tr width="100%">
        <td valign="top" align="left" style="background:#eef0f1;font:15px/1.25em \'Helvetica Neue\',Arial,Helvetica">
            <table style="border:none;padding:0 18px;margin:50px auto;width:500px">
                <tbody>
                <tr width="100%" height="60">
                    <td valign="top" align="left"
                        style="border-top-left-radius:4px;border-top-right-radius:4px; padding:10px 18px;text-align:center;background-color: #FF6900">
                        <img  width="125"
                              src="https://fusionwings.pe/assets/img/navbar/logo.png"
                              title="Fusion Wings" style="font-weight:bold;font-size:18px;color:#fff;vertical-align:top"
                              class="CToWUd"></td>
                </tr>
                <tr width="100%">
                    <td valign="top" align="left" style="background:#fff;padding:18px">

                        <h1 style="font-size:20px;margin:16px 0;color:#333;text-align:center">' . "$nombre" . ', gracias por Registrarte </h1>

                        <p style="font:15px/1.25em \'Helvetica Neue\',Arial,Helvetica;color:#333;text-align:center">
                            Ahora puedes hacer tus pedidos de forma fácil: </p>
                        <div style="background:#f6f7f8;border-radius:3px"><br>

                            <p style="text-align:center"><a href="https://fusionwings.pe/fusionwings-carta.php"
                                                            style="color:#FF6900;font:26px/1.25em \'Helvetica Neue\',Arial,Helvetica;text-decoration:none;font-weight:bold"
                                                            target="_blank">fusionwings.pe</a></p>

                            <p style="font:15px/1.25em \'Helvetica Neue\',Arial,Helvetica;margin-bottom:0;text-align:center">
                                <a href="https://fusionwings.pe/fusionwings-carta.php"
                                   style="border-radius:3px;background:#FF6900;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 6px;padding:10px 18px;text-decoration:none;width:180px"
                                   target="_blank">Ir a la Carta</a></p>

                            <br><br></div>

                        <p style="font:14px/1.25em \'Helvetica Neue\',Arial,Helvetica;color:#333;text-align: center">
                            Nuestro Delivery Web atiende de Lunes a Sábado de 12:30 pm a 9:00 pm
                        </p>
                        <p style="font:14px/1.25em \'Helvetica Neue\',Arial,Helvetica;color:#333;text-align: center">
                            Teléfono: +51 981-344-827 <br>
                            Email: contactanos@fusionwings.pe
                        </p>
                        <p style="font:14px/1.25em \'Helvetica Neue\',Arial,Helvetica;color:#333;text-align: center">
                            Jr. Julio Cesar Tello 872 / 886 Lince, Lima - Perú
                        </p>

                    </td>

                </tr>

                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>';

        $to = "$email";
        $subject = "Bienvenido - Fusion Wings";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        /*CAMBIAR ESTE ENLACE*/
        $headers .= 'From: Fusion Wings - AVISOS<noreply@fusionwings.pe>' . "\r\n";
        mail($to, $subject, $mensaje, $headers);

        $ir = $_SERVER['HTTP_REFERER'];
        header("location:$ir");
        /*header("location: ../fusionwings.php?code=success");*/


    }

}


