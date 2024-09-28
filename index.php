<?php
include 'config/conf.php';

$conexion = new Conexion();
$conn = $conexion->Conectar();

if ($conn) {
    echo "Conexión establecida.";
} else {
    echo "No se pudo conectar.";
}
?>
