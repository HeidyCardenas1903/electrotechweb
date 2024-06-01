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
    <title>Electrotech | Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/icono.ico" />
    <link rel="stylesheet" href="../../../public/css/inventario.css">
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
    </nav>

    <section class="home">
        <section id="busqueda">
            <div>
            <h3 class="text-center mt-4"><i class="fa-solid fa-boxes-stacked"></i> Gestionar Inventario</h3>
            </div>
            
            <div id="imglog">
                <img id="logo" src="../../../public/img/logo2.svg" alt="Logo">
            </div>
            
        </section>
        <section id="busq_btn" >
            <div id="busq">
                <label><i class="fa-solid fa-magnifying-glass lupa"></i></label>
                <input id="campobus" type="text" placeholder="Buscar">
            </div>
            <a href="Generar_pdfInventario.php" target="_blank" id="genPDF"><i class="fa-solid fa-file-pdf"></i> Generar PDF</a>
        </section>
        <section>
            <?php
            if (isset($_SESSION['msg']) && isset($_SESSION['color']) ) { ?>

                <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['msg']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php 
                unset($_SESSION['color']);
                unset($_SESSION['msg']);
            }  ?>

            <?php
            require '../../../model/conexion.php';

            // Paginador
            $sql_registe = mysqli_query($conexion, "SELECT COUNT(*) as total_registro FROM productos");
            $result_register = mysqli_fetch_array($sql_registe);
            $total_registro = $result_register['total_registro'];

            $por_pagina = 8;

            if (empty($_GET['pagina'])) {
                $pagina = 1;
            } else {
                $pagina = $_GET['pagina'];
            }

            $desde = ($pagina - 1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);


            $sqlProductos = "SELECT p.id, p.nombre, p.img, p.descripcion, p.precio, pr.razonsocial AS proveedor, p.stock FROM productos AS p INNER JOIN proveedores AS pr ON p.id_proveedor = pr.nit LIMIT $desde,$por_pagina";
            $productos = $conexion->query($sqlProductos);
            ?>
            <table id="inventario">
                <thead>
                    <tr>
                        <th class="first">ID</th>
                        <th  id='nombre'>Nombre</th>
                        <th id='img'>Imagen</th>
                        <th id='desc'>Descripción</th>
                        <th id='precio'>Precio</th>
                        <th id='proveedor'>Proveedor</th>
                        <th id='stock' class="last">Stock</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row_productos = $productos->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='first'>" . $row_productos['id'] . "</td>";
                        echo "<td>" . $row_productos['nombre'] . "</td>";
                        ?>
                        <td id="img"><img src="<?= $dir . $row_productos['id'] . '.jpg?n='.time( ); ?>" width="25%" style="padding: 2px;"></td>
                        <?php 
                        echo "<td class='descripcion-corta'>" . $row_productos['descripcion'] . "</td>";
                        echo "<td>$" . $row_productos['precio'] . "</td>";
                        echo "<td>" . $row_productos['proveedor'] . "</td>";
                        echo "<td class='last'>" . $row_productos['stock'] . "</td>";
                    ?>
                    <?php echo "</tr>";
                    }
                    ?>
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
        <div id="btns">
            <a href="#" id="addprod" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Agregar Producto</a>
        </div>
    </section>

    <!-- Consulta SQL -->
    <?php
    $sql_proveedores = "SELECT nit, razonsocial FROM proveedores";
    $proveedores = $conexion->query($sql_proveedores);

    ?>

    <!-- Integración Modales -->

    <?php $proveedores->data_seek(0); ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const campoBusqueda = document.getElementById("campobus");
            const tabla = document.getElementById("inventario").getElementsByTagName("tbody")[0];
            const filas = tabla.getElementsByTagName("tr");

            campoBusqueda.addEventListener("keyup", function() {
                const textoBusqueda = campoBusqueda.value.toLowerCase();
                
                for (let i = 0; i < filas.length; i++) {
                    const datosFila = filas[i].getElementsByTagName("td");
                    let coincide = false;
                    
                    for (let j = 0; j < datosFila.length; j++) {
                        if (datosFila[j].textContent.toLowerCase().includes(textoBusqueda)) {
                            coincide = true;
                            break;
                        }
                    }

                    if (coincide) {
                        filas[i].style.display = "";
                    } else {
                        filas[i].style.display = "none";
                    }
                }
            });
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="../../../public/js/menulateral.js"></script>

</body>

</html>