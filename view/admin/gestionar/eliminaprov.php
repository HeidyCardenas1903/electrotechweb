<?php

require '../../../model/conexion.php';

session_start();

if (isset($_POST['nit'])) {
    $nit = $conexion->real_escape_string($_POST['nit']);
    $sql = "DELETE FROM proveedores WHERE nit='$nit'";

    if ($conexion->query($sql)) {
        $_SESSION['msg'] = 'El proveedor se ha eliminado correctamente.';
        $_SESSION['color'] = 'success';

        header("Location: gestionarusuarios.php");
        exit();
    } else {
        $_SESSION['msg'] = 'Error al eliminar en la base de datos: ' . $conexion->error;
        $_SESSION['color'] = 'danger';

        echo "Error al eliminar en la base de datos: " . $conexion->error;
    }
} else {
    $_SESSION['msg'] = 'Error: NIT no proporcionado para la eliminación.';
    $_SESSION['color'] = 'danger';

    echo "Error: NIT no proporcionado para la eliminación.";
}
