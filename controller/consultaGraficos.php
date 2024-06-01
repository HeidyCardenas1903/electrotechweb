<?php
include '../../model/conexion.php';

// Consulta para obtener el número de ventas por producto
$sql = "SELECT p.nombre AS producto, SUM(df.cantidad) AS cantidad_vendida
        FROM detallefactura df
        INNER JOIN productos p ON df.id_producto = p.id
        GROUP BY df.id_producto
        ORDER BY cantidad_vendida DESC";

$result = $conexion->query($sql);

// Arreglo para almacenar los datos de los productos más vendidos
$productos_mas_vendidos = [];
while ($row = $result->fetch_assoc()) {
    $productos_mas_vendidos[$row["producto"]] = $row["cantidad_vendida"];
}

// Consulta SQL para obtener el número de ventas por mes
$query_ventas_por_mes = "SELECT MONTH(fecha) AS mes, COUNT(*) AS total_ventas FROM facturas GROUP BY MONTH(fecha)";
$resultado_ventas_por_mes = $conexion->query($query_ventas_por_mes);

// Inicializar un array para almacenar las ventas por mes
$ventas_por_mes = array_fill(0, 12, 0); // Inicializa el array con 12 elementos, todos con valor 0

// Llenar el array con los datos de la base de datos
while ($fila_ventas_por_mes = $resultado_ventas_por_mes->fetch_assoc()) {
    $mes = $fila_ventas_por_mes['mes'] - 1; // Restar 1 porque los meses en PHP se indexan desde 0
    $total_ventas = $fila_ventas_por_mes['total_ventas'];
    $ventas_por_mes[$mes] = $total_ventas;
}

// Convertir el array PHP a JSON para ser utilizado en JavaScript
$ventas_por_mes_json = json_encode($ventas_por_mes);