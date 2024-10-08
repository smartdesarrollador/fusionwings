<?php
set_time_limit(0);
include "class/ClienteClass.php";
$objCliente = new ClienteClass();
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


$listaClientes = $objCliente->getAllClients();

/*foreach ($listaClientes as $item){
    $idEncriptado = my_simple_crypt($item['idCliente']);


    $nombreFoto =  $idEncriptado.'.png';
    $urlQR = 'https://fusionwings.pe/r.php?u='.$idEncriptado;

 $apiQR = file_get_contents('https://worksafetytech.com/utils/qrGeneratorMaxSize.php?content=' . $urlQR);
file_put_contents('assets/img/qrCodes/'.$nombreFoto, $apiQR);

   $afecteado =  $objCliente->updateClienteQR($item['idCliente'],$nombreFoto);
   echo $afecteado.'<br>';

}*/


