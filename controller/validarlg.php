<?php
include "../model/conexion.php";

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];
session_start();

$consulta = "SELECT * FROM usuarios WHERE username='$usuario'";
$resultado = $conexion->query($consulta);

if ($resultado) {
    $filas = $resultado->fetch_assoc();

    if ($filas) {
        if (password_verify($contraseña, $filas['password'])) {
            $_SESSION['usuario'] = $usuario;

            if ($filas['id_rol'] == 1) { 
                header("Location: ../view/admin/homeadmin.php");
                exit();
            } elseif ($filas['id_rol'] == 2) { 
                header("Location: ../view/vendedor/homeven.php");
                exit();
            } else {
                $_SESSION['error_message'] = 'Personal no autorizado';
                header("Location: ../view/login.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Contraseña incorrecta, intente nuevamente';
            header("Location: ../view/login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Usuario no encontrado';
        header("Location: ../view/login.php");
        exit();
    }

    $resultado->free_result();
} else {
    $_SESSION['error_message'] = 'Error en la consulta: ' . $conexion->error;
    header("Location: ../view/login.php");
    exit();
}
?>
