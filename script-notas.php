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


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['nota'])) {
    require_once 'conexionMysql/conexion.php'; // Conexión a la base de datos
    $conex = ConectarDB();

    $notaTexto = $conex->real_escape_string($_POST['nota']);
    $idEntrega = isset($_POST['idEntrega']) ? $conex->real_escape_string($_POST['idEntrega']) : 0; // Obteniendo idEntrega del formulario

    // Asumiendo que el nombre de usuario está almacenado en $_SESSION['nombreUsuario'] al iniciar sesión
    // $usuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : 'UsuarioDesconocido'; // Usar un valor por defecto o manejar como prefieras

    date_default_timezone_set('America/Bogota');
    $fechaHora = date('Y-m-d H:i:s');

    // Consulta SQL para insertar la nueva nota
    $query = "INSERT INTO notas (idEntrega, nombreUsuario, nota, fechaHora, idUsuario) VALUES ('{$idEntrega}', '{$nombreUsuario}', '{$notaTexto}', '{$fechaHora}', '{$usuarioId}')";

    if ($conex->query($query) === TRUE) {
        // Guardar mensaje de éxito en sesión
        $_SESSION['mensaje'] = "Nota agregada exitosamente.";
        $_SESSION['idEntrega'] = $idEntrega; // Guardar en sesión el ID de entrega para referencia
    
        // Redirigir a detalle.php
        header('Location: detalle.php');
        exit;
    } else {
        echo "Error al agregar nota: " . $conex->error;
    }
} else {
    echo "Por favor, escribe una nota antes de enviar.";
}

?>
