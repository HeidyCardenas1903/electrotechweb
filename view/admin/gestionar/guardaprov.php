<?php

require '../../../model/conexion.php';

session_start();

$nit = $conexion->real_escape_string($_POST['nit']);
$razonsocial = $conexion->real_escape_string($_POST['razonsocial']);
$encargado = $conexion->real_escape_string($_POST['encargado']);
$celular = $conexion->real_escape_string($_POST['celular']);
$correo = $conexion->real_escape_string($_POST['correo']);

$sql = "INSERT INTO proveedores (nit, razonsocial, encargado, celular, correo) VALUES ('$nit', '$razonsocial', '$encargado', '$celular', '$correo')";

if ($conexion->query($sql)) {
    $id = $conexion->insert_id;

    $_SESSION['msg'] = 'Proveedor registrado exitosamente.';
    $_SESSION['color'] = 'success';

    echo '<script>window.location.href = "gestionarusuarios.php";</script>';
    exit();
} else {
    $_SESSION['msg'] = 'Error al insertar en la base de datos: ' . $conexion->error;
    $_SESSION['color'] = 'danger';
    echo "Error al insertar en la base de datos: " . $conexion->error;
}


