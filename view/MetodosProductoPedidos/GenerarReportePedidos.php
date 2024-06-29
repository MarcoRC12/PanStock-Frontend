<?php
require('../../lib/fpdf/fpdf.php');
include('../../class/ProductoPedidosConexion.php');

$data = ListarProductoPedidos();

if ($data && isset($data['Status']) && $data['Status'] == 200 && isset($data['Detalle'])) {
    $orders = $data['Detalle'];
} else {
    $orders = [];
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Logo
$pdf->Image('../../img/logo-app-fondoBlanco.jpg', 10, 6, 30);
$pdf->Ln(20);

$pdf->Cell(0, 10, 'Reporte de Pedidos Recientes', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(40, 10, 'Numero de Pedido', 1);
$pdf->Cell(60, 10, 'Precio Total', 1);
$pdf->Cell(60, 10, 'Fecha de Entrega', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
foreach ($orders as $order) {
    $pdf->Cell(40, 10, $order['pe_numero'], 1);
    $pdf->Cell(60, 10, 'S/. ' . $order['pe_preciototal'], 1);
    $pdf->Cell(60, 10, $order['pe_fechaentrega'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'Reporte_Pedidos_Recientes.pdf');
?>
