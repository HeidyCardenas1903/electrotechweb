<?php

require '../../../model/conexion.php';

session_start();

if (isset($_POST['nit'])) {
    $nit = $conexion->real_escape_string($_POST['nit']);
    $query_anular = "CALL anular_factura($nit)";

    if ($conexion->query($query_anular)) {
        // $_SESSION['msg'] = 'La factura se ha anulado correctamente.';
        // $_SESSION['color'] = 'success';

        header("Location: facturasadmin.php");
        exit();
    } else {
        $_SESSION['msg'] = 'Error al anular la factura: ' . $conexion->error;
        $_SESSION['color'] = 'danger';

        echo "Error al anular la factura " . $conexion->error;
    }
} else {
    $_SESSION['msg'] = 'Error: NIT no proporcionado para la anulación.';
    $_SESSION['color'] = 'danger';

    echo "Error: NIT no proporcionado para la eliminación.";
}