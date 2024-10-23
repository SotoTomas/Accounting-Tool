<?php
require 'includes/app.php';

$errores= [];

if($_SERVER ["REQUEST_METHOD"] == "POST"){

    $user = filter_var($_POST["user"],  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = $_POST ["password"];

    if(!$user || !$password){
         $errores[] = "Debes llenar todos los campos"; 
    }  

    if(empty ($errores)){
        $query = "SELECT  * FROM usuarios WHERE user = '$user'";
        $stmt = $db->prepare($query);
        $stmt ->execute();

        if($stmt->rowCount() > 0) {
            $user =  $stmt->fetch();

            $auth = password_verify($password,  $user['password']);

            if($auth){ 
                session_start();
                $_SESSION['user'] = $user['user'];
                $_SESSION['login']  = true;
                header('Location: /admin');
            }else{
                $errores[] = "Contraseña incorrecta";
            }
        }else{
            $errores[] = "El usuario no existe";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="build/css/app.css">
    <title>libroContable</title>
</head>
<body>
        <div class="contenedor">
            <?php foreach  ($errores as $error): ?>
                <div class="alerta error">
                    <?php  echo $error; ?>
                </div>
 
            <?php endforeach; ?>
            <form method="POST" class="login">
                <label for="user">Usuario:</label>
                <input class="input" name="user"  required type="text" id="user" placeholder="Ingrese aquí su usuario">
    
                <label for="pass">Contraseña:</label>
                <input class="input" name="password" required type="password" id="pass" placeholder="Ingrese aquí su contraseña">
                <button class="boton-login" type="submit">Iniciar Sesión</button>
            </form>
        </div>
</body>
</html>