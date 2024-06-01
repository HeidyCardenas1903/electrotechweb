<?php

require '../../../model/conexion.php';

session_start(); // Iniciar sesión para gestionar mensajes

$id = $conexion->real_escape_string($_POST['id']);
$nombres = $conexion->real_escape_string($_POST['nombres']);
$apellidos = $conexion->real_escape_string($_POST['apellidos']);
$email = $conexion->real_escape_string($_POST['email']);
$telefono = $conexion->real_escape_string($_POST['telefono']);

$sql = "UPDATE clientes SET nombre ='$nombres', apellido = '$apellidos', email ='$email', telefono= '$telefono' WHERE id=$id";

if ($conexion->query($sql)) {
    $_SESSION['msg'] = 'Los datos del cliente se han actualizado correctamente.';
    $_SESSION['color'] = 'success';

    echo '<script>window.location.href = "gestionarusuarios.php";</script>';
    exit();
} else {
    $_SESSION['msg'] = 'Error al actualizar en la base de datos: ' . $conexion->error;
    $_SESSION['color'] = 'danger';
    echo "Error al actualizar en la base de datos: " . $conexion->error;
}

