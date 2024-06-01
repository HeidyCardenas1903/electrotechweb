<?php

require('../../../fpdf/fpdf.php');
require('../../../model/conexion.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../../../public/img/Logo.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(110, 10, 'Reporte de Inventario', 0, 20, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }
}

$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', '', 12);
$pageWidth = $pdf->GetPageWidth();
$tableX = ($pageWidth - 225) / 2;

$pdf->SetX($tableX); 

$pdf->Cell(10, 10, 'ID', 1, 0, 'C');
$pdf->Cell(60, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(40, 10, 'Precio', 1, 0, 'C');
$pdf->Cell(60, 10, 'Proveedor', 1, 0, 'C');
$pdf->Cell(15, 10, 'Stock', 1, 1, 'C');

// Obtener productos de la base de datos
$sqlProductos = "SELECT p.id, p.nombre, p.descripcion, p.precio, pr.razonsocial AS proveedor, p.stock FROM productos AS p INNER JOIN proveedores AS pr ON p.id_proveedor = pr.nit";
$productos = $conexion->query($sqlProductos);

while ($row_productos = $productos->fetch_assoc()) {
    $pdf->SetX($tableX);
    $pdf->Cell(10, 10, $row_productos['id'], 1, 0, 'C');
    $pdf->Cell(60, 10, utf8_decode($row_productos['nombre']), 1, 0, 'C');
    $pdf->Cell(40, 10, '$' . $row_productos['precio'], 1, 0, 'R');
    $pdf->Cell(60, 10, utf8_decode($row_productos['proveedor']), 1, 0);
    $pdf->Cell(15, 10, $row_productos['stock'], 1, 1, 'C');
}

// Salida del PDF
$pdf->Output();
?>
