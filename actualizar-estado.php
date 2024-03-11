<?php

session_start();

if(isset($_SESSION['usuario_id'])) {
    $usuarioId = $_SESSION['usuario_id'];
    $nombreUsuario = $_SESSION['nombre_usuario'];
    $rolUsuario = $_SESSION['rol'];
    $documentoUsuario = $_SESSION['usuario']; // Documento del usuario
} else {
    header('Location: login.php');
    exit();
}



// Conexión a la base de datos
require_once("conexionMysql/conexion.php");
$conex = ConectarDB();

// Verificar la conexión
if ($conex->connect_error) {
    die("Conexión fallida: " . $conex->connect_error);
}

// Recoger los valores del formulario
$idEntregaLimpio = $_POST['idEntregaLimpio'];
$estadoEntrega = $_POST['estadoEntrega'];

// Preparar la consulta SQL para actualizar el estado
$sql = "UPDATE entregas SET estadoEntrega='{$estadoEntrega}' WHERE idEntrega='{$idEntregaLimpio}'";

if ($conex->query($sql) === TRUE) {
        // Guardar mensaje de éxito en sesión
        $_SESSION['mensaje_estado'] = "Estado actualizado";
        $_SESSION['idEntrega'] = $idEntrega;
    
        // Redirigir a detalle.php
        header('Location: index.php');
        exit;
} else {
    echo "Error al actualizar el estado: " . $conex->error;
}

// Cerrar la conexión
$conex->close();
?>
