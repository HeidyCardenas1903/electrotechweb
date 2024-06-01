<?php

session_start();

require '../../../model/conexion.php';

if (isset($_POST['id'])) {
    $id = $conexion->real_escape_string($_POST['id']);
    $sql = "DELETE FROM productos WHERE id=$id";

    if ($conexion->query($sql)) {

        $dir = "imgs";

        $img = $dir . '/' . $id . '.jpg';
        
        if (file_exists($img)) {
            unlink($img);
        }

        $_SESSION['color'] = "success";
        $_SESSION['msg'] = "Producto eliminado exitosamente";

    }else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "Error al Eliminar Registro";
    }
}

header('Location: inventarioadmin.php');