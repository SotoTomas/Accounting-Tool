<?php 
include '../includes/app.php';
$db= conectarDB();
$auth = autenticado();

if(!$auth){
    header('Location: ../');
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/build/css/app.css"> 
    <title>panel de administración</title>
</head>
<body>
    <div class="sidebar">
        <h1> Panel de administración</h1>
        <ul>
            <li class="seccion"><a href="#">Ventas</a></li>
            <li><a href="/admin/nuevaVenta.php">Nueva Venta</a></li>
        </ul>
    </div>

    <main class="content">
        <h1>Contenido Principal</h1>
        <p>Aquí va el contenido de la página.</p>
    </main>
    <script src="/build/js/bundle.js"></script>
</body>
</html>
