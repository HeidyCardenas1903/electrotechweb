<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$base_path = dirname(__FILE__);


require $base_path . '/../PHPMailer/Exception.php';
require $base_path . '/../PHPMailer/PHPMailer.php';
require $base_path . '/../PHPMailer/SMTP.php';


if (!empty($_POST["btnRegistrarcli"])) {
    $nit = $_POST['nit_cliente'];
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];


    if (!empty($nit) and !empty($nombre) and !empty($apellido) and !empty($email) and !empty($telefono)) {
        $sql = $conexion->query("INSERT INTO clientes (id, nombre, apellido, email, telefono, id_rol) VALUES ('$nit','$nombre', '$apellido', '$email', '$telefono', 3)");

        if ($sql === true) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'soporte.electrotechdh@gmail.com';
                $mail->Password = 'kjdt evxm ovpo pgnu';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
    
                $mail->setFrom('soporte.electrotechdh@gmail.com', 'Electrotech');
                $mail->addAddress($email, $nombre);
                
                $mail->Subject = 'Gracias por registrarte!';
                $mail->isHTML(true);
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
                
                        img#logo {
                            display: block;
                            margin: 0 auto;
                            width: 30%;
                        }
                
                        img#promo {
                            display: block;
                            margin: 0 auto;
                            width: 100%;
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
                
                        .derechos {
                            min-width: 90%;
                            margin-top: 5%;
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
                        <img src="https://i.ibb.co/42pW0xD/Logo.png" alt="Logo de la empresa" id="logo">
                        <h1>Hola ' . $nombre . ',<br></h1>
                        <p>En nombre de todo el equipo de ElectroTech, queremos darte una calurosa bienvenida. Estamos muy contentos de
                            que hayas decidido formar parte de nuestra comunidad.</p>
                        <br>
                        <img src="https://i.ibb.co/2PVfMrf/Img-correo.png" alt="Img-correo" border="0" id="promo">
                        <div class="derechos">
                            Este mensaje y sus archivos adjuntos son confidenciales y están
                            dirigidos únicamente al destinatario especificado. Si usted ha
                            recibido este mensaje por error, por favor notifique al remitente y
                            elimine este mensaje de inmediato. Cualquier divulgación,
                            distribución o reproducción de este mensaje por parte de cualquier
                            persona que NO sea el destinatario designado está estrictamente
                            prohibida.
                            <p class="copy">Copyright ©2024 ElectroTech. Todos los derechos
                                reservados
                            </p>
                        </div>
                    </div>
                
                </body>
                
                </html>';

                // Enviar el correo electrónico
                $mail->send();

                echo '<div class="alert alert-success">Te has registrado exitosamente</div>';
            } catch (Exception $e) {
                echo '<div class="alert alert-danger">UPS! No se ha podido realizar el registro, intenta más tarde.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">UPS! No se ha podido realizar el registro, intenta más tarde.</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Alguno de los campos no ha sido diligenciado</div>';
    }
}

