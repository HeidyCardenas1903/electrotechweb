<?php
include '../../../controller/mostrardatosperfil.php';
?>

<!-- NO BORRAR - IMPOTANTE!!!!! es lo que protege las vistas -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroTech | Ventas</title>

    <!-- Enlaces a recursos externos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/icono.ico" />
    <link rel="stylesheet" href="../../../public/css/ventas.css">
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
    <!-- Contenido principal -->
    <section class="home">
        <div class="container">
            <div class="row header">
                <div class="col-md-10">
                    <h2 id="titulo"><i class="fa-solid fa-cart-plus"></i> Ventas</h2>
                </div>
                <div class="col-md-2">
                    <img src="../../../public/img/logo2.svg" alt="Logo">
                </div>
            </div>
            <div class="row body">

            </div>
        </div>
        </div>

        <div class="datos_cliente">
            <div class="action_cliente">
                <h3>Datos del cliente</h3>
                <a href="#" class="btn_new btn_new_cliente" id="nuevoClienteLink"><i class="fa-solid fa-plus"></i> Nuevo cliente</a>

            </div>
            <form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos">
                <input type="hidden" name="action" value="addCliente">
                <input type="hidden" id="idcliente" name="idcliente" value="" required>
                <div>
                    <label>ID</label>
                    <input type="text" name="nit_cliente" id="nit_cliente">
                </div>
                <div>
                    <label>Nombre</label>
                    <input type="text" name="nom_cliente" id="nom_cliente" disabled required>
                </div>
                <div>
                    <label>Apellido</label>
                    <input type="text" name="apl_cliente" id="apl_cliente" disabled required>
                </div>
                <div class="2">
                    <label>Telefono</label>
                    <input type="number" name="tel_cliente" id="tel_cliente" disabled required>
                    <label>Correo</label>
                    <input type="text" name="cor_cliente" id="cor_cliente" disabled required>
                </div>
                <div id="div_registro_cliente" class="wd100">
                    <button type="submit" class="btn_save"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                </div>
            </form>
        </div>
        <div class="datos_venta">
            <h4>Datos de la venta</h4>
            <div class="venta">
                <div class="wd50">
                    <label>Vendedor</label>
                    <p><?php echo $usuarioData['nombre']; ?></p>
                </div>
                <div class="wd50">
                    <div id="acciones_venta">
                        <a href="#" class="btn_ok textcenter" id="btn_anular_venta"><i class="fa-solid fa-eraser">  </i>Anular</a>
                        <a href="#" class="btn_new textcenter" id="btn_facturar_venta" style="display : none;"><i class="fa-solid fa-pen-to-square"></i>Procesar</a>
                    </div>
                </div>
            </div>
        </div>

        <table class="tbl_venta">
            <thead>
                <tr class="cabecera">
                    <th width="100px" class="first">Código</th>
                    <th>Producto</th>
                    <th>Existencia</th>
                    <th width="100px">Cantidad</th>
                    <th class="textright">Precio</th>
                    <th class="textright">Precio Total</th>
                    <th class="last">Acción</th>
                </tr>
                <tr>
                    <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
                    <td id="txt_descripcion">-</td>
                    <td id="txt_existencia">-</td>
                    <td><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
                    <td id="txt_precio" class="textright">00.0</td>
                    <td id="txt_precio_total" class="textright">00.0</td>
                    <td><a href="#" id="add_product_venta" class="link_add"><i class="fa-solid fa-plus"></i>Agregar</a></td>
                </tr>
                <tr class="cabecera">
                    <th>Código</th>
                    <th colspan="2">Descripción</th>
                    <th>Cantidad</th>
                    <th class="textright">Precio</th>
                    <th class="textright">Precio total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="detalle_venta">
                <!-- CONTENIDO AJAX -->
            </tbody>
        </table>
        <div id="detalle_totales">
                <!-- CONTENIDO AJAX -->
        </div>
    </section>


    <!-- Scripts al final del cuerpo del documento -->
    <script src="https://kit.fontawesome.com/909a90592e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../../../public/js/menulateral.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#search_proveedor').change(function(e) {
            e.preventDefault();
            var sistema = getUrl();
            location.href = sistema + 'buscar_productos.php?proveedor=' + $(this).val();
        });

        // Activar campos para registrar cliente
        document.getElementById('nuevoClienteLink').addEventListener('click', function(e) {
            e.preventDefault();
            $('#nom_cliente').removeAttr('disabled');
            $('#apl_cliente').removeAttr('disabled');
            $('#tel_cliente').removeAttr('disabled');
            $('#cor_cliente').removeAttr('disabled');

            $('#div_registro_cliente').slideDown();
        });

        // Buscar Cliente
        $('#nit_cliente').keyup(function(e) {
            e.preventDefault();

            var cl = $(this).val();
            var action = 'searchCliente';

            $.ajax({
                url: 'ajaxven.php',
                type: 'POST',
                async: true,
                data: {
                    action: action,
                    cliente: cl
                },

                success: function(response) {
                    if (response == 0) {
                        $('#idcliente').val('');
                        $('#nom_cliente').val('');
                        $('#apl_cliente').val('');
                        $('#tel_cliente').val('');
                        $('#cor_cliente').val('');
                        // boton agregar
                        $('.btn_new_cliente').slideDown();
                    } else {
                        var data = $.parseJSON(response);
                        $('#idcliente').val(data.id);
                        $('#nom_cliente').val(data.nombre);
                        $('#apl_cliente').val(data.apellido);
                        $('#tel_cliente').val(data.telefono);
                        $('#cor_cliente').val(data.email);
                        // ocultar btn
                        $('.btn_new_cliente').slideUp();

                        //bloque campos
                        $('#nom_cliente').attr('disabled', 'disabled');
                        $('#apl_cliente').attr('disabled', 'disabled');
                        $('#tel_cliente').attr('disabled', 'disabled');
                        $('#dir_cliente').attr('disabled', 'disabled');

                        // oculta boton
                        $('#div_registro_cliente').slideUp();
                    }

                },
                error: function(error) {

                }
            })

        });

        // Crear Cliente - Ventas
        $('#form_new_cliente_venta').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'ajaxven.php',
                type: 'POST',
                async: true,
                data: $('#form_new_cliente_venta').serialize(),

                success: function(response) {
                    if (response != 'error') {
                        // agregar id a input hidden
                        $('#idCLiente').val(response);
                        // bloque campos
                        $('#nom_cliente').attr('disabled', 'disabled');
                        $('#apl_cliente').attr('disabled', 'disabled');
                        $('#cor_cliente').attr('disabled', 'disabled');
                        $('#tel_cliente').attr('disabled', 'disabled');

                        // oculta boton agregar
                        $('.btn_new_cliente').slideUp();
                        // ocultar boton agregar
                        $('#div_registro_cliente').slideUp();

                    }

                },
                error: function(error) {

                }
            })


        });

        // Buscar Producto
        $('#txt_cod_producto').keyup(function(e) {
            e.preventDefault();

            var producto = $(this).val();
            var action = 'infoProducto';

            if (producto != '') {
                $.ajax({
                    url: 'ajaxven.php',
                    type: 'POST',
                    async: true,
                    data: {
                        action: action,
                        producto: producto
                    },

                    success: function(response) {
                        if (response != 'error') {
                            var info = JSON.parse(response);
                            $('#txt_descripcion').html(info.nombre);
                            $('#txt_existencia').html(info.stock);
                            $('#txt_cant_producto').val('1');
                            $('#txt_precio').html(info.precio);
                            $('#txt_precio_total').html(info.precio);

                            // Activar Cantidad
                            $('#txt_cant_producto').removeAttr('disabled');

                            // Mostrar Botón Agregar
                            $('#add_product_venta').slideDown();
                        } else {
                            $('#txt_descripcion').html('-');
                            $('#txt_existencia').html('-');
                            $('#txt_cant_producto').val('0');
                            $('#txt_precio').html('0.00');
                            $('#txt_precio_total').html('0.00');

                            // Bloquear Cantidad
                            $('#txt_descripcion').attr('disabled', 'disabled');

                            //Ocultar boton agregar
                            $('#add_product_venta').slideUp();

                        }

                    },
                    error: function(error) {

                    }
                });


            }

        });

        // Validar cantidad del producto antes de agregar
        $('#txt_cant_producto').keyup(function(e) {
            e.preventDefault();
            var precio_total = $(this).val() * $('#txt_precio').html();
            var existencia = parseInt($('#txt_existencia').html());
            $('#txt_precio_total').html(precio_total);

            // Oculta el boton agregar si la cantidad es menor que 1
            if (($(this).val() < 1 || isNaN($(this).val())) || $(this).val() > existencia) {
                $('#add_product_venta').slideUp();
            } else {
                $('#add_product_venta').slideDown();
            }

        });

        // Agregar producto al detalle
        $('#add_product_venta').click(function(e) {
            e.preventDefault();
            if ($('#txt_cant_producto').val() > 0) {
                var codproducto = $('#txt_cod_producto').val();
                var cantidad = $('#txt_cant_producto').val();
                var action = 'addProductoDetalle';

                $.ajax({
                    url: 'ajaxven.php',
                    type: 'POST',
                    async: true,
                    data: {
                        action: action,
                        producto: codproducto,
                        cantidad: cantidad
                    },

                    success: function(response) {
                        if (response != 'error') {

                            var info = JSON.parse(response);
                            $('#detalle_venta').html(info.detalle);
                            $('#detalle_totales').html(info.totales);

                            $('#txt_cod_producto').val('');
                            $('#txt_descripcion').html('-');
                            $('#txt_existencia').html('-');
                            $('#txt_cant_producto').val('0');
                            $('#txt_precio').html('0.00');
                            $('#txt_precio_total').html('0.00');

                            // Bloquear cantidad
                            $('#txt_cant_producto').attr('disabled', 'disabled');

                            // Bloquear Botón agregar
                            $('#add_product_venta').slideUp();

                        } else {
                            console.log('no data');
                        }
                        viewProcesar(); 

                    },
                    error: function(error) {

                    }

                });

            }

        });

        // Anular Venta
        $('#btn_anular_venta').click(function(e){
            e.preventDefault();

            var rows = $('#detalle_venta tr').length;
            if (rows > 0)
            {
                 var action = 'anularVenta';

                 $.ajax({
                    url: 'ajaxven.php',
                    type: "POST",
                    async: true,
                    data: {action:action},

                    success: function(response)
                    {
                        if(response != 'error')
                        {
                            location.reload();
                        }
                    },
                    error: function(error){
                    }
                 })
                
            }
        })

        // Facturar Venta
        $('#btn_facturar_venta').click(function(e){
            e.preventDefault();

            var rows = $('#detalle_venta tr').length;
            if (rows > 0)
            {
                 var action = 'procesarVenta';
                 var codcliente = $('#idcliente').val();

                 $.ajax({
                    url: 'ajaxven.php',
                    type: "POST",
                    async: true,
                    data: {action:action, codcliente:codcliente},

                    success: function(response)
                    {
                        if(response != 'error')
                        {
                            var info = JSON.parse(response);

                            generarPDF(info.id_cliente, info.id)

                            location.reload();
                        }else{
                            console.log('no data');
                        }
                    },
                    error: function(error){
                    }
                 })
                
            }
        })

    });
    // Cierre Ready

    function del_product_detalle(correlativo){

        var action = 'delProductoDetalle';
        var id_detalle = correlativo;

        $.ajax({
            url: 'ajaxven.php',
            type: 'POST',
            async: true,
            data: {
                action: action,
                id_detalle:id_detalle
            },
            success: function(response) {
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('#detalle_venta').html(info.detalle);
                    $('#detalle_totales').html(info.totales);

                    $('#txt_cod_producto').val('');
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').val('0');
                    $('#txt_precio').html('0.00');
                    $('#txt_precio_total').html('0.00');

                    // Bloquear cantidad
                    $('#txt_cant_producto').attr('disabled', 'disabled');

                    // Bloquear Botón agregar
                    $('#add_product_venta').slideUp();
                    
                } else {
                $('#detalle_venta').html('');
                $('#detalle_totales').html('');
            
                }
                viewProcesar();
            },
            error: function(error) {}
        });

    }

    // Mostrar/Ocultar Boton procesar
    function viewProcesar(){
            if ($('#detalle_venta tr').length > 0) 
            {
                $('#btn_facturar_venta').show();
            } else {
                $('#btn_facturar_venta').hide();
            }
        }

    function searchForDetalle(id) {
        var action = 'searchForDetalle';
        var user = id;

        $.ajax({
            url: 'ajaxven.php',
            type: 'POST',
            async: true,
            data: {
                action: action,
                user: user
            },
            success: function(response) {
                if (response != 'error') {

                    var info = JSON.parse(response);
                    $('#detalle_venta').html(info.detalle);
                    $('#detalle_totales').html(info.totales);

                } else {
                    console.log('no data');
                }
                viewProcesar();
            },
            error: function(error) {}
        });
    }

    function generarPDF(cliente,factura){
            var width = 1000;
            var height = 1000;

            var x = parseInt((window.screen.width/2) - (width/2));
            var y = parseInt((window.screen.height/2) - (height/2));

            $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
            window.open($url,"Factura","left="+x+",top="+y+",height="+height+",width"+width+",scrollbar=si,location=no,resizable=si,menubar=no");
            }

    function getUrl() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length + pathName.length));
    }    
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var usuarioid = '<?php echo $usuarioData['id']; ?>';
            searchForDetalle(usuarioid);
        })
    </script>

</body>

</html>