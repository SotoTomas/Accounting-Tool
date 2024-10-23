<?php
require 'includes/app.php';

$db = conectarDB();


$user = "lautysoto";
$password= "soto12345";
$passHash= password_hash($password, PASSWORD_BCRYPT);

$query = "INSERT INTO usuarios (user, password) VALUES ('$user', '$passHash')";

$stmt  = $db->prepare($query);
$stmt->execute();





