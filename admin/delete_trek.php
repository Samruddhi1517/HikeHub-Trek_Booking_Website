<?php
require '../db.php';

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
    DELETE FROM treks 
    WHERE id=?
");

$stmt->bind_param("i",$id);

$stmt->execute();

header("Location: dashboard.php");
exit;