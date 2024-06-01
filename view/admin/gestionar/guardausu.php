<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../PHPmailer/Exception.php';
require '../../../PHPmailer/PHPMailer.php';
require '../../../PHPmailer/SMTP.php';

require '../../../model/conexion.php';

session_start(); // Iniciar sesión para gestionar mensajes

$nombre = $conexion->real_escape_string($_POST['nombre']);
$username = $conexion->real_escape_string($_POST['username']);
$password = $_POST['password'];
$passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);
$email = $conexion->real_escape_string($_POST['email']);
$rol = $conexion->real_escape_string($_POST['rol']);

$sql = "INSERT INTO usuarios (nombre, username, password, email, id_rol) VALUES ('$nombre', '$username', '$passwordEncriptada','$email', $rol)";

if ($conexion->query($sql)) {
    // Envío de correo
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'soporte.electrotechdh@gmail.com';
        $mail->Password = 'kjdt evxm ovpo pgnu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('soporte.electrotechdh@gmail.com', 'ElectroTech');
        $mail->addAddress($email, $nombre);
        $mail->isHTML(true); 
        $mail->Subject = '¡Bienvenidx a ElectroTech!';
        $mail->Body = '<!DOCTYPE html>
                    <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <style>
                            @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap");
                            body {
                                line-height: 1.6;
                                margin: 0;
                                padding: 0;
                                background-color: #fAfAfA;
                            }
                            .container {
                                max-width: 600px;
                                margin: 20px auto;
                                padding: 20px;
                                background: #FAFAFA;
                                border-radius: 5px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            }
                            img {
                                display: block;
                                margin: 0 auto;
                                width: 30%;
                            }
                            h1 {
                                text-align: center;
                                font-family: "Roboto";
                                font-weight: bold;
                                color: #014972;
                            }
                            p {
                                font-family: "Roboto";
                                margin-bottom: 2%;
                            }
                            .highlight {
                            background-color: #014972;
                            text-align: center;
                            color: #fafafa;
                            padding: 2%;
                            border-radius: 5px;
                            }
                            .derechos {
                            min-width: 90%;
                            background: #014972;
                            padding: 5%;
                            border-radius: 5px;
                            color: #FAFAFA;
                            font-size: x-small;
                            }
                            p.copy {
                            text-align: center;
                            font-weight: 500;
                            }
                        </style>
                        </head>
                        <body>
                            <div class="container">
                                <img src="https://i.ibb.co/42pW0xD/Logo.png" alt="Logo de la empresa">
                                <h1>Hola ' . $nombre . ',<br>¡Bienvenido/a a ElectroTech! </h1>
                                <p>¡Es un placer darte la bienvenida a ElectroTech! En nombre de
                                    todo el equipo, queremos expresar nuestro entusiasmo por tenerte
                                    con nosotros y estamos emocionados de que te unas a nuestro
                                    equipo.</p>
                                <p>Tu rol en ElectroTech es fundamental para nuestro éxito, y
                                    confiamos en que tu experiencia, habilidades y dedicación
                                    contribuirán significativamente a nuestros objetivos
                                    compartidos.</p>
                                <br>
                                <p>A continuación, encontrarás tus credenciales de inicio de sesión
                                    para acceder a nuestros sistemas internos:</p>
                                <div class="highlight">
                                    <p><strong>Usuario:</strong> ' . $username . '</p>
                                    <p><strong>Contraseña:</strong> ' . $password . '</p>
                                </div>
                                <p>Por favor, sigue estos pasos para comenzar:</p>
                                <ol>
                                    <li>Utiliza las credenciales proporcionadas para iniciar sesión
                                        en nuestra red interna</li>
                                    <li>Una vez que hayas iniciado sesión, te recomendamos que
                                        cambies tu contraseña temporal por una nueva más segura</li>
                                    <li>Explora nuestros sistemas y familiarízate con nuestras
                                        herramientas y políticas internas</li>
                                </ol>
                                <p>¡Bienvenido/a a la familia ElectroTech! Estamos
                                    emocionados de trabajar juntos y esperamos verte prosperar en
                                    nuestra organización.</p>
                                <p><center>¡Esperamos verte pronto!</center></p>
                                <div class="derechos">
                                    Este mensaje y sus archivos adjuntos son confidenciales y están
                                    dirigidos únicamente al destinatario especificado. Si usted ha
                                    recibido este mensaje por error, por favor notifique al remitente y
                                    elimine este mensaje de inmediato. Cualquier divulgación,
                                    distribución o reproducción de este mensaje por parte de cualquier
                                    persona que NO sea el destinatario designado está estrictamente
                                    prohibida.
                                    <p class="copy">Copyright ©2024 ElectroTech. Todos los derechos
                                        reservados</p>
                                </div>
                            </div>
                            
                        </body>
                    </html>';
        // Envío del correo
        $mail->send();

        $_SESSION['msg'] = 'Usuario registrado exitosamente';
        $_SESSION['color'] = 'success';

        header("Location: gestionarusuarios.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['msg'] = 'Error al enviar el correo: ' . $mail->ErrorInfo;
        $_SESSION['color'] = 'danger';
    }
} else {
    $_SESSION['msg'] = 'Error al insertar en la base de datos: ' . $conexion->error;
    $_SESSION['color'] = 'danger';
}

