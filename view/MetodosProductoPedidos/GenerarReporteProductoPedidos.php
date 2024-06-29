<?php
require('../../lib/fpdf/fpdf.php');
include('../../class/ProductoPedidosConexion.php');

$data = ListarProductoPedidos();

$topSellingProducts = [];

if ($data && isset($data['Status']) && $data['Status'] == 200 && isset($data['Detalle'])) {
    $orders = $data['Detalle'];

    // Agrupar y contar la cantidad de productos vendidos
    foreach ($orders as $order) {
        $productName = $order['pro_nombre'];
        $quantity = $order['prope_cantidad'];
        $lastSoldDate = $order['pe_fechaentrega'];

        if (!isset($topSellingProducts[$productName])) {
            $topSellingProducts[$productName] = [
                'quantity' => 0,
                'lastSoldDate' => $lastSoldDate,
            ];
        }

        $topSellingProducts[$productName]['quantity'] += $quantity;

        // Actualizar la fecha de última venta si es más reciente
        if (strtotime($lastSoldDate) > strtotime($topSellingProducts[$productName]['lastSoldDate'])) {
            $topSellingProducts[$productName]['lastSoldDate'] = $lastSoldDate;
        }
    }

    // Ordenar los productos por cantidad vendida en orden descendente
    uasort($topSellingProducts, function($a, $b) {
        return $b['quantity'] - $a['quantity'];
    });
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Logo
$pdf->Image('../../img/logo-app-fondoBlanco.jpg', 10, 6, 30);
$pdf->Ln(20);

$pdf->Cell(0, 10, 'Reporte de Productos Mas Vendidos', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(60, 10, 'Producto', 1);
$pdf->Cell(40, 10, 'Cantidad', 1);
$pdf->Cell(60, 10, 'Ultima Venta', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
foreach ($topSellingProducts as $productName => $productDetails) {
    $pdf->Cell(60, 10, $productName, 1);
    $pdf->Cell(40, 10, $productDetails['quantity'] . ' unidades', 1);
    $pdf->Cell(60, 10, $productDetails['lastSoldDate'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'Reporte_Productos_Mas_Vendidos.pdf');
?>
