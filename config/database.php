<?php

function conectarDB(){
    $db = new PDO('mysql:host=localhost; dbname=libroContable_crud', 'root', '3003');
     if(!$db){
         echo "No se pudo conectar";
         exit;
     }
     
     return $db;
     
    }

$db= conectarDB();
$query = "SELECT * FROM ventas";

$stmt = $db->prepare($query);

$stmt->execute();

$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// foreach ($resultado as $venta):
//     debugear($venta);

// endforeach;




