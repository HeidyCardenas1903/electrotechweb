<?php
session_start();
include "../../../model/conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: ../view/login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

$consulta = "SELECT * FROM usuarios WHERE username='$usuario'";
$resultado = $conexion->query($consulta);

if ($resultado && $resultado->num_rows > 0) {
    $usuarioData = $resultado->fetch_assoc();
} else {
    echo "<script>alert('No se encontraron los datos del usuario');</script>";
}

$resultado->free_result();
$conexion->close();