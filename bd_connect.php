<?php

$dsn = 'mysql:host=localhost;dbname=digital_store;charset=utf8mb4';
$user = 'root';
$psw = '';

try {
    $db = new PDO($dsn, $user, $psw);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}