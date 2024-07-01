<?php
require('../../lib/fpdf/fpdf.php');

// Generar PDF de comprobante de pago
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Logo
$pdf->Image('../../img/logo-app-fondoBlanco.jpg', 10, 6, 30);
$pdf->Ln(20);

// Título
$pdf->Cell(0, 10, 'Boleta de Pedido', 0, 1, 'C');

// Información del Pedido
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Pedido No: ' . $penumero, 0, 1);
$pdf->Cell(0, 10, 'Direccion: ' . $pedireccion, 0, 1);
$pdf->Cell(0, 10, 'Fecha de Entrega: ' . $pefechaentrega, 0, 1);

// Tabla de Productos
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Cantidad', 1);
$pdf->Cell(40, 10, 'Precio Unitario', 1);
$pdf->Cell(40, 10, 'Precio Total', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
foreach ($productos as $producto) {
    $pdf->Cell(40, 10, $producto['prope_descripcion'], 1);
    $pdf->Cell(30, 10, $producto['prope_cantidad'], 1);
    $pdf->Cell(40, 10, $producto['prope_precio'], 1);
    $pdf->Cell(40, 10, ($producto['prope_cantidad'] * $producto['prope_precio']), 1);
    $pdf->Ln();
}

$pdf->Cell(0, 10, 'Precio Total: S/. ' . $pepreciototal, 0, 1);

$pdf->Output('F', '../../pdf/comprobante_' . $peid . '.pdf');
