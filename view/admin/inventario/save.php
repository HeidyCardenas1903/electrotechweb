<?php

session_start();

require '../../../model/conexion.php';

$nombre = $conexion->real_escape_string($_POST['nombre']);
$descripcion = $conexion->real_escape_string($_POST['descripcion']);
$precio = $conexion->real_escape_string($_POST['precio']);
$proveedor = $conexion->real_escape_string($_POST['proveedor']);
$stock = $conexion->real_escape_string($_POST['stock']);

$sql = "INSERT INTO productos (precio, stock, id_proveedor, nombre, descripcion)
VALUES ('$precio', '$stock', '$proveedor', '$nombre', '$descripcion')";

if ($conexion->query($sql)) {
    $id = $conexion->insert_id;

    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Producto registrado exitosamente";

    if ($_FILES['img']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("image/jpg", "image/jpeg", "image/png");
        if (in_array($_FILES['img']['type'], $permitidos)) {

            $dir = "imgs";

            $info_img = pathinfo($_FILES['img']['name']);
            $info_img['extension'];

            $img = $dir . '/' . $id . '.jpg';

            if (!file_exists($dir)) {
                mkdir($dir, 0777);
            }

            if (!move_uploaded_file($_FILES['img']['tmp_name'], $img)) {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Error al guardar imagen";
            }
        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] .= "<br>Formato de imagen no permitido";
        }
    }
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al guardar la imagen";
}
echo '<script>window.location.href = "inventarioadmin.php";</script>';
exit();