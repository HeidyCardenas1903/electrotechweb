<?php
include '../../model/conexion.php';

// Consulta SQL para obtener el número de clientes registrados
$query_clientes = "SELECT COUNT(*) AS total_clientes FROM clientes";
$resultado_clientes = $conexion->query($query_clientes);
$fila_clientes = $resultado_clientes->fetch_assoc();
$total_clientes = $fila_clientes['total_clientes'];

// Consulta SQL para obtener el número de productos disponibles en stock
$query_productos = "SELECT COUNT(*) AS total_productos FROM productos WHERE stock > 0";
$resultado_productos = $conexion->query($query_productos);
$fila_productos = $resultado_productos->fetch_assoc();
$total_productos = $fila_productos['total_productos'];

// Consulta SQL para obtener el número de usuarios registrados
$query_usuarios = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
$resultado_usuarios = $conexion->query($query_usuarios);
$fila_usuarios = $resultado_usuarios->fetch_assoc();
$total_usuarios = $fila_usuarios['total_usuarios'];

// Consulta SQL para obtener el número de ventas realizadas este mes
$query_ventas_mes = "SELECT COUNT(*) AS total_ventas FROM facturas WHERE MONTH(fecha) = MONTH(CURRENT_DATE())";
$resultado_ventas_mes = $conexion->query($query_ventas_mes);
$fila_ventas_mes = $resultado_ventas_mes->fetch_assoc();
$total_ventas_mes = $fila_ventas_mes['total_ventas'];

// Consulta SQL para obtener los ingresos generados este mes
$query_ingresos_mes = "SELECT COALESCE(SUM(totalfactura), 0) AS total_ingresos FROM facturas WHERE MONTH(fecha) = MONTH(CURRENT_DATE())";
$resultado_ingresos_mes = $conexion->query($query_ingresos_mes);
$fila_ingresos_mes = $resultado_ingresos_mes->fetch_assoc();
$total_ingresos_mes = $fila_ingresos_mes['total_ingresos'];

// Consulta SQL para obtener el total de productos vendidos este mes
$query_productos_vendidos_mes = "SELECT COALESCE(SUM(cantidad), 0) AS total_productos_vendidos FROM detallefactura WHERE id_factura IN (SELECT id FROM facturas WHERE MONTH(fecha) = MONTH(CURRENT_DATE()))";
$resultado_productos_vendidos_mes = $conexion->query($query_productos_vendidos_mes);
$fila_productos_vendidos_mes = $resultado_productos_vendidos_mes->fetch_assoc();
$total_productos_vendidos_mes = $fila_productos_vendidos_mes['total_productos_vendidos'];
