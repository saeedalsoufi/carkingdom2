<?php
try {
    $host = 'localhost';
    $db_name = 'carkingdomcity';
    $user_name = 'carphp';
    $user_password = 'Whereismy1$';
    $con = new PDO("mysql:host=$host;dbname=$db_name", $user_name, $user_password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
