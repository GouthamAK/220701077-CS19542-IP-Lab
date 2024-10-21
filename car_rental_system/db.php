<?php
$host = 'localhost'; 
$dbname = 'car_rental'; 
$username = 'root'; 
$password = ''; 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
