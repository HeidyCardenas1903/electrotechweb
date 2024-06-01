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
    <title>ElectroTech | Gestionar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/icono.ico" />
    <link rel="stylesheet" href="../../../public/css/gestionar.css">
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
        <div class="container">

            <div class="row">
                <div class="row header">
                    <?php if (isset($msg) && isset($color)): ?>
                        <div class="alert alert-<?php echo $color; ?> alert-dismissible fade show" role="alert">
                            <?php echo $msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-9">
                        <h3><i class="fa-solid fa-users"></i> Gestionar Usuarios</h3>
                    </div>
                    <div class="col-md-3">
                        <div id="imglog" class="text-md-end">
                            <img id="logo" src="../../../public/img/logo2.svg" alt="logo">
                        </div>
                    </div>
                </div>

                <article class="col-md-12 lapso">
                    <ul class="nav nav-tabs 2" id="myTab" role="tablist">
                        <li class="nav-item 2" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#usuarios" type="button" role="tab" aria-controls="home-tab-pane"
                                aria-selected="true"><i class="fa-solid fa-id-card-clip pestañitas"></i>
                                Usuarios</button>
                        </li>
                        <li class="nav-item 2" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#clientes"
                                type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false"><i
                                    class="fa-solid fa-user pestañitas"></i> Clientes</button>
                        </li>
                        <li class="nav-item 2" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#proovedores"
                                type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false"><i
                                    class="fa-solid fa-truck-field"></i> Proveedores</button>
                        </li>
                    </ul>


                    <div class="tab-content 2" id="myTabContent">
                        <div class="tab-pane fade show active " id="usuarios" role="tabpanel" aria-labelledby="home-tab"
                            tabindex="0">
                            <?php
                            require '../../../model/conexion.php';
                            $sqlUsuarios = "SELECT u.id, u.nombre, u.username, u.password,u.email, r.nombre AS roles FROM usuarios AS u INNER JOIN roles AS r ON u.id_rol=r.id";
                            $usuarios = $conexion->query($sqlUsuarios);
                            ?>
                            <div id="usuarios">

                                <div class="buscar">
                                    <div id="lucam">
                                        <label><i class="fa-solid fa-magnifying-glass lupa"></i></label>
                                        <input id="campobus1" type="text" placeholder="Buscar">
                                    </div>

                                    <a href="../gestionar/PDF/GenerarPDFuser.php" id="genPDF"><i
                                            class="fa-solid fa-file-pdf"></i> Generar PDF</a>

                                </div>

                                <?php
                                if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>

                                    <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show"
                                        role="alert">
                                        <?= $_SESSION['msg']; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>

                                    <?php
                                    unset($_SESSION['color']);
                                    unset($_SESSION['msg']);
                                } ?>

                                <table id="users">
                                    <thead>
                                        <td class="first">ID</td>
                                        <td>Nombre del usuario</td>
                                        <td>Username</td>
                                        <td>Email</td>
                                        <td>Rol</td>
                                        <td class="last">Acciones</td>
                                    </thead>
                                    <tbody>
                                        <?php while ($row_usuarios = $usuarios->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="first">
                                                    <?= $row_usuarios['id']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_usuarios['nombre']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_usuarios['username']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_usuarios['email']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_usuarios['roles']; ?>
                                                </td>
                                                <td class="last iconos">
                                                    <a href="#" class="linkicono" data-bs-toggle="modal"
                                                        data-bs-target="#editausuModal"
                                                        data-bs-id="<?= $row_usuarios['id'] ?>"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="#" class="linkicono" data-bs-toggle="modal"
                                                        data-bs-target="#eliminausuModal"
                                                        data-bs-id="<?= $row_usuarios['id'] ?>"><i
                                                            class="fa-solid fa-trash-can"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="btns">
                                <a href="#" id="adduser" data-bs-toggle="modal" data-bs-target="#nuevousuModal"><i
                                        class="fa-solid fa-user-plus"></i> Agregar Usuario</a>
                            </div>

                            <?php
                            $sqlRoles = "SELECT id,nombre FROM roles ";
                            $roles = $conexion->query($sqlRoles);
                            ?>
                            <?php include 'nuevousuModal.php'; ?>
                            <?php $roles->data_seek(0); ?>
                            <?php include 'editausuModal.php'; ?>
                            <?php include 'eliminausuModal.php'; ?>

                            <script>
                                let editaModal = document.getElementById('editausuModal')
                                let eliminaModal = document.getElementById('eliminausuModal')


                                editaModal.addEventListener('shown.bs.modal', event => {
                                    let button = event.relatedTarget
                                    let id = button.getAttribute('data-bs-id')

                                    let inputId = editaModal.querySelector('.modal-body #id')
                                    let inputNombre = editaModal.querySelector('.modal-body #nombre')
                                    let inputUsername = editaModal.querySelector('.modal-body #username')
                                    let inputEmail = editaModal.querySelector('.modal-body #email')
                                    let inputPassword = editaModal.querySelector('.modal-body #password')
                                    let inputRol = editaModal.querySelector('.modal-body #rol')

                                    let url = "getUsuario.php"
                                    let formData = new FormData()
                                    formData.append('id', id)

                                    fetch(url, {
                                        method: "POST",
                                        body: formData
                                    }).then(response => response.json())
                                        .then(data => {
                                            inputId.value = data.id
                                            inputNombre.value = data.nombre
                                            inputUsername.value = data.username
                                            inputPassword.value = data.password
                                            inputEmail.value = data.email
                                            inputRol.value = data.id_rol
                                        }).catch(err = console.log(err))
                                })

                                eliminaModal.addEventListener('shown.bs.modal', event => {
                                    let button = event.relatedTarget
                                    let id = button.getAttribute('data-bs-id')
                                    eliminaModal.querySelector('.modal-footer #id').value = id
                                })
                            </script>
                        </div>

                        <div class="tab-pane fade" id="clientes" role="tabpanel" aria-labelledby="profile-tab"
                            tabindex="0">
                            <?php
                            include "../../../model/conexion.php";
                            include "../../../controller/registro_cliente.php";
                            ?>
                            <div id="clientes">

                                <div class="buscar">
                                    <div id="lucam">
                                        <label><i class="fa-solid fa-magnifying-glass lupa"></i></label>
                                        <input id="campobus2" type="text" placeholder="Buscar">
                                    </div>

                                    <a href="../gestionar/PDF/GenerarPDFclientes.php" id="genPDF"><i
                                            class="fa-solid fa-file-pdf"></i> Generar PDF</a>

                                </div>

                                <table id="clientes">
                                    <thead>
                                        <td class="first">ID</td>
                                        <td>Nombres</td>
                                        <td>Apellidos</td>
                                        <td>Email</td>
                                        <td>Telefono</td>
                                        <td class="last">Acciones</td>
                                    </thead>
                                    <tbody>
                                        <?php $sqlClientes = "SELECT id, nombre, apellido, email, telefono FROM clientes";
                                        $resultClientes = $conexion->query($sqlClientes);

                                        while ($row_Clientes = $resultClientes->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="first">
                                                    <?= $row_Clientes['id']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_Clientes['nombre']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_Clientes['apellido']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_Clientes['email']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_Clientes['telefono']; ?>
                                                </td>

                                                <td class="last iconos" style="margin-top: 10px;">
                                                    <a href="#" class="linkicono" data-bs-toggle="modal"
                                                        data-bs-target="#editacliModal"
                                                        data-bs-id="<?= $row_Clientes['id']; ?>"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="#" class="linkicono" data-bs-toggle="modal"
                                                        data-bs-target="#eliminacliModal"
                                                        data-bs-id="<?= $row_Clientes['id']; ?>"><i
                                                            class="fa-solid fa-trash-can"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>


                            <?php include 'editacliModal.php'; ?>
                            <?php include 'eliminacliModal.php'; ?>

                            <script>
                                let editacliModal = document.getElementById('editacliModal')
                                let eliminacliModal = document.getElementById('eliminacliModal')

                                editacliModal.addEventListener('show.bs.modal', event => {
                                    let button = event.relatedTarget
                                    let id = button.getAttribute('data-bs-id')

                                    let inputId = editacliModal.querySelector('.modal-body #id')
                                    let inputNombres = editacliModal.querySelector('.modal-body #nombres')
                                    let inputApellidos = editacliModal.querySelector('.modal-body #apellidos')
                                    let inputEmail = editacliModal.querySelector('.modal-body #correo') // ID corregido
                                    let inputTelefono = editacliModal.querySelector('.modal-body #telefono')

                                    let url = "getClientes.php"
                                    let formData = new FormData()
                                    formData.append('id', id)

                                    fetch(url, {
                                        method: "POST",
                                        body: formData
                                    }).then(response => response.json())
                                        .then(data => {

                                            inputId.value = data.id
                                            inputNombres.value = data.nombre
                                            inputApellidos.value = data.apellido
                                            inputEmail.value = data.email
                                            inputTelefono.value = data.telefono

                                        }).catch(err => console.log(err))
                                })

                                eliminacliModal.addEventListener('show.bs.modal', event => {
                                    let button = event.relatedTarget
                                    let id = button.getAttribute('data-bs-id')
                                    eliminacliModal.querySelector('.modal-footer #id').value = id
                                })
                            </script>
                        </div>

                        <div class="tab-pane fade" id="proovedores" role="tabpanel" aria-labelledby="profile-tab"
                            tabindex="0">
                            <?php
                            require '../../../model/conexion.php';
                            $sqlProveedores = "SELECT p.nit, p.razonsocial, p.encargado, p.celular, p.correo FROM proveedores AS p";
                            $proveedores = $conexion->query($sqlProveedores);
                            ?>

                            <div id="prov">

                                <div class="buscar">
                                    <div id="lucam">
                                        <label><i class="fa-solid fa-magnifying-glass lupa"></i></label>
                                        <input id="campobus3" type="text" placeholder="Buscar">
                                    </div>

                                    <a href="../gestionar/PDF/GenerarPDFproveedores.php" id="genPDFProv"><i
                                            class="fa-solid fa-file-pdf"></i> Generar PDF</a>

                                </div>

                                <table id="proveedores">
                                    <thead>
                                        <td class="first">NIT</td>
                                        <td>Razón Social</td>
                                        <td>Encargado</td>
                                        <td>Celular</td>
                                        <td>Correo</td>
                                        <td class="last">Acciones</td>
                                    </thead>
                                    <tbody>
                                        <?php while ($row_proveedores = $proveedores->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="first">
                                                    <?= $row_proveedores['nit']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_proveedores['razonsocial']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_proveedores['encargado']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_proveedores['celular']; ?>
                                                </td>
                                                <td>
                                                    <?= $row_proveedores['correo']; ?>
                                                </td>
                                                <td class="last iconos">
                                                    <a href="#" class="linkicono" data-bs-toggle="modal"
                                                        data-bs-target="#editaprovModal"
                                                        data-bs-id="<?= $row_proveedores['nit'] ?>"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="#" class="linkicono" data-bs-toggle="modal"
                                                        data-bs-target="#eliminaprovModal"
                                                        data-bs-id="<?= $row_proveedores['nit'] ?>"><i
                                                            class="fa-solid fa-trash-can"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="btns">
                                <a href="#" id="addProv" data-bs-toggle="modal" data-bs-target="#nuevoprovModal"><i
                                        class="fa-solid fa-plus"></i> Agregar Proveedor</a>
                            </div>

                            <?php include 'nuevoprovModal.php'; ?>
                            <?php include 'editaprovModal.php'; ?>
                            <?php include 'eliminaprovModal.php'; ?>

                            <script>
                                let editaprovModal = document.getElementById('editaprovModal')
                                let eliminaprovModal = document.getElementById('eliminaprovModal')

                                editaprovModal.addEventListener('shown.bs.modal', event => {
                                    let button = event.relatedTarget;
                                    let nit = button.getAttribute('data-bs-id');

                                    let inputNit = editaprovModal.querySelector('.modal-body #nit');
                                    let inputRazonSocial = editaprovModal.querySelector('.modal-body #razonsocial');
                                    let inputEncargado = editaprovModal.querySelector('.modal-body #encargado');
                                    let inputCelular = editaprovModal.querySelector('.modal-body #celular');
                                    let inputCorreo = editaprovModal.querySelector('.modal-body #correo');

                                    let url = "getProveedor.php";
                                    let formData = new FormData();
                                    formData.append('nit', nit);

                                    fetch(url, {
                                        method: "POST",
                                        body: formData
                                    }).then(response => response.json())
                                        .then(data => {
                                            inputNit.value = data.nit;
                                            inputRazonSocial.value = data.razonsocial;
                                            inputEncargado.value = data.encargado;
                                            inputCelular.value = data.celular.toString();
                                            inputCorreo.value = data.correo;
                                        })
                                        .catch(err => console.log(err));
                                });

                                eliminaprovModal.addEventListener('shown.bs.modal', event => {
                                    let button = event.relatedTarget
                                    let nit = button.getAttribute('data-bs-id')
                                    eliminaprovModal.querySelector('.modal-footer #nit').value = nit
                                });
                            </script>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const campoBusqueda = document.getElementById("campobus1");
            const tabla = document.getElementById("usuarios").getElementsByTagName("tbody")[0];
            const filas = tabla.getElementsByTagName("tr");

            campoBusqueda.addEventListener("keyup", function () {
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

        document.addEventListener("DOMContentLoaded", function () {
            const campoBusqueda = document.getElementById("campobus2");
            const tabla = document.getElementById("clientes").getElementsByTagName("tbody")[0];
            const filas = tabla.getElementsByTagName("tr");

            campoBusqueda.addEventListener("keyup", function () {
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

        document.addEventListener("DOMContentLoaded", function () {
            const campoBusqueda = document.getElementById("campobus3");
            const tabla = document.getElementById("proveedores").getElementsByTagName("tbody")[0];
            const filas = tabla.getElementsByTagName("tr");

            campoBusqueda.addEventListener("keyup", function () {
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

    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../../../public/js/menulateral.js"></script>
</body>

</html>