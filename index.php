<?php 
include '../includes/app.php';
$db= conectarDB();
$auth = autenticado();

if(!$auth){
    header('Location: ../');
}
if($_SERVER[  'REQUEST_METHOD' ] == 'POST'){
     $id = $_POST['id_venta'];    

     
     function eliminar(){
         
         $db  = conectarDB();
         $id = $_POST['id_venta'];
         if($id){
             $sql = "DELETE FROM ventas WHERE id_venta = '$id'";
             
             $resultado = $db->query($sql);
             if($resultado){
                 header(  'Location: /admin' );
                }else{
                    echo "Error al eliminar venta";
                }
            }
        }
        eliminar();
    }

function getInfo(){
    $db= conectarDB();

    $query = "SELECT ventas.*, productos.prod_nombre AS venta_producto 
              FROM ventas 
              JOIN productos ON ventas.venta_producto = productos.id_producto";

    $stmt=  $db->prepare($query);
    $stmt->execute();
    $resultados  = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $resultados; // Devuelve los resultados
}

$resultados = getInfo(); // Llama a la función y guarda los resultados
$cantidadResultados = count($resultados);
$gananciaBrutaTotal = 0; // Inicializa la variable para la ganancia total


foreach ($resultados as $resultado) {
    $gananciaBrutaTotal += $resultado['venta_total']; // Suma el total de cada venta
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
        <h1>Ventas</h1>
        <div class='total'>
            <p class="info">Información General</p>
            <p class='ventas-totales'>Hay un total de <?php echo $cantidadResultados; ?> ventas</p>  
            <p>Ganancia Bruta: $<?php echo $gananciaBrutaTotal; ?></p>
        </div>
        <div class='total-ventas'>
            <?php foreach ($resultados as $resultado): ?>
                <div class='venta'>
                    <form class="close-form" method= "POST">
                        <input type="hidden" name="id_venta" value="<?php echo $resultado['id_venta']; ?>">
                        <input type="submit" name="id" value=" Eliminar">
                    </form>

                    <p>ID: <?php echo $resultado['id_venta']; ?></p>
                    <p>Comprador: <?php echo $resultado['venta_nombre_comprador']; ?></p> 
                    <p>Producto: <?php echo $resultado['venta_producto']; ?></p> 
                    <p>Precio Bruto Individual: $650</p> 
                    <p>Cantidad: <?php echo $resultado['venta_cantidad']; ?></p> 
                    <p>Metodo de Pago: <?php echo $resultado['venta_met_pago']; ?></p> 
                    <p>IVA: $<?php echo $resultado['venta_iva']; ?></p> 
                    <p>Total: $<?php echo $resultado['venta_total']; ?></p> 
                </div>  
            <?php endforeach; ?>
        </div>
    </main>

    <script src="/build/js/bundle.js"></script>
</body>
</html>