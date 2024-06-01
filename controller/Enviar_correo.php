<?php
require '../model/conexion.php';
require '../PHPmailer/Exception.php';
require '../PHPmailer/PHPMailer.php';
require '../PHPmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_email"])) {
    $email = $_POST["email"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El correo electrónico proporcionado no es válido.";
        exit();
    }

    $codigo = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

    $sql = "UPDATE usuarios SET codigo_recuperacion = ? WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $codigo, $email);

    if ($stmt->execute()) {

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
            $mail->addAddress($email);

            $mail->Subject = utf8_decode('Recuperación de contraseña');
            $mail->isHTML(true);
            $mail->Body = 'Tu código de recuperación de contraseña es: ' . $codigo;

            $mail->send();
            header("Location: mensaje_enviado.php");
            exit();
        } catch (Exception $e) {
            echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al generar el código de recuperación: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
