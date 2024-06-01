<?php
require('../../../../fpdf/fpdf.php');
require('../../../../model/conexion.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../../../../public/img/Logo.png', 10, 8, 33);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Reporte de Usuarios', 0, 1, 'C');
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
$tableX = ($pageWidth - 255) / 2;

$pdf->SetX($tableX); 

// Obtener usuarios de la base de datos
$sqlUsuarios = "SELECT u.id, u.nombre, u.username, u.email, r.nombre AS rol FROM usuarios AS u INNER JOIN roles AS r ON u.id_rol=r.id";
$usuarios = $conexion->query($sqlUsuarios);

$pdf->Cell(20, 10, 'ID', 1, 0, 'C');
$pdf->Cell(80, 10, 'Nombre del usuario', 1, 0, 'C');
$pdf->Cell(30, 10, 'Username', 1, 0, 'C');
$pdf->Cell(80, 10, 'Email', 1, 0, 'C');
$pdf->Cell(40, 10, 'Rol', 1, 0, 'C');
$pdf->Ln();

while ($row_usuarios = $usuarios->fetch_assoc()) {
    $pdf->SetX($tableX);
    $pdf->Cell(20, 10, $row_usuarios['id'], 1, 0, 'C');
    $pdf->Cell(80, 10, utf8_decode($row_usuarios['nombre']), 1, 0, 'C');
    $pdf->Cell(30, 10, $row_usuarios['username'], 1, 0, 'C');
    $pdf->Cell(80, 10, utf8_decode($row_usuarios['email']), 1, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode($row_usuarios['rol']), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>
