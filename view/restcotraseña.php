<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restauración de contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../public/img/icono.ico" />
    <link rel="stylesheet" href="../public/css/contraseñarec.css">
</head>

<body>
    <div class="container">
        <img src="../public/img/Logo.png" alt="Logo de la empresa">
        <h3>Te enviaremos un enlace para restablecer tu contraseña</h3>
        <?php
        if (isset($mensaje)) {
            if ($mensaje['tipo'] == 'exito') {
                echo '<div class="alert alert-success">' . $mensaje['texto'] . '</div>';
            } elseif ($mensaje['tipo'] == 'error') {
                echo '<div class="alert alert-danger">' . $mensaje['texto'] . '</div>';
            }
        }
        ?>
        <form action="../controller/Enviar_correo.php" method="post">
            <label for="email"><i class="fa-solid fa-at at"></i></label>
            <input type="email" id="email" name="email" placeholder="Digite su correo electronico" required>
            <br>
            <button type="submit" name="submit_email"><i class="fa-solid fa-paper-plane"></i> Enviar</button>
        </form>
    </div>
    <a href="../index.php"><i class="fa-solid fa-house"></i> Volver al inicio </a>

    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>

</html>
