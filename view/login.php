<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroTech | Inicio de sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../public/img/icono.ico" />
    <link rel="stylesheet" href="../public/css/login.css">
</head>

<body>
    <section>
        <div class="col-md-6 left">
            <img src="../public/img/Logo.png" alt="Logo" id="logo" width="200px">
            <h1>¡Bienvenido de nuevo!</h1>
            <div class="error align-center" style="width: auto;">
                <?php
                session_start();

                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }
                if (isset($_SESSION['exito_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['exito_message'] . '</div>';
                    unset($_SESSION['exito_message']); 
                }                
                ?>
            </div>
            <form action="../controller/validarlg.php" method="POST">
                <div class="row user">
                    <div class="col-md-2">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-input" id="username" name="usuario" placeholder="Digite su usuario" required>
                    </div>
                </div>
                <div class="row pass">
                    <div class="col-md-2">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="col-md-10">
                        <div class="input-group">
                        <input type="password" class="form-control form-input" id="password" name="contraseña" placeholder="Digite su contraseña" required>
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="showPasswordIcon" onclick="showHidePassword()"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <p class="olvcontra">¿Haz olvidado tu contraseña? <a href="../view/restcotraseña.php"> Haz click aquí</a></p>
                </div>
                <button type="submit"><i class="fa-solid fa-arrow-right-to-bracket"></i> Ingresar</button>
            </form>
            <a href="../index.php" class="init"><i class="fa-solid fa-house"></i> Volver al inicio </a>
        </div>
        <div class="col-md-6 rigth">
            <p class="saludo">¡ H O L A !</p>
            <img src="../public/img/login img.png" alt="Welcomeimg" width="600px">
        </div>
    </section>


    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        function showHidePassword() {
            var passwordInput = document.getElementById("password");
            var showPasswordIcon = document.getElementById("showPasswordIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPasswordIcon.classList.remove("fa-eye");
                showPasswordIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                showPasswordIcon.classList.remove("fa-eye-slash");
                showPasswordIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>