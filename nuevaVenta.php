<?php 
include '../includes/app.php';
$db= conectarDB();
$auth = autenticado();
if(!$auth){
    header('Location: ../');
}

$errores = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venta_nombre_comprador = $_POST['venta_nombre_comprador'];
    $venta_met_pago = $_POST['venta_met_pago'];
    $venta_producto = $_POST['venta_producto'];
    $venta_cantidad = $_POST['venta_cantidad'];

    if(empty($venta_nombre_comprador || $venta_met_pago || $venta_producto || $venta_cantidad)){
        $errores[] = "Todos los campos son obligatorios";
    }

    // Supongamos que el precio del pastelito es 100
    $precioPorUnidad = 650; // Cambia este valor según el precio real del producto

    // Calcula el subtotal, IVA y total
    $subtotal = $precioPorUnidad * $venta_cantidad;
    $venta_iva = 0.21 * $subtotal; // IVA del 21%
    $venta_total = $subtotal + $venta_iva;

    // Preparar la consulta SQL
    $query = "INSERT INTO ventas (venta_nombre_comprador, venta_met_pago, venta_iva, venta_total, venta_producto, venta_cantidad) 
    VALUES (:venta_nombre_comprador, :venta_met_pago, :venta_iva, :venta_total, :venta_producto, :venta_cantidad)";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':venta_nombre_comprador', $venta_nombre_comprador);
    $stmt->bindParam(':venta_met_pago', $venta_met_pago);
    $stmt->bindParam(':venta_iva', $venta_iva);
    $stmt->bindParam(':venta_total', $venta_total);
    $stmt->bindParam(':venta_producto', $venta_producto);
    $stmt->bindParam(':venta_cantidad', $venta_cantidad);
    $stmt->execute();
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
                <li><a href="index.php">Ventas</a></li>
                <li class="seccion"><a href="#">Nueva Venta</a></li>
            </ul>
        </div>
        <main class="contenedor">
            <h1>Nueva Venta</h1>
        <form class="nueva-venta" method="POST"> 
        <label for="nombre">Nombre comprador:</label>
            <input type="text" id="nombre" name="venta_nombre_comprador" required>

            <label for="producto">Producto vendido: </label>
            <select id="producto" required name="venta_producto">
                <option value="1">Pastelito($650)</option>
            </select>

            <label for="cantidad">Cantidad a comprar: </label>
            <input type="number" id="cantidad" name="venta_cantidad" min="0" required oninput="calcularTotales()">

            <label for="metodoPago">Metodo de Pago: </label>
            <select id="metodoPago" required name="venta_met_pago">
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Credito/Debito</option>
            </select>

            <p>Subtotal: $<span id="subtotal">$0.00</span></p>
            <p>Iva: $<span id="iva">0.00</span></p>
            <p>Total: $<span id="total">0.00</span></p>

            <button type="submit" class="boton-login">Cargar Venta</button>

        </form>
        
    </div>
</main>
<script src="/build/js/bundle.js"></script>
</body>
</html>



