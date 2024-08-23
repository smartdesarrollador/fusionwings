<?php
include '../class/Delivery.php';
$objDelivery = new Delivery();

$name = $_POST['name'];
$coords = $_POST['coords'];
$price = $_POST['price'];
$idTienda = $_POST['idTienda'];



$distritosConCosto = $objDelivery->addNewDeliveryZone($name, $coords, $price, $idTienda);
