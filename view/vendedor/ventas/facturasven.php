<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /Electrotech/view/login.php");
    exit();
}

$dir = "imgs/"

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electrotech | Facturas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/icono.ico" />
    <link rel="stylesheet" href="../../../public/css/facturacion.css">
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
                        <a href="../homeven.php">
                            <i class="fa-solid fa-house"></i>
                            <span class="text nav-text">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../inventario/inventarioven.php">
                            <i class="fa-solid fa-box-open"></i>
                            <span class="text nav-text">Inventario</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../ventas/ventasven.php">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span class="text nav-text">Facturacion</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../ventas/facturasven.php">
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
                    <a href="../configuracion/perfil.php">
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
        </div>
    </nav>
    <section class="home">
    <section id="encabezado">
            <h3 class="text-center mt-4"><i class="fa-solid fa-receipt"></i> Gestionar Facturas</h3>
            <img id="logo" src="../../../public/img/logo2.svg" alt="Logo">
        </section>
        <section id="busqueda">
            <form action="buscar_ventaven.php" method="get" class="form_search">
                <input id="busqueda" name="busqueda" type="text" placeholder="No. Factura">
                <button type="submit" class="btn_search"><i class="fa-solid fa-magnifying-glass lupa"></i></button>
            </form>
            <div class="fechsearch">
                <h5>Buscar por Fecha</h5>
                <form action="buscar_ventaven.php" method="get" class="form_search_date">
                    <label>Desde:</label>
                    <input type="date" name="fecha_de" id="fecha_de" required>
                    <label>Hasta:</label>
                    <input type="date" name="fecha_a" id="fecha_a" require>
                    <button type="submit" class="btn_view"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <a href="ventasadmin.php" class="btn_nueva"><i class="fa-solid fa-plus"></i>Nueva Venta</a>
        </section>
        <section>
            <?php
            require '../../../model/conexion.php';
            $sqlProductos = "SELECT p.id, p.nombre, p.img, p.descripcion, p.precio, pr.razonsocial AS proveedor, p.stock FROM productos AS p INNER JOIN proveedores AS pr ON p.id_proveedor = pr.nit";
            $productos = $conexion->query($sqlProductos);
            ?>
            <table id="inventario">
                <thead>
                    <tr>
                        <th class="first">No.</th>
                        <th>Fecha / Hora</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Estado</th>
                        <th>Total Factura</th>
                        <th class="last">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_registe = mysqli_query($conexion, "SELECT COUNT(*) as total_registro FROM facturas");
                    $result_register = mysqli_fetch_array($sql_registe);
                    $total_registro = $result_register['total_registro'];

                    $por_pagina = 6;    

                    if (empty($_GET['pagina'])) {
                        $pagina = 1;
                    } else {
                        $pagina = $_GET['pagina'];
                    }

                    $desde = ($pagina - 1) * $por_pagina;
                    $total_paginas = ceil($total_registro / $por_pagina);

                    $query = mysqli_query($conexion, "SELECT f.id, f.fecha, f.totalfactura, f.id_cliente, f.estatus, u.nombre as vendedor, cl.nombre as cliente, cl.apellido FROM facturas f INNER JOIN usuarios u on f.id_usuario = u.id INNER JOIN clientes cl on f.id_cliente = cl.id WHERE f.estatus != 10 ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");

                    mysqli_close($conexion);

                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {
                            if ($data["estatus"] == 1) {
                                $estado = '<span class="pagada">Pagada</span>';
                            } else {
                                $estado = '<span class="anulada">Anulada</span>';
                            }
                    ?>
                            <tr id="row_<?php echo $data["id"]; ?>">
                                <td class="first"><?php echo $data["id"]; ?></td>
                                <td><?php echo $data["fecha"]; ?></td>
                                <td><?php echo $data["cliente"] . ' ' . $data["apellido"]; ?></td>
                                <td><?php echo $data["vendedor"]; ?></td>
                                <td><?php echo $estado; ?></td>
                                <td><span>$</span><?php echo $data["totalfactura"]; ?></td>
                                <td class='last iconos'>
                                    <a class="btn_view view_factura" cl="<?php echo $data["id_cliente"] ?>" f="<?php echo $data["id"] ?>"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
            <div class="paginador">
                <ul>
                    <?php
                    if ($pagina != 1){  
                    
                    ?> 
                        <li class="pag"><a href="?pagina=<?php echo 1; ?>" class="pag"><i class="fas fa-step-backward"></i></a></li>
                        <li class="pag"><a href="?pagina=<?php echo $pagina - 1; ?>" class="pag"><i class="fas fa-backward"></i></a></li>

                    <?php 
                        } 
                        for ($i = 1; $i <= $total_paginas; $i++){

                            if($i == $pagina){
                                echo '<li class="pageSelected">'.$i.'</li>';
                            }else{
                                echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                            }

                        }   

                        if($pagina != $total_paginas)
                        {
                    ?>
                        <li><a href="?pagina=<?php echo $pagina + 1; ?>"><i class="fas fa-forward"></i></a></li>
                        <li><a href="?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-step-forward"></i></a></li>
                    <?php } ?>

                </ul>
            </div>

        </section>
    </section>

    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../../../public/js/menulateral.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>    
        $(document).ready(function() {
            $('.view_factura').click(function(e){
                e.preventDefault();
                var codCliente = $(this).attr('cl');
                var noFactura = $(this).attr('f');

                generarPDF(codCliente,noFactura);
            });

        });

        function generarPDF(cliente,factura){
            var width = 1000;
            var height = 1000;

            var x = parseInt((window.screen.width/2) - (width/2));
            var y = parseInt((window.screen.height/2) - (height/2));

            $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
            window.open($url,"Factura","left="+x+",top="+y+",height="+height+",width"+width+",scrollbar=si,location=no,resizable=si,menubar=no");
            }

    </script>
    
    <script src="../../../public/js/menulateral.js"></script>

</body>

</html>