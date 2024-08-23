<?php
header('Content-Type: application/json');

include_once '../../class/Cart.php';
$cart = new Cart();
$cart->destroy();
echo json_encode(['ok' => 'true', 'message' => 'Carrito eliminado correctamente']);
