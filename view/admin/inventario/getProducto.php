<?php

require '../../../model/conexion.php';

$id = $conexion->real_escape_string($_POST['id']);

$sql_prod = "SELECT id, nombre, descripcion, precio, id_proveedor, stock from productos WHERE id = $id LIMIT 1";
$resultado = $conexion->query($sql_prod);
$rows = $resultado->num_rows;

$producto = [];

if($rows > 0){
    $producto = $resultado->fetch_array();
}

echo json_encode($producto, JSON_UNESCAPED_UNICODE);