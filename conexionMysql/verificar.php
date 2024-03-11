<?php

require("conexion.php");

$conex=ConectarDB();

if($conex) {
    echo "conexión exitosa ;)";
} else {
    "Error en conexión  :(";
}
?>
