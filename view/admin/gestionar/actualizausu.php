<?php

require '../../../model/conexion.php';

session_start();

$id = $conexion->real_escape_string($_POST['id']);
$nombre = $conexion->real_escape_string($_POST['nombre']);
$username = $conexion->real_escape_string($_POST['username']);
$password = $_POST['password'];
$passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);
$email = $conexion->real_escape_string($_POST['email']);
$rol = $conexion->real_escape_string($_POST['rol']);

$sql = "UPDATE usuarios SET nombre ='$nombre', username = '$username', email ='$email', password ='$passwordEncriptada', id_rol= $rol WHERE id=$id";

if ($conexion->query($sql)) {
    $_SESSION['msg'] = 'Los datos del usuario se han actualizado correctamente.';
    $_SESSION['color'] = 'success';

    echo '<script>window.location.href = "gestionarusuarios.php";</script>';
    exit();
} else {
    $_SESSION['msg'] = 'Error al insertar en la base de datos: ' . $conexion->error;
    $_SESSION['color'] = 'danger';
    echo "Error al insertar en la base de datos: " . $conexion->error;
}
