<?php

require '../../../model/conexion.php';

session_start();

$id = $conexion->real_escape_string($_POST['id']);

$sql = "DELETE FROM usuarios WHERE id=$id";

if ($conexion->query($sql)) {
    $_SESSION['msg'] = 'El usuario se ha eliminado correctamente.';
    $_SESSION['color'] = 'success';

    header("Location: gestionarusuarios.php");
    exit();
} else {
    $_SESSION['msg'] = 'Error al eliminar en la base de datos: ' . $conexion->error;
    $_SESSION['color'] = 'danger';

    echo "Error al eliminar en la base de datos: " . $conexion->error;
}
