<?php
require('../../lib/fpdf/fpdf.php');
include '../../class/InventarioConexion.php';
include '../../class/ProductosConexion.php';

// Obtener datos del inventario
$data = ListarInventario();
$inventories = $data['Detalle'] ?? [];

// Crear instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Añadir la imagen en la parte superior izquierda
$pdf->Image('../../img/logo-app-fondoBlanco.jpg', 10, 0, 30); // (file, x, y, width)

// Establecer la fuente para el documento
$pdf->SetFont('Arial', 'B', 12);

// Título
$pdf->Cell(0, 10, 'Reporte de Inventario', 0, 1, 'C');
$pdf->Ln(10);

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, '#', 1);
$pdf->Cell(60, 10, 'Producto', 1);
$pdf->Cell(40, 10, 'Cantidad Total', 1);
$pdf->Cell(40, 10, 'Cantidad Disponible', 1);
$pdf->Cell(30, 10, 'Fecha', 1);
$pdf->Ln();

// Datos de la tabla
$pdf->SetFont('Arial', '', 10);
foreach ($inventories as $inventory) {
    $pdf->Cell(20, 10, $inventory['inv_id'], 1);
    $pdf->Cell(60, 10, $inventory['pro_nombre'], 1);
    $pdf->Cell(40, 10, $inventory['inv_cantidad_total'], 1);
    $pdf->Cell(40, 10, $inventory['inv_cantidad_disponible'], 1);
    $pdf->Cell(30, 10, $inventory['inv_fecha_adquisicion'], 1);
    $pdf->Ln();
}

// Salida del archivo PDF
$pdf->Output('D', 'Reporte_Inventario.pdf');
?>
