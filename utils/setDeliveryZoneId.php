<?php
session_start();
header('Content-Type: application/json');
include_once '../class/Delivery.php';
$deliveryZoneId = $_POST['deliveryZone'];
if (strlen($deliveryZoneId) <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => 'false', 'message' => 'Por favor envie un deliveryzoneId valido']);
    exit();
}

$objDelivery = new Delivery();

$data = $objDelivery->getDeliveryZoneById($deliveryZoneId);
$_SESSION['deliveryZoneId'] = $data['id'];

echo json_encode(['ok' => 'true', 'data' => $data]);
