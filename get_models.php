<?php
include __DIR__ . '/php/connect.php';

$make = $_GET['make'] ?? '';

$modelQuery = "SELECT DISTINCT model FROM cars WHERE make = :make ORDER BY model ASC";
$modelSTM = $con->prepare($modelQuery);
$modelSTM->bindParam(':make', $make, PDO::PARAM_STR);
$modelSTM->execute(a);

$models = $modelSTM->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($models);
?>
