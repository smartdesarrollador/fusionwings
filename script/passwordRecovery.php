<?php
session_start();
include '../class/ClienteClass.php';
error_reporting(0);

/**
 * Created by PhpStorm.
 * Developer: Johen Guevara Santos.
 * Email: mguevara@enfocussoluciones.com
 * Date: 13/12/2019
 * Time: 14:50
 */
if (isset($_POST['lostEmail'])) {
    $objCliente = new ClienteClass();

    /* POR SI ALGUIEN LE  A ENVIADO UN REGALO, PERO NO SE DIÓ CUENTA Y SU CUENTA AÚN NO HA SIDO CONFIGURADA */
    $cliente = $objCliente->getAllInformationUserByEmail($_POST['lostEmail']);

    if ($cliente['cuentaConfigurada'] == 'false') {

        $urlConfigACcount = 'https://elegipcio.pe/r.php?c=' . $cliente['configAccountToken'] . '&id=' . $cliente['idCliente'];

        $mensaje = '<div>
    <div style="background-color:#f2f3f5;padding:20px">
        <div style="max-width:600px;margin:0 auto">
            <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #9C0001;margin-bottom:20px">

                <div style="border-bottom:1px solid #f2f3f5;padding:20px 30px">

                    <img id="m_7479378229902740556logo" width="150" style="max-width:99px;display:block" src="https://elegipcio.pe/assets/img/logonegro.png" alt="Logo el Egipcio" class="CToWUd">

                </div>


                <div style="margin:0px auto;padding:0px;text-align:center;color:#505763" id="m_7479378229902740556gift-card">
                    <div style="background:#fff;margin:15px auto;width:468px">
                        <div style="background:#fff;color:#505763;padding:15px 15px 0px 15px;text-align:left">
        <span style="display:block;font-size:16px;font-weight:bold">
            <a href="#m_7479378229902740556_" style="text-decoration:none;color:#000">
            ¡Hola,tienes un regalo pendiente, configura tu cuenta y prueba de la gran
                variedad de productos que tenemos para ti.
            </a></div>
                        <div style="background:#fff;padding:10px">
                            <div>
                                <a  style="padding:10px 15px;background:#ec5252;display:inline-block;border-radius:2px;color:#fff;font-weight:bold;font-size:17px;text-decoration:none" href="' . $urlConfigACcount . '" target="_blank" >
                                    Configura tu cuenta
                                </a>
                            </div>
                            <div style="padding:0px;background:#fff;color:#686f7a">
                                <span style="display:inline-block;padding:10px 10px">O</span>
                            </div>
                            <div style="background:#fff;font-size:12px">
                                Ve a <a href="' . $urlConfigACcount . '">' . $urlConfigACcount . '</a>
                            </div>
                        </div>
                        <div style="background:#fff;font-size:12px;padding:20px 0px 15px">
                            Este regalo es para:</b> <a href="mailto:' . $cliente['email'] . '" target="_blank">' . $cliente['email'] . '</a>
                        </div>
                    </div>
                </div>




            </div>
            <div style="font:11px sans-serif;color:#686f7a">
                <p style="font-size:11px;color:#686f7a">

                    El Egipcio, Jr. Julio Cesar Tello 872 / 886 Lince, Lima - Perú.

                </p>
            </div>
        </div>
    </div>
   </div>';

        $to = $cliente['email'];
        $subject = "Hola, " . $cliente['nombre'] . " te ha enviado un regalo!";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        /*CAMBIAR ESTE ENLACE*/
        $headers .= 'From: El Egipcio - AVISOS<noreply@elegipcio.pe>' . "\r\n";
        mail($to, $subject, $mensaje, $headers);
        header("location: ../elegipcio.php?code=sendResetMail");
        exit();

    }
    /*      END VERIFICACION SI LA CUENTA A SIDO CONFIGURADA*/
    $lostEmail = strtolower(trim($_POST['lostEmail']));
    $token = bin2hex(random_bytes(10));

    $addedToken = $objCliente->addAcccountReoveryToken($token, $lostEmail);
    if ($addedToken > 0) {


        $url = 'https://elegipcio.pe/reset.php?mail=' . $lostEmail . '&tkn=' . $token;
        $mensaje = "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"
       style=\"color:#333;background:#fff;padding:0;margin:0;width:100%;font:15px/1.25em \'Helvetica Neue\',Arial,Helvetica\">
    <tbody>
    <tr width=\"100%\">
        <td valign=\"top\" align=\"left\" style=\"background:#eef0f1;font:15px/1.25em \'Helvetica Neue\',Arial,Helvetica\">
            <table style=\"border:none;padding:0 18px;margin:50px auto;width:500px\">
                <tbody>
                <tr width=\"100%\" height=\"60\">
                    <td valign=\"top\" align=\"left\"
                        style=\"border-top-left-radius:4px;border-top-right-radius:4px; padding:10px 18px;text-align:center;background-color: #9C0001\">
                        <img  width=\"125\"
                              src=\"https://elegipcio.pe/assets/img/navbar/logo.png\"
                              title=\"El elegipcio\" style=\"font-weight:bold;font-size:18px;color:#fff;vertical-align:top\"
                              class=\"CToWUd\"></td>
                </tr>
                <tr width=\"100%\">
                    <td valign=\"top\" align=\"left\" style=\"background:#fff;padding:18px\">

                        <h1 style=\"font-size:20px;margin:16px 0;color:#333;text-align:center\"> Recuperación de Contraseña </h1>

                        <p style=\"font:15px/1.25em \'Helvetica Neue\',Arial,Helvetica;color:#333;text-align:center\">
                            Hola," . $cliente['nombre'] . " puedes restablecer fácilmente tu contraseña haciendo click en el botón, o copiando el siguiente enlace en tu navegador web.  </p>

                        <div style=\"background:#f6f7f8;border-radius:3px\"><br>

                            <p style=\"text-align:center;color: #9C0001\">'.$url.'</p>

                            <p style=\"font:15px/1.25em \'Helvetica Neue\',Arial,Helvetica;margin-bottom:0;text-align:center\">
                                <a href=\"'.$url.'\"
                                   style=\"border-radius:3px;background:#9C0001;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 6px;padding:10px 18px;text-decoration:none;width:180px\"
                                   target=\"_blank\">Reestablecer Contraseña</a></p>

                            <br><br></div>

                        <p style=\"font:14px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align: center\">
                            Nuestro Delivery Web atiende de Lunes a Sábado de 12:30 pm a 9:00 pm
                        </p>
                        <p style=\"font:14px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align: center\">
                            Teléfono: +51 981-344-827 <br>
                            Email: contactanos@elegipcio.pe
                        </p>
                        <p style=\"font:14px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align: center\">
                            Jr. Julio Cesar Tello 872 / 886 Lince, Lima - Perú
                        </p>

                    </td>

                </tr>

                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
";

        $to = "$lostEmail";
        $subject = "Recupera tu Contraseña - El Egipcio";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        /*CAMBIAR ESTE ENLACE*/
        $headers .= 'From: El Egipcio - AVISOS<noreply@elegipcio.pe>' . "\r\n";
        mail($to, $subject, $mensaje, $headers);

        header("location: ../elegipcio.php?code=sendResetMail");

    } else {
        header("location:../elegipcio.php?code=notExistUser");
    }


}
