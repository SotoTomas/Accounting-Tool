<?php
function debugear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
     
}

function autenticado() : bool{
    session_start();
    $auth = $_SESSION['login'];
    if($auth){
        return true;
    }
        return false;
}

function ivaOperacion($number){
    $iva  = $number * 1.21;

    return  $iva;
}

echo ivaOperacion(243);