<?php
include '../class/const.php';
error_reporting(0);
/**
 * CODIGO QUE MODIFICAR :
 * -user y password de la BD  --LINEA 53
 * -correo de destino para la funcion mail() -- LINEA 118
 * -nombre del servidor --LINEA 116
 * -el mensaje TIENE QUE CONTENER UN LINK PARA DESCARGAR EL PDF  -- LINEA 115
 * --------mguevara@enfocussoluciones.com--------------------
 *
**/

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
    $s= str_replace('ú', 'u', $s);

    $s= str_replace('"', '', $s);
    $s= str_replace(':', '', $s);
    $s= str_replace('.', '', $s);
    $s= str_replace(',', '', $s);
    $s= str_replace(';', '', $s);
    return $s;
}
function limpiarEspacio($s)
{
    $s = str_replace(" ", "", $s);


    return $s;
}



        $nombre = limpiar($_REQUEST["nombre"]);
        $apellido = limpiar($_REQUEST["apellido"]);
        $edad = limpiar($_REQUEST["edad"]);
        $correo = $_REQUEST["correo"];
        $cel = limpiar($_REQUEST["cel"]);


if ($nombre != "" && $apellido != "" && $edad != "" && $correo != "" &&  $cel != ""){



$servername = SERVIDOR;
$username = USUARIO;
$password = PASSWORD;
$dbname = BASEDATOS;

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




$status = "";
if ($_POST["action"] == "upload")
{


    if($_FILES["archivo"]["type"]=="application/pdf" || $_FILES["archivo"]["type"]=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $_FILES["archivo"]["type"] == "application/msword"){

        // obtenemos los datos del archivo
            $tamano = $_FILES["archivo"]['size'];
           $type=     $_FILES["archivo"]["type"];
            $archivo = $_FILES["archivo"]['name'];
            $nuevoNombre = limpiarEspacio($apellido);
             $extension="";
             if ($_FILES["archivo"]["type"]=="application/pdf"){$extension = ".pdf";};
             if ($_FILES["archivo"]["type"]=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"){$extension = ".docx";};
             if ($_FILES["archivo"]["type"]=="application/msword"){$extension = ".doc";};


        if ($archivo != "")
        {
            // guardamos el archivo a la carpeta ficheros
                
            $random = $nuevoNombre.uniqid().$extension;
            $destino =  "../assets/cvs/". $random;

            if (copy($_FILES['archivo']['tmp_name'],$destino))
            {

                $sql = "INSERT INTO postulante (nombre, apellido,edad,correo,celular,nombreCv)
                            VALUES ('$nombre', '$apellido','$edad','$correo','$cel', '$random')";

                if ($conn->query($sql) === TRUE) {


                    error_reporting( E_ALL );

                    $to = "rafat@elegipcio.pe, bolsadetrabajo@elegipcio.pe";
                    $subject = "Nuevo Postulante";
                    $message ="Nuevo Postulante:<br><br>";
                    $message=$message."Nombre: ". $nombre ."<br>";
                    $message=$message."Apellido: ". $apellido ."<br>";
                    $message=$message."Edad: ". $edad ."<br>";
                    $message=$message."Correo: ". $edad ."<br>";
                    $message=$message."Celular: ". $cel ."<br>";

                        $message=$message."<br>Descargar CV : <a href='https://www.elegipcio.pe/assets/cvs/".$random."'>'elegipcio.pe/cvs/".$random."</a>'";

/////
                          $headers = "MIME-Version: 1.0" . "\r\n";
                          $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                          $headers .= 'From: EL EGIPCIO - AVISOS<avisos@egipcio.pe>' . "\r\n";
                    
                    if(mail($to,$subject,$message, $headers)){

                        ?>
                        <script>

                            window.location = '../cv.php?code=success';
                        </script>

                        <?php
                    }else{
                        echo "Error  interno, contacte con el administrador";
                    }

                ;


                } else {


                    echo "Error: " . $sql . "<br>" . $conn->error;


                }

                $conn->close();


               echo $status = "Archivo subido";
                echo $type;

            }
            else
            {
                echo  $status = "Error al subir el archivo";
            }
        }
    }
    else{

        ?>
            <script>

                window.location = '../cv.php?err=wrongType';
            </script>

        <?php


    }
}

}else{
    ?>
    <script>

        window.location = '../cv.php?err=nullInput';

    </script>

    <?php

}
