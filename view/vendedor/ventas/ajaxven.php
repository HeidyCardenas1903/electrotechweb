<?php
    include "../../../model/conexion.php";
    session_start();


    $usuario = $_SESSION['usuario'];

    $consulta = "SELECT * FROM usuarios WHERE username='$usuario'";
    $resultado = $conexion->query($consulta);

    $usuarioData = $resultado->fetch_assoc();



    if(!empty($_POST)){

        // Buscar Cliente
        if($_POST['action'] == 'searchCliente')
        {
            if(!empty($_POST['cliente'])){
                $id = $_POST['cliente'];

                $query = mysqli_query($conexion, "SELECT * FROM clientes WHERE id like '$id'");

                mysqli_close($conexion);
                $result = mysqli_num_rows($query);

                $data = '';
                if($result > 0){
                    $data = mysqli_fetch_assoc($query);
                }else{
                    $data = 0;
                }
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            }
            exit;
        }
        
        // Registra Cliente - Ventas
        if($_POST['action'] == 'addCliente')
        {
            $nit = $_POST['nit_cliente'];
            $nombre = $_POST['nom_cliente'];
            $apellido = $_POST['apl_cliente'];
            $correo = $_POST['cor_cliente'];
            $telefono = $_POST['tel_cliente'];

            $query_insert = mysqli_query($conexion, "INSERT INTO clientes(id, nombre, apellido, email, telefono, id_rol) VALUES ('$nit', '$nombre', '$apellido', '$correo', '$telefono', 3 )");

            if ($query_insert) {
                $codCliente = mysqli_insert_id($conexion);
                $msg = $codCliente;
            }else{
                $msg = 'error';
            }
            mysqli_close($conexion);
            echo $msg;
            exit;


        }

        //Buscar Productos
        if($_POST['action'] == 'infoProducto')
        {
            $id_producto = $_POST['producto'];

            $query = mysqli_query($conexion, "SELECT id, nombre, stock, precio FROM productos WHERE id = $id_producto ");

            mysqli_close($conexion);
            $result = mysqli_num_rows($query);

            if($result > 0){
                $data = mysqli_fetch_assoc($query);
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
                exit;

            }
            echo 'error';
            exit;
        }

        //Agregar producto al detalle temporal
        if($_POST['action'] == 'addProductoDetalle'){
            if (empty($_POST['producto']) || empty($_POST['cantidad'])) {
                echo 'error';
            }else{
                $codproducto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                $token = md5($usuarioData['id']);

                $query_iva = mysqli_query($conexion, "SELECT iva FROM configuracion");
                $result_iva = mysqli_num_rows($query_iva);
    
                $query_detalle_temp = mysqli_query($conexion, "CALL add_detalle_temp($codproducto, $cantidad, '$token')");
                $result = mysqli_num_rows($query_detalle_temp);

                $detalleTabla = '';
                $iva = 0;
                $sub_total = 0;
                $total = 0;
                $arrayData = array();

                if ($result > 0) {
                    if($result_iva > 0){
                        $info_iva = mysqli_fetch_assoc($query_iva);
                        $iva = $info_iva['iva'];
                       
                    }
                    while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
                        $precioTotal = round($data['cantidad'] * $data['preciototal'], 2);
                        $sub_total = round($sub_total+$precioTotal, 2);
                        $total = round($total+ $precioTotal, 2);

                        $detalleTabla .= '
                        <tr>
                            <td>'.$data['id_producto'].'</td>
                            <td colspan="2">'.$data['nombre'].'</td>
                            <td class="textcenter">'.$data['cantidad'].'</td>
                            <td class="textright">'.$data['preciototal'].'</td>
                            <td class="textright">'.$precioTotal.'</td>
                            <td class="">
                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        ';

                    }

                    $impuesto = round($sub_total * ($iva / 100), 2);
                    $tl_sniva = round($sub_total - $impuesto, 2);
                    $total = round($tl_sniva + $impuesto, 2);

                    $detalleTotales = '
                    
                    <div class="row1">
                        <p colspan="5" class="result">SUBTOTAL: </p>
                        <p class="result2">$'.$tl_sniva.'</p>
                    </div>
                    <div class="row2">
                        <p colspan="5" class="result">IVA: ('.$iva.'%)</p>
                        <p class="result2">'.$impuesto.'</p>
                    </div>
                    <hr>
                    <div class="row3">
                        <p colspan="5" class="result">TOTAL: </p>
                        <p class="result2">$'.$total.'</p>
                    </div>
                    ';

                    $arrayData['detalle'] = $detalleTabla;
                    $arrayData['totales'] = $detalleTotales;

                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);


                }else{
                    echo 'error';
                }
                mysqli_close($conexion);

            }
            exit;
        }

        // Extrae datos del detalle_temp
        if($_POST['action'] == 'searchForDetalle'){
            if (empty($_POST['user'])) {
                echo 'error';
            }else{

                $token = md5($usuarioData['id']);

                $query = mysqli_query($conexion, "SELECT tmp.correlativo, tmp.token_user, tmp.cantidad, tmp.preciototal, p.id, p.nombre 
                                                    FROM detalle_temp tmp INNER JOIN productos p ON tmp.id_producto = p.id WHERE token_user = '$token'");

                $query_iva = mysqli_query($conexion, "SELECT iva FROM configuracion");
                $result_iva = mysqli_num_rows($query_iva);


                $result = mysqli_num_rows($query);

                $detalleTabla = '';
                $iva = 0;
                $sub_total = 0;
                $total = 0;
                $arrayData = array();

                if ($result > 0) {
                    if($result_iva > 0){
                        $info_iva = mysqli_fetch_assoc($query_iva);
                        $iva = $info_iva['iva'];

                    }
                    while ($data = mysqli_fetch_assoc($query)) {
                        $precioTotal = round($data['cantidad'] * $data['preciototal'], 2);
                        $sub_total = round($sub_total+$precioTotal, 2);
                        $total = round($total+ $precioTotal, 2);

                        $detalleTabla .= '
                        <tr>
                            <td>'.$data['id'].'</td>
                            <td colspan="2">'.$data['nombre'].'</td>
                            <td class="textcenter">'.$data['cantidad'].'</td>
                            <td class="textright">'.$data['preciototal'].'</td>
                            <td class="textright">'.$precioTotal.'</td>
                            <td class="">
                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        ';

                    }

                    $impuesto = round($sub_total * ($iva / 100), 2);
                    $tl_sniva = round($sub_total - $impuesto, 2);
                    $total = round($tl_sniva + $impuesto, 2);

                    $detalleTotales = '
                    
                    <div class="row1">
                        <p colspan="5" class="result">SUBTOTAL: </p>
                        <p class="result2">$'.$tl_sniva.'</p>
                    </div>
                    <div class="row2">
                        <p colspan="5" class="result">IVA: ('.$iva.'%)</p>
                        <p class="result2">'.$impuesto.'</p>
                    </div>
                    <hr>
                    <div class="row3">
                        <p colspan="5" class="result">TOTAL: </p>
                        <p class="result2">$'.$total.'</p>
                    </div>
                    ';

                    $arrayData['detalle'] = $detalleTabla;
                    $arrayData['totales'] = $detalleTotales;

                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);


                }else{
                    echo 'error';
                }
                mysqli_close($conexion);

            }
            exit;
        }


        if($_POST['action'] == 'delProductoDetalle'){
            if (empty($_POST['id_detalle'])) {
                echo 'error';
            }else{
                $id_detalle = $_POST['id_detalle'];
                $token = md5($usuarioData['id']);

                $query_iva = mysqli_query($conexion, "SELECT iva FROM configuracion");
                $result_iva = mysqli_num_rows($query_iva);

                
                $query_detalle_temp = mysqli_query($conexion, "CALL del_detalle_temp($id_detalle,'$token')");
                $result = mysqli_num_rows($query_detalle_temp);

                $detalleTabla = '';
                $iva = 0;
                $sub_total = 0;
                $total = 0;
                $arrayData = array();

                if ($result > 0) {
                    if($result_iva > 0){
                        $info_iva = mysqli_fetch_assoc($query_iva);
                        $iva = $info_iva['iva'];

                    }
                    while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
                        $precioTotal = round($data['cantidad'] * $data['preciototal'], 2);
                        $sub_total = round($sub_total+$precioTotal, 2);
                        $total = round($total+ $precioTotal, 2);

                        $detalleTabla .= '
                        <tr>
                            <td>'.$data['id_producto'].'</td>
                            <td colspan="2">'.$data['nombre'].'</td>
                            <td class="textcenter">'.$data['cantidad'].'</td>
                            <td class="textright">'.$data['preciototal'].'</td>
                            <td class="textright">'.$precioTotal.'</td>
                            <td class="">
                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        ';

                    }

                    $impuesto = round($sub_total * ($iva / 100), 2);
                    $tl_sniva = round($sub_total - $impuesto, 2);
                    $total = round($tl_sniva + $impuesto, 2);

                    $detalleTotales = '
                    
                    <div class="row1">
                        <p colspan="5" class="result">SUBTOTAL: </p>
                        <p class="result2">$'.$tl_sniva.'</p>
                    </div>
                    <div class="row2">
                        <p colspan="5" class="result">IVA: ('.$iva.'%)</p>
                        <p class="result2">'.$impuesto.'</p>
                    </div>
                    <hr>
                    <div class="row3">
                        <p colspan="5" class="result">TOTAL: </p>
                        <p class="result2">$'.$total.'</p>
                    </div>
                    ';

                    $arrayData['detalle'] = $detalleTabla;
                    $arrayData['totales'] = $detalleTotales;

                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);


                }else{
                    echo 'error';
                }
                mysqli_close($conexion);

            }
            exit;
        }

        // Anular Venta
        if($_POST['action'] == 'anularVenta'){

            $token = md5($usuarioData['id']);
            
            $query_del = mysqli_query($conexion, "DELETE FROM detalle_temp WHERE token_user = '$token' ");
            
            mysqli_close($conexion);
            if ($query_del) {
                echo 'ok';
            }else{
                echo 'error';
            }
            exit;
        }

        // Procesar Venta
        if($_POST['action'] == 'procesarVenta'){
           
            if(empty($_POST['codcliente'])){
                
                echo 'error';
                }else{
                $codcliente = $_POST['codcliente'];
                

                $token = md5($usuarioData['id']);
                $usuario = $usuarioData['id'];

                $query = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE token_user = '$token'");
                $result = mysqli_num_rows($query);

                if($result > 0){
                    $query_procesar = mysqli_query($conexion, "CALL procesar_venta ($usuario, $codcliente, '$token')" );
                    $result_detalle = mysqli_num_rows($query_procesar);

                    if($result_detalle > 0){
                        $data = mysqli_fetch_assoc($query_procesar);
                        echo json_encode($data, JSON_UNESCAPED_UNICODE);
                    }else{
                        echo "error";
                    }

                }else{
                    echo "error";
                }
            }
            mysqli_close($conexion);
            exit;

        }


    }
    exit;

?>
