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
            <button class="custom-bg text-white px-4 py-2 rounded-md" onclick="showForm()">Registrar</button>
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
                                echo "<tr>
                        <td class='border-b px-4 py-2'>{$inventory['inv_id']}</td>
                        <td class='border-b px-4 py-2'>{$inventory['pro_nombre']}</td>
                        <td class='border-b px-4 py-2'>{$inventory['inv_cantidad_total']}</td>
                        <td class='border-b px-4 py-2'>{$inventory['inv_cantidad_disponible']}</td>
                        <td class='border-b px-4 py-2'>{$inventory['inv_fecha_adquisicion']}</td>
                        <td class='border-b px-4 py-2 text-center'>
                        <button class='bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 mr-2' onclick='editInventory({$inventory["inv_id"]})'>Editar</button>
                            <button class='bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700' onclick='deleteInventory({$inventory["inv_id"]})'>Eliminar</button>
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
        function editInventory(id){
            window.location.href = 'MetodosInventario/EditarInventario.php?id=' + id;
        }
    </script>
    <?php include 'MetodosInventario/RegistarInventario.php' ?>
</body>

</html>