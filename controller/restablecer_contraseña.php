<?php
require '../model/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Buscar al usuario por su nombre de usuario en la base de datos
    $sql_select_usuario = "SELECT id FROM usuarios WHERE username = ?";
    $stmt_select_usuario = $conexion->prepare($sql_select_usuario);
    
    if ($stmt_select_usuario) {
        $stmt_select_usuario->bind_param("s", $usuario);
        $stmt_select_usuario->execute();
        $stmt_select_usuario->store_result();
        
        if ($stmt_select_usuario->num_rows == 1) {
            $stmt_select_usuario->bind_result($usuario_id);
            $stmt_select_usuario->fetch();

            // Verificar si las contraseñas coinciden y tienen la longitud adecuada
            if ($password == $confirm_password && strlen($password) >= 8) {
                // Encriptar la nueva contraseña
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Actualizar la contraseña del usuario en la base de datos
                $sql_update_password = "UPDATE usuarios SET password = ? WHERE id = ?";
                $stmt_update_password = $conexion->prepare($sql_update_password);

                if ($stmt_update_password) {
                    $stmt_update_password->bind_param("si", $hashed_password, $usuario_id);
                    
                    if ($stmt_update_password->execute()) {
                        // Contraseña actualizada correctamente, redireccionar y mostrar mensaje de éxito
                        session_start();
                        $_SESSION['exito_message'] = '¡Contraseña actualizada correctamente!';
                        $stmt_update_password->close();
                        $conexion->close();
                        header("Location: ../view/login.php");
                        exit;
                    } else {
                        $mensaje = array(
                            'tipo' => 'error',
                            'texto' => 'Error al actualizar la contraseña en la base de datos: ' . $stmt_update_password->error
                        );
                    }
                } else {
                    $mensaje = array(
                        'tipo' => 'error',
                        'texto' => 'Error en la preparación de la consulta: ' . $conexion->error
                    );
                }
            } else {
                $mensaje = array(
                    'tipo' => 'error',
                    'texto' => 'Las contraseñas no coinciden o no tienen la longitud adecuada.'
                );
            }
        } else {
            $mensaje = array(
                'tipo' => 'error',
                'texto' => 'El nombre de usuario no existe.'
            );
        }
        
        $stmt_select_usuario->close();
    } else {
        $mensaje = array(
            'tipo' => 'error',
            'texto' => 'Error en la preparación de la consulta: ' . $conexion->error
        );
    }

    $conexion->close();
}
?>


