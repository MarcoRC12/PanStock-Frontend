<?php

include('../class/PedidosConexion.php');
include('../class/ProductoPedidosConexion.php');

//Obtener los datos
$data = ListarProductoPedidos();

$orders = [];
$topSellingProducts = [];

if ($data && isset($data['Status']) && $data['Status'] == 200 && isset($data['Detalle'])) {
    $orders = $data['Detalle'];

    // Ordenar los pedidos por la fecha más reciente
    usort($orders, function ($a, $b) {
        return strtotime($b['pe_fechaentrega']) - strtotime($a['pe_fechaentrega']);
    });

    // Ordenar los pedidos por la fecha más reciente
    usort($orders, function ($a, $b) {
        return strtotime($b['pe_fechaentrega']) - strtotime($a['pe_fechaentrega']);
    });

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
    uasort($topSellingProducts, function ($a, $b) {
        return $b['quantity'] - $a['quantity'];
    });
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="../img/logo-app.jpg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php include('menu.php'); ?>
    <div class="flex-1 p-6">
        <h1 class="text-5xl text-yellow-800 font-bold mb-6">¡Bienvenido!</h1>
        <p class="text-gray-600 mb-8">Gestiona tu invetario, insumos, reportes y clientes.</p>
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Pedidos Recientes</h2>
                    <button onclick="window.location.href='MetodosProductoPedidos/GenerarReportePedidos.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" x2="12" y1="15" y2="3"></line>
                        </svg>
                        Generar Reporte
                    </button>

                </div>
                <ul class="space-y-2">
                    <?php
                    if (!empty($orders)) {
                        foreach ($orders as $order) {
                            echo "<li>
                        <div class='flex items-center justify-between'>
                            <span>Pedido #{$order['pe_numero']}</span>
                            <span class='font-medium'>S/. {$order['pe_preciototal']}</span>
                        </div>
                        <div class='text-gray-600 text-sm'>Fecha de entrega: {$order['pe_fechaentrega']}</div>
                      </li>";
                        }
                    } else {
                        echo "<li class='text-red-500'>No se encontraron pedidos recientes</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Productos más vendidos</h2>
                    <button onclick="window.location.href='MetodosProductoPedidos/GenerarReporteProductoPedidos.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" x2="12" y1="15" y2="3"></line>
                        </svg>
                        Generar Reporte
                    </button>

                </div>
                <ul class="space-y-2">
                    <?php
                    if (!empty($topSellingProducts)) {
                        foreach ($topSellingProducts as $productName => $productDetails) {
                            echo "<li>
                                    <div class='flex items-center justify-between'>
                                        <span>{$productName}</span>
                                        <span class='font-medium'>{$productDetails['quantity']} unidades</span>
                                    </div>
                                    <div class='text-gray-600 text-sm'>Última venta: {$productDetails['lastSoldDate']}</div>
                                  </li>";
                        }
                    } else {
                        echo "<li class='text-red-500'>No se encontraron productos vendidos</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    </div>
</body>

</html>