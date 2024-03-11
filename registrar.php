<?php 
require_once("conexionMysql/conexion.php");
$conexion = ConectarDB();

if (!empty($_POST["btnregistrar2"])) {
    if (!empty($_FILES["imagen"]["tmp_name"]) && isset($_POST["idEntrega"])) {
        $imagen = $_FILES["imagen"]["tmp_name"];
        $nombreImagen = $_FILES["imagen"]["name"];
        $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
        $directorio = "pruebas/";
        $idEntregaLimpio = filter_var($_POST["idEntrega"], FILTER_SANITIZE_NUMBER_INT);

        if ($tipoImagen == "jpg" or $tipoImagen == "jpeg" or $tipoImagen == "png" or $tipoImagen == "webp") {
            $conexion->begin_transaction();

            try {
                $stmtVerificacion = $conexion->prepare("SELECT e.estadoEntrega, 
                (SELECT COUNT(*) FROM pruebadeentrega WHERE idEntrega = e.idEntrega) AS numPruebas 
                FROM entregas AS e 
                WHERE e.idEntrega = ?");
                $stmtVerificacion->bind_param("i", $idEntregaLimpio);
                $stmtVerificacion->execute();
                $resultadoVerificacion = $stmtVerificacion->get_result()->fetch_assoc();
                
                // if ($resultadoVerificacion && ($resultadoVerificacion['estadoEntrega'] === 'Creado' || $resultadoVerificacion['estadoEntrega'] === 'Despachado') && $resultadoVerificacion['numPruebas'] == 0) {
                if ($resultadoVerificacion && ($resultadoVerificacion['estadoEntrega'] === 'Creado' || $resultadoVerificacion['estadoEntrega'] === 'Despachado')) {

                    $stmt = $conexion->prepare("INSERT INTO pruebadeentrega(idEntrega, ubicacionPrueba) VALUES(?, '')");

                    $stmt->bind_param("i", $idEntregaLimpio);
                    $stmt->execute();
                    
                    if ($stmt->affected_rows > 0) {
                        $idRegistro = $stmt->insert_id;
                        $ruta = $directorio . $idRegistro . "." . $tipoImagen;
                        
                        if (move_uploaded_file($imagen, $ruta)) {
                            $stmtUpdate = $conexion->prepare("UPDATE pruebadeentrega SET ubicacionPrueba=? WHERE idPruebaEntrega=?");
                            $stmtUpdate->bind_param("si", $ruta, $idRegistro);
                            $stmtUpdate->execute();
                            
                            // Aquí actualizamos el estado de la entrega y la fechaEntrega al mismo tiempo.
                            $stmtEstado = $conexion->prepare("UPDATE entregas SET estadoEntrega='Entregado', fechaEntrega=NOW() WHERE idEntrega=?");
                            $stmtEstado->bind_param("i", $idEntregaLimpio);
                            $stmtEstado->execute();

                            echo "<div class='alert alert-success'>Imagen guardada y estado actualizado con éxito, fecha de entrega registrada.</div>";
                        } else {
                            throw new Exception("Error al guardar la imagen.");
                        }
                    } else {
                        throw new Exception("Error al registrar la prueba de entrega.");
                    }
                } else {
                    echo "<div class='alert alert-info'>No se cambió el estado porque no se cumplen las condiciones o ya existe una prueba de entrega.</div>";
                }

                $conexion->commit();
            } catch (Exception $e) {
                $conexion->rollback();
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }

            if (isset($stmtVerificacion)) $stmtVerificacion->close();
            if (isset($stmt)) $stmt->close();
            if (isset($stmtUpdate)) $stmtUpdate->close();
            if (isset($stmtEstado)) $stmtEstado->close();
        } else {
            echo "<div class='alert alert-info'>No se acepta el formato .$tipoImagen, debe ser JPG, JPEG, PNG o WEBP.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Por favor, seleccione un archivo e ingrese un ID de entrega válido.</div>";
    }
}
?>
