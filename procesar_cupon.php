<?php
session_start();
require 'class/TiendaClass.php';
$objtienda = new TiendaClass();

$cupon = $_POST['cupon'];
//$cupon = mb_strtoupper($cupon);
$idTienda = $_POST['idTienda'];



$tienda = $objtienda->getDatosTienda();
$codigo_cupon = $tienda['cupon'];
$codigo_cupon_dos = $tienda['cupon_dos'];

$_SESSION['codigo_cupon'] = $cupon;

/* echo $cupon;
exit(); */

/* echo $codigo_cupon;
exit(); */



if ($codigo_cupon == $cupon || $codigo_cupon_dos == $cupon) {
    //$objtienda->updateCupon($idTienda, $cupon);
    $_SESSION['estado_cupon'] = "activo";
    header("Location: pagar.php");
} else {
    $_SESSION['estado_cupon'] = "inactivo";
    header("Location: pagar.php");
}
