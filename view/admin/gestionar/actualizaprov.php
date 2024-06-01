<?php

require '../../../model/conexion.php';

session_start();

$nit = $conexion->real_escape_string($_POST['nit']);
$razonSocial = $conexion->real_escape_string($_POST['razonsocial']);
$encargado = $conexion->real_escape_string($_POST['encargado']);
$celular = $conexion->real_escape_string($_POST['celular']);
$correo = $conexion->real_escape_string($_POST['correo']);

$sql = "UPDATE proveedores SET razonsocial ='$razonSocial', encargado = '$encargado', celular ='$celular', correo= '$correo' WHERE nit='$nit'";

if ($conexion->query($sql)) {
    $_SESSION['msg'] = 'Los datos del proveedor se han actualizado correctamente.';
    $_SESSION['color'] = 'success';

    echo '<script>window.location.href = "gestionarusuarios.php";</script>';
    exit();
} else {
    // Establecer mensaje de error
    $_SESSION['msg'] = 'Error al actualizar en la base de datos: ' . $conexion->error;
    $_SESSION['color'] = 'danger';
    echo "Error al actualizar en la base de datos: " . $conexion->error;
}


