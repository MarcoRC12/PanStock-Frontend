<?php

include '../class/InventarioConexion.php';
include '../class/ProductosConexion.php';

//Metodo POST para inventario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    //Obtener los datos
    $proid = $_POST['pro_id'];
    $invcantidadtotal = $_POST['inv_cantidad_total'];
    $invcantidaddisponible = $_POST['inv_cantidad_disponible'];
    $invfechaadquisicion = $_POST['inv_fecha_adquisicion'];

    //Llamar a la funcion para crear un nuevo registro
    $resultado = CrearInventario($proid, $invcantidadtotal, $invcantidaddisponible, $invfechaadquisicion);

    //Asegurar que solo se envie en JSON la respuesta
    header('Content-Type: application/json');
    echo json_encode($resultado);
    exit();
}

// Manejar la eliminación del inventario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['inv_id'];
    $resultado = EliminarInvetario($id);

    header('Content-Type: application/json');
    echo json_encode($resultado);
    exit();
}

// Listar Inventario
$data = ListarInventario();

//Listar Productos
$data_products = ListarProductos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administra el inventario de los productos</title>
    <link rel="icon" href="../img/logo-app.jpg">
    <link rel="stylesheet" type="text/css" href="../lib/alertifyjs/css/alertify.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/TableContainer.css">
</head>

<body>
    <?php include('menu.php'); ?>
    <div class="flex-1 p-6">
        <h1 class="text-6xl text-yellow-800 mb-1 oleo-script">Inventario</h1>
        <div class="mt-4 flex justify-end mb-3">
            <button class="custom-bg inline-flex items-center justify-center text-white px-4 py-2 rounded-md" onclick="showForm()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                    <path d="M5 12h14"></path>
                    <path d="M12 5v14"></path>
                </svg>
                Registrar
            </button>
            <button class="custom-bg inline-flex items-center justify-center text-white px-4 py-2 rounded-md ml-2" onclick="window.location.href='MetodosInventario/GenerarReporteInventario.php'">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" x2="12" y1="15" y2="3"></line>
                </svg>
                Generar Reporte
            </button>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-bold mb-2">Inventario de la panaderia</h2>
            <div class="table-container">
                <table class="w-full table-auto">
                    <thead class="sticky top-0">
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Producto</th>
                            <th class="px-4 py-2 text-left">Cantidad Total</th>
                            <th class="px-4 py-2 text-left">Cantidad Disponible</th>
                            <th class="px-4 py-2 text-left">Fecha de adquisición</th>
                            <th class="px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data && isset($data['Status']) && $data['Status'] == 200 && isset($data['Detalle'])) {
                            $inventories = $data['Detalle'];
                            foreach ($inventories as $inventory) {
                                $rowClass = ($inventory['inv_cantidad_disponible'] < 8) ? 'bg-red-300' : '';
                                $boldClass = ($inventory['inv_cantidad_disponible'] < 8) ? 'font-bold' : '';
                                echo "<tr class='{$rowClass}'>
                        <td class='border-b px-4 py-2'>{$inventory['inv_id']}</td>
                        <td class='border-b px-4 py-2'>{$inventory['pro_nombre']}</td>
                        <td class='border-b px-4 py-2'>{$inventory['inv_cantidad_total']}</td>
                        <td class='border-b px-4 py-2 {$boldClass}'>{$inventory['inv_cantidad_disponible']}</td>
                        <td class='border-b px-4 py-2'>{$inventory['inv_fecha_adquisicion']}</td>
                        <td class='border-b px-4 py-2 text-center'>
                        <button class='bg-yellow-400 text-black px-4 py-2 rounded-md hover:bg-yellow-500 mr-2' onclick='editInventory({$inventory["inv_id"]})'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='h-4 w-4'>
                                    <path d='M12 22h6a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v10'></path>
                                    <path d='M14 2v4a2 2 0 0 0 2 2h4'></path>
                                    <path d='M10.4 12.6a2 2 0 1 1 3 3L8 21l-4 1 1-4Z'></path>
                                </svg>
                        </button>
                            <button class='bg-red-700 inline-flex items-center justify-center text-white px-4 py-2 rounded-md hover:bg-red-800' onclick='deleteInventory({$inventory["inv_id"]})'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='h-4 w-4'>
                                    <path d='M3 6h18'></path>
                                    <path d='M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6'></path>
                                    <path d='M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2'></path>
                                </svg>
                            </button>
                        </td>
                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center text-red-500'>No se encontro registro</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <script src="../lib/alertifyjs/alertify.js"></script>
    <script src="../lib/jquery-3.7.1.min.js"></script>
    <script src="../js/eliminarinventario.js"></script>
    <script>
        function editInventory(id) {
            window.location.href = 'MetodosInventario/EditarInventario.php?id=' + id;
        }
    </script>
    <?php include 'MetodosInventario/RegistarInventario.php' ?>
</body>

</html>