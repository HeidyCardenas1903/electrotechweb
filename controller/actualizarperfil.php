<?php
session_start();
include "../model/conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../view/login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

$consulta = "SELECT * FROM usuarios WHERE username='$usuario'";
$resultado = $conexion->query($consulta);

if ($resultado && $resultado->num_rows > 0) {
    $usuarioData = $resultado->fetch_assoc();
} else {
    $_SESSION['error_message'] = 'No se encontraron los datos del usuario';
    header("Location: ../../../view/login.php");
    exit();
}

$_SESSION['url_anterior'] = $_SERVER['HTTP_REFERER'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET nombre=?, username=?, email=?, password=? WHERE id=?";
    
    $stmt = $conexion->prepare($sql);
    
    $stmt->bind_param("ssssi", $nombre, $username, $email, $hashed_password, $usuarioData['id']);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Datos actualizados correctamente!';
        $usuarioData['nombre'] = $nombre;
        $usuarioData['username'] = $username;
        $usuarioData['email'] = $email;
    } else {
        $_SESSION['error_message'] = 'Error al actualizar ' . $conexion->error;
    }
    
    $stmt->close();
}

$resultado->free_result();
$conexion->close();

if (isset($_SESSION['url_anterior'])) {
    header("Location: " . $_SESSION['url_anterior']);
} else {
    header("Location: ../../../view/perfil.php"); 
}
exit();
?>

