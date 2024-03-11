<?php
function formatearFechaEspañol($fecha) {
    if (!$fecha) {
        return 'Aún no se entrega';
    }
    $timestamp = strtotime($fecha);
    setlocale(LC_TIME, 'es_ES.UTF-8', 'spanish');
    return strftime("%d de %B del %Y", $timestamp);
}
?>