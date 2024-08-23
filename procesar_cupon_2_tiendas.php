<?php
session_start();
require 'class/TiendaClass.php';
$objtienda = new TiendaClass();

$cupon = $_POST['cupon'];
$cupon = mb_strtoupper($cupon);
$idTienda = $_POST['idTienda'];


/* echo $cupon;
exit(); */

/* echo $codigo_cupon;
exit(); */

if ($idTienda == 1) {
    $tienda = $objtienda->getDatosTienda();
    $codigo_cupon = $tienda['cupon'];
    //$codigo_cupon_dos = $tienda['cupon_dos'];
    $fecha_limite = $tienda['fecha_cupon'];
    $fecha_actual = date('Y-m-d');

    $_SESSION['codigo_cupon'] = $cupon;

    if ($codigo_cupon == $cupon && $fecha_actual < $fecha_limite) {
        //$objtienda->updateCupon($idTienda, $cupon);
        $_SESSION['estado_cupon'] = "activo";
        header("Location: pagar.php");
    } else {
        $_SESSION['estado_cupon'] = "inactivo";
        header("Location: pagar.php");
    }
} else {
    $tienda = $objtienda->getDatosTiendaJesusMaria();
    $codigo_cupon = $tienda['cupon'];
    $fecha_limite = $tienda['fecha_cupon'];
    $fecha_actual = date('Y-m-d');

    $_SESSION['codigo_cupon'] = $cupon;

    if ($codigo_cupon == $cupon) {
        //$objtienda->updateCupon($idTienda, $cupon);
        $_SESSION['estado_cupon'] = "activo";
        header("Location: pagar.php");
    } else {
        $_SESSION['estado_cupon'] = "inactivo";
        header("Location: pagar.php");
    }
}
