<?php
// Iniciar sesión al comienzo de loginVerificar.php
session_start();

ob_start();
require_once("conexionMysql/conexion.php");
// Asegúrate de que la ruta sea correcta

if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) or empty($_POST["password"])) {
        echo '<div class="alert alert-danger">DEBES COMPLETAR AMBOS DATOS.</div>';
    } else {
        $usuario = $_POST["usuario"];
        $clave = $_POST["password"];

        // Obtener la conexión
        $cnx = ConectarDB();

        $usuario = $cnx->real_escape_string($usuario); // Limpiar la entrada
        $clave = $cnx->real_escape_string($clave); // Limpiar la entrada

        // Ahora sí, intenta realizar tu consulta
        $sqlLogin = $cnx->query("SELECT * FROM usuarios WHERE documentoUsuario='$usuario' AND clave='$clave'");
        if ($datos = $sqlLogin->fetch_object()) {
            // Almacenar datos en la sesión
            $_SESSION['usuario_id'] = $datos->idUsuario; // Suponiendo que 'idUsuario' es el nombre de la columna en tu base de datos
            $_SESSION['nombre_usuario'] = $datos->nombreUsuario; 
            $_SESSION['rol'] = $datos->rol; 
            $_SESSION['usuario'] = $usuario; // Documento del usuario        
            // Redireccionar al usuario
            echo '<script>window.location.href = "index.php";</script>';
            exit();
        }
    }    
}