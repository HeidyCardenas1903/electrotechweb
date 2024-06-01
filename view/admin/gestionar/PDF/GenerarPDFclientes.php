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
$tableX = ($pageWidth - 250) / 2;

$pdf->SetX($tableX); 

$sqlClientes = "SELECT id, nombre, apellido, email, telefono FROM clientes";
$clientes = $conexion->query($sqlClientes);

$pdf->Cell(20, 10, 'ID', 1, 0, 'C');
$pdf->Cell(60, 10, 'Nombres', 1, 0, 'C');
$pdf->Cell(60, 10, 'Apellidos', 1, 0, 'C');
$pdf->Cell(60, 10, 'Email', 1, 0, 'C');
$pdf->Cell(40, 10, 'Telefono', 1, 0, 'C');
$pdf->Ln();

while ($row_clientes = $clientes->fetch_assoc()) {
    $pdf->SetX($tableX);
    $pdf->Cell(20, 10, $row_clientes['id'], 1, 0, 'C');
    $pdf->Cell(60, 10, utf8_decode($row_clientes['nombre']), 1, 0, 'C');
    $pdf->Cell(60, 10, utf8_decode($row_clientes['apellido']), 1, 0, 'C');
    $pdf->Cell(60, 10, utf8_decode($row_clientes['email']), 1, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode($row_clientes['telefono']), 1, 0, 'C');
    $pdf->Ln();
}
$pdf->Output();
?>
