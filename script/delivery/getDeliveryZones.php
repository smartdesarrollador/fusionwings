<?php
header('Content-Type: application/json');
include '../../class/Delivery.php';
$objDelivery = new Delivery();

$data = $objDelivery->getCostoPorDistritos();

echo json_encode(['message' => 'true', 'data' => $data]);

