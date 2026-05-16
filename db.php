<?php

$DB_HOST = "127.0.0.1";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "trek_site";
$DB_PORT = 3307;

$conn = new mysqli(
    $DB_HOST,
    $DB_USER,
    $DB_PASS,
    $DB_NAME,
    $DB_PORT
);

if($conn->connect_error){
    die("Database Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>