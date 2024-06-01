<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	// if(empty($_SESSION['active']))
	// {
	// 	header('location: ../');
	// }

	include "../../../../model/conexion.php";
	require_once 'dompdf/autoload.inc.php';
	use Dompdf\Dompdf;

	$domPDF = new Dompdf();

	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conexion,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}


		$query = mysqli_query($conexion,"SELECT f.id as nofactura, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.id_cliente as codcliente, f.estatus,
												 v.nombre as vendedor,
												 cl.id as nit, cl.nombre,cl.apellido, cl.telefono,cl.email
											FROM facturas f
											INNER JOIN usuarios v
											ON f.id_usuario = v.id
											INNER JOIN clientes cl
											ON f.id_cliente = cl.id
											WHERE f.id = $noFactura AND f.id_cliente = $codCliente  AND f.estatus != 10 ");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['nofactura'];

			if($factura['estatus'] == 2){
				$anulada = '<img class="anulada" src="../img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($conexion,"SELECT p.nombre,dt.cantidad,dt.preciototal as precio_venta,(dt.cantidad * dt.preciototal) as precio_final
														FROM facturas f
														INNER JOIN detallefactura dt
														ON f.id = dt.id_factura
														INNER JOIN productos p
														ON dt.id_producto = p.id
														WHERE f.id = $no_factura ");
			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instanciar y usar la clase dompdf
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Opcional) Configurar el tamaño y la orientación del papel
			$dompdf->setPaper('letter', 'portrait');
			// Renderizar el HTML como PDF
			$dompdf->render();
			// Salida del PDF generado al navegador
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>
