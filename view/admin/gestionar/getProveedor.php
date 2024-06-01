<?php

require '../../../model/conexion.php';

$nit = $conexion->real_escape_string($_POST['nit']);

$sqlProveedores = "SELECT nit, razonsocial, encargado, celular, correo FROM proveedores WHERE nit='$nit' LIMIT 1";
$resultado = $conexion->query($sqlProveedores);
$rows = $resultado->num_rows;

$proveedores = [];

if($rows > 0){
    $proveedores = $resultado->fetch_array();
}

echo json_encode($proveedores, JSON_UNESCAPED_UNICODE);