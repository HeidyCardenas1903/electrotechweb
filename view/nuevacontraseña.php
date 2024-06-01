<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="shortcut icon" href="../public/img/icono.ico" />
    <link rel="stylesheet" href="../public/css/contraseña2.css">
</head>

<body>
    <div class="container">
        <img src="../public/img/Logo.png" alt="Logo de la empresa">
        <h2 class="mb-4">Restablecer Contraseña</h2>
        <?php
        if (isset($mensaje)) {
            if ($mensaje['tipo'] == 'exito') {
                echo '<div class="alert alert-success">' . $mensaje['texto'] . '</div>';
            } elseif ($mensaje['tipo'] == 'error') {
                echo '<div class="alert alert-danger">' . $mensaje['texto'] . '</div>';
            }
        }
        ?>
        <form action="../controller/restablecer_contraseña.php" method="post">
            <div class="mb-3">
                <label for="codigo" class="form-label">Código de Recuperación:</label>
                <input type="text" class="form-control" id="codigo" name="codigo" required>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Contraseña:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <div class="form-text">
                    Ingresa una contraseña de al menos 8 caracteres.
                </div>
            </div>
            <button type="submit" class="btn btn-primary save" name="submit"><i class="fa-regular fa-floppy-disk"></i> Guardar cambios</button>
        </form>


    </div>
    
    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>