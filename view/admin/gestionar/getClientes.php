<?php

require '../../../model/conexion.php';

$id = $conexion->real_escape_string($_POST['id']);

$sqlClientes = "SELECT id, nombre, apellido, email, telefono FROM clientes WHERE id=$id LIMIT 1";
$resultado = $conexion->query($sqlClientes);
$rows = $resultado->num_rows;

$clientes = [];

if($rows > 0){
    $clientes = $resultado->fetch_array();
}

echo json_encode($clientes, JSON_UNESCAPED_UNICODE);