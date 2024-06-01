<?php
require('../../../../fpdf/fpdf.php');
require('../../../../model/conexion.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../../../../public/img/Logo.png', 10, 8, 33);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Reporte de Proveedores', 0, 1, 'C');
        $this->Ln(10);
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
$tableX = ($pageWidth - 220) / 2;

$pdf->SetX($tableX); 

$sqlProveedores = "SELECT p.nit, p.razonsocial, p.encargado, p.celular, p.correo FROM proveedores AS p";
$proveedores = $conexion->query($sqlProveedores);

$pdf->Cell(30, 10, 'NIT', 1, 0, 'C');
$pdf->Cell(50, 10, utf8_decode('Razón Social'), 1, 0, 'C');
$pdf->Cell(30, 10, 'Encargado', 1, 0, 'C');
$pdf->Cell(40, 10, 'Celular', 1, 0, 'C');
$pdf->Cell(70, 10, 'Correo', 1, 0, 'C');
$pdf->Ln();

while ($row_proveedores = $proveedores->fetch_assoc()) {
    $pdf->SetX($tableX);
    $pdf->Cell(30, 10, $row_proveedores['nit'], 1, 0, 'C');
    $pdf->Cell(50, 10, utf8_decode($row_proveedores['razonsocial']), 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($row_proveedores['encargado']), 1, 0, 'C');
    $pdf->Cell(40, 10, $row_proveedores['celular'], 1, 0, 'C');
    $pdf->Cell(70, 10, utf8_decode($row_proveedores['correo']), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>
