<?php
session_start();

include '../class/ProductoClass.php';
$objProducto = new ProductoClass();

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
    $s = str_replace('ñ', 'n', $s);

    return $s;
}

function limpiarEspacio($s)
{
    $s = str_replace(" ", "", $s);


    return $s;
}


if ($_POST['action']=='submit'){
$foto = $_FILES["foto"]['name'];
$nombreProducto = trim($_POST['nombreProducto']);
$descripcionProducto = trim($_POST['descripcionProducto']);
$tipoProducto = $_POST['tipoProducto'];
$precioProducto = floatval($_POST['precioProducto']);
$puntosProducto = intval($_POST['puntosProducto']);
$storeId = intval($_POST['storeId']);

$nombreFoto = limpiarEspacio(limpiar($nombreProducto.uniqid())).'.jpg';
$destino ='../assets/img/promos/'.$nombreFoto;


    if (copy($_FILES['foto']['tmp_name'], $destino)) {
        $affectedRows = $objProducto->addNewProducto($nombreProducto,$descripcionProducto,$nombreFoto,$tipoProducto,$precioProducto,$puntosProducto,$storeId);
        if ($affectedRows>0){
            header('location: https://operaciones.elegipcio.pe/productos?code=success');
        }else{
            echo "Error inesperado, contacte con el administrador";
        }

    }

}
