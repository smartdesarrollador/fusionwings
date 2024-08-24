<?php
/**
 * Created by PhpStorm.
 * Developer: Johen Guevara Santos.
 * Email: mguevara@enfocussoluciones.com
 * Date: 6/09/2019
 * Time: 09:44
 */
error_reporting(0);
if (isset($_POST['submit_libro'])) {


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

        $s = str_replace('"', '', $s);
        $s = str_replace(':', '', $s);
        $s = str_replace('.', '', $s);
        $s = str_replace(',', '', $s);
        $s = str_replace(';', '', $s);
        return $s;
    }

    $nombres = limpiar($_POST['nombres']);
    $direccion = $_POST['direccion'];
    $dni = $_POST['dni'];
    $celular = limpiar($_POST["celular"]);
    $correo = $_POST["correo"];
    
    $mensaje = limpiar($_POST["mensaje"]);
    
    $detalle = limpiar($_POST["detalle"]);
    
    $pedido = limpiar($_POST["pedido"]);
    
    $tipoReclamo = $_POST['exampleRadios'];

    $fechaPedido = $_POST['trip-start'];
    
    
    //echo 'Nombres: '.$nombres.' - Direccion: '.$direccion.' - Dni: '.$dni.' - Celular: '.$celular.' - Correo: '.$correo.' - Mensaje: '.$mensaje.' - Detalle: '.$detalle.' - Pedido: '.$pedido.' - Tipo Reclamo: '.$tipoReclamo.' - Fecha Pedido: '.$fechaPedido.' - ';
    //exit();
   
    



        $to = "libroreclamaciones@fusionwings.pe";
        $subject = "Mensaje Libro reclamaciones - Cliente ".$nombres;
        $message = "Libro de reclamaciones web fusionwings.pe:<br><br>";
        $message = $message . "<p style=' border: 2px solid #000000; border-radius: 3px;display: inline-block; padding: 10px 10px 10px 10px;;
        position: relative; '>" . $mensaje . "</p><br><br>";

        $message = $message . "Detalle del Pedido: " . $detalle . "<br><br>";

        $message = $message . "Detalle del Reclamante: " . $pedido . "<br><br>";

        $message = $message . "Fecha Pedido: " . $fechaPedido . "<br>";
        $message = $message . "Nombre: " . $nombres . "<br>";
        $message = $message . "Correo: " . $correo . "<br>";
        $message = $message . "Numero de celular: " . $celular . "<br>";


/////
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= 'From: Fusion Wings Libro Reclamaciones <noreply@fusionwings.pe>' . "\r\n";

        if (mail($to, $subject, $message, $headers)) {

            ?>
            <script>

                 window.location = '../librodereclamaciones.php?code=succes'; 
                
               
            </script>

            <?php
        } else {
            echo "Error al enviar el mensaje, contacte con el administrador";
        }



} else {
    echo "No tiene autorización para ver esta página";
}
