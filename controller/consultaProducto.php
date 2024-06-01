<?php

include "../../model/conexion.php";

// Consulta para obtener el producto más vendido del momento
$sql = "SELECT p.nombre AS producto, SUM(df.cantidad) AS cantidad_vendida, p.precio AS precio
        FROM detallefactura df
        INNER JOIN productos p ON df.id_producto = p.id
        GROUP BY df.id_producto
        ORDER BY SUM(df.cantidad) DESC
        LIMIT 1";

$result = $conexion->query($sql);

// Obtener los datos del producto más vendido del momento
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre_producto = $row["producto"];
    $cantidad_vendida = $row["cantidad_vendida"];
    $precio_producto = $row["precio"];
} else {
    // Si no hay resultados, establecer valores predeterminados
    $nombre_producto = "Producto no encontrado";
    $cantidad_vendida = 0;
    $precio_producto = 0;
}