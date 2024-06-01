<!-- NO BORRAR - IMPOTANTE!!!!! es lo que protege las vistas -->
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /Electrotech/view/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroTech | Home</title>

    <!-- Enlaces a recursos externos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../public/img/icono.ico" />
    <link rel="stylesheet" href="../../public/css/homeven.css">
</head>

<body>

    <!-- Barra de navegación lateral -->
    <nav class="sidebar close">
        <header>
            <i class="fa-solid fa-bars toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="homeven.php">
                            <i class="fa-solid fa-house"></i>
                            <span class="text nav-text">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="inventario/inventarioven.php">
                            <i class="fa-solid fa-box-open"></i>
                            <span class="text nav-text">Inventario</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="ventas/ventasven.php">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span class="text nav-text">Facturacion</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="ventas/facturasven.php">
                            <i class="fa-solid fa-receipt"></i>
                            <span class="text nav-text">Facturas</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="nav-link user-info">
                    <i class="fa-solid fa-user"></i>
                    <span class="text nav-text">Vendedor(a)</span>
                </li>
                <li class="nav-link">
                    <a href="../vendedor/configuracion/perfil.php">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text nav-text">Configuracion</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="../../controller/logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="text nav-text">Cerrar sesión</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <section class="home">
        <div class="container">
            <div class="header">
                <!-- Encabezado con saludo al usuario -->
                <div class="col-md-10">
                    <h2 id="titulo">¡Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h2>
                    <p>Es un placer tenerte aquí.</p>
                </div>
                <div class="col-md-2">
                    <img src="../../public/img/logo2.svg" alt="Logo">
                </div>
            </div>
            <div class="row body">
                <?php
                include '../../model/conexion.php';
                include '../../controller/informacionController.php';
                ?>
                <!-- Paneles informativos -->
                <h3 class="subtitulo"><i class="fa-solid fa-thumbtack"></i> Resumen de ventas</h3>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="icono"><i class="fa-solid fa-shopping-bag"></i></div>
                        <div class="textos">
                            <h2 class="subtitulo"><?php echo $total_ventas_mes; ?></h2>
                            <p>Ventas realizadas este mes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="icono"><i class="fa-solid fa-store"></i></div>
                        <div class="textos">
                            <h2><?php echo $total_productos; ?></h2>
                            <p>Productos disponibles en stock</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="icono"><i class="fa-solid fa-money-check-dollar"></i></div>
                        <div class="textos">
                            <h2><?php echo $total_productos_vendidos_mes; ?></h2>
                            <p>Total de productos vendidos</p>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row body2">
                <div class="col-md-8">
                    <h3 class="subtitulo"><i class="fa-solid fa-chart-line"></i> Estadísticas de ventas</h3>
                    <?php include "../../controller/consultaGraficos.php" ?>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <canvas id="graficoVentas" max-width="100%" max-height="100%"></canvas>

                    <script>
                        // Convertir el JSON de PHP a un array de JavaScript
                        const ventasPorMes = <?php echo $ventas_por_mes_json; ?>;

                        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

                        const ctx = document.getElementById('graficoVentas').getContext('2d');

                        const graficoVentas = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: meses,
                                datasets: [{
                                    label: 'Ventas por mes',
                                    data: ventasPorMes,
                                    backgroundColor: 'rgb(104, 157, 238, 0.2)',
                                    borderColor: 'rgb(1,73,114, 1)',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                    <div class="sop">
                        <h3 class="subtitulo"><i class="fa-regular fa-calendar"></i> <span id="fecha"></span> </h3>
                        <p><strong>Contacto de Soporte:</strong> soporte.vendedor@gmail.com</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3 class="subtitulo"><i class="fa-solid fa-bell"></i> Notificaciones de stock</h3>
                    <div class="notifications">
                        <ul>
                            <?php
                            $query_agotados = "SELECT * FROM productos WHERE stock = 0";
                            $resultado_agotados = $conexion->query($query_agotados);

                            if ($resultado_agotados->num_rows > 0) {
                                while ($fila_agotados = $resultado_agotados->fetch_assoc()) {
                                    echo "<li id='agotado'><i class='fa-solid fa-triangle-exclamation'></i> {$fila_agotados['nombre']} está agotado en stock.</li>";
                                }
                            } else {
                                echo "<li id='nice'><i class='fa-solid fa-check'></i> No hay productos agotados en stock.</li>";
                            }

                            $query_casi_agotados = "SELECT * FROM productos WHERE stock > 0 AND stock < 3";
                            $resultado_casi_agotados = $conexion->query($query_casi_agotados);

                            if ($resultado_casi_agotados->num_rows > 0) {
                                while ($fila_casi_agotados = $resultado_casi_agotados->fetch_assoc()) {
                                    echo "<li id='cuidado'><i class='fa-solid fa-land-mine-on'></i> {$fila_casi_agotados['nombre']} está a punto de agotarse.</li>";
                                }
                            }
                            ?>

                        </ul>
                    </div>
                    <div class="top 1">
                        <div class="container">
                            <div class="producto-mas-vendido">
                                <h3 class="subtitulo"><i class="fa-solid fa-money-bill-1-wave"></i> Producto más vendido del mes</h3>

                                <?php include "../../controller/consultaProducto.php"; ?>
                                <div class="info">
                                    <?php if ($cantidad_vendida > 0) : ?>
                                        <img src="../../public/img/TOP.png" alt="Producto más vendido" style="max-width: 60%;" class="TOP">
                                        <p><strong>Nombre:</strong> <?php echo $nombre_producto; ?></p>
                                        <p><strong>Cantidad vendida:</strong> <?php echo $cantidad_vendida; ?></p>
                                        <p><strong>Precio:</strong> $<?php echo number_format($precio_producto, 2); ?></p>
                                    <?php else : ?>
                                        <p>No se encontraron datos del producto más vendido este mes.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts al final del cuerpo del documento -->
    <script>
        // Obtener la fecha actual
        const fechaActual = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const fechaFormateada = fechaActual.toLocaleDateString('es-ES', options);

        // Mostrar la fecha actual en el elemento span
        document.getElementById('fecha').textContent = fechaFormateada;
    </script>
    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../../public/js/menulateral.js"></script>
</body>

</html>