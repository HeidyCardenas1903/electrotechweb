<?php include '../../../controller/MostrarDatosPerfil.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroTech | Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/icono.ico" />
    <link rel="stylesheet" href="../../../public/css/editarperfil.css">
</head>

<body>
    <nav class="sidebar close">
        <header>
            <i class="fa-solid fa-bars toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="../homeadmin.php">
                            <i class="fa-solid fa-house"></i>
                            <span class="text nav-text">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../inventario/inventarioadmin.php">
                            <i class="fa-solid fa-box-open"></i>
                            <span class="text nav-text">Inventario</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../gestionar/gestionarusuarios.php">
                            <i class="fa-solid fa-user-gear"></i>
                            <span class="text nav-text">Gestionar</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../ventas/ventasadmin.php">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span class="text nav-text">Facturacion</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../ventas/facturasadmin.php">
                            <i class="fa-solid fa-receipt"></i>
                            <span class="text nav-text">Facturas</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="nav-link user-info">
                    <i class="fa-solid fa-user"></i>
                    <span class="text nav-text">Administrador(a)</span>
                </li>
                <li class="nav-link">
                    <a href="../configuracion/perfil.php">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text nav-text">Configuracion</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="../../../controller/logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="text nav-text">Cerrar sesión</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <section class="home">
        <div class="container head">
            <img id="logo" src="../../../public/img/logo2.svg" alt="logo">
        </div>
        <h2><strong><i class="fa-regular fa-id-card"></i> Perfil de usuario</strong></h2>
        <div class="container datos">
            <?php
            if (isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                echo $_SESSION['success_message'];
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
                unset($_SESSION['success_message']);
            }

            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo $_SESSION['error_message'];
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
                unset($_SESSION['error_message']);
            }
            ?>
            <?php include '../../../controller/ocultarcontra.php' ?>
            <?php include 'editarPerfilModal.php'; ?>

            <p><strong>Nombre:</strong> <?php echo $usuarioData['nombre']; ?></p>
            <p><strong>Nombre de usuario:</strong> <?php echo $usuarioData['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $usuarioData['email']; ?></p>
            <p><strong>Contraseña:</strong> <?php echo hidePassword($usuarioData['password']); ?></p>

            <button id="editarPerfilBtn" class="linkicono" data-bs-toggle="modal" data-bs-target="#editarPerfilModal"><i class="fa-solid fa-pen-to-square"></i> Editar perfil</button>
        </div>
    </section>



    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../../public/js/menulateral.js"></script>
    <script src="../../../public/js/ocultarcontra.js"></script>
</body>

</html>