<?php
function ConectarDB() {
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "firplak_bd";

    $cnx = mysqli_connect($servidor, $usuario, $clave, $bd);

    // Verifica la conexión antes de intentar establecer el conjunto de caracteres
    if ($cnx === false) {
        die("ERROR: No se pudo conectar. " . mysqli_connect_error());
    }

    // Establece el conjunto de caracteres a utf8
    $cnx->set_charset("utf8");

    return $cnx;
}
?>
