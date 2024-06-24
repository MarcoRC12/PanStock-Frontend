<?php

include '../class/ProductosConexion.php';
include '../class/TipoProductos.php';

//Metodo POST para productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    //Obtener los datos
    $pronombre = $_POST['pro_nombre'];
    $prodescripcion = $_POST['pro_descripcion'];
    $tproid = $_POST['tpro_id'];
    $promarca = $_POST['pro_marca'];
    $proimagen = $_POST['pro_imagen'];

    //Llamar a la funcion para crear un nuevo producto
    $resultado = CrearProducto($pronombre, $prodescripcion, $tproid, $promarca, $proimagen);

    //Asegurar que solo se envie en JSON la respuesta
    header('Content-Type: application/json');
    echo json_encode($resultado);
    exit();
}

// Manejar la eliminación del producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['pro_id'];
    $resultado = EliminarProducto($id);

    header('Content-Type: application/json');
    echo json_encode($resultado);
    exit();
}

//Listar productos
$data = ListarProductos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administra los productos los productos</title>
    <link rel="icon" href="../img/logo-app.jpg">
    <link rel="stylesheet" type="text/css" href="../lib/alertifyjs/css/alertify.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/TableContainer.css">
</head>

<body>
    <?php include('menu.php'); ?>
    <div class="flex-1 p-6">
        <h1 class="text-6xl text-yellow-800 mb-1 oleo-script">Productos</h1>
        <div class="mt-4 flex justify-end mb-3">
            <button class="custom-bg inline-flex items-center justify-center text-white px-4 py-2 rounded-md" onclick="showForm()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                    <path d="M5 12h14"></path>
                    <path d="M12 5v14"></path>
                </svg>
                Registrar nuevo producto
            </button>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-bold mb-2">Lista de productos</h2>
            <div class="table-container">
                <table class="w-full table-auto">
                    <thead class="sticky top-0">
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Tipo producto</th>
                            <th class="px-4 py-2 text-left">Marca</th>
                            <th class="px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data && isset($data['Status']) && $data['Status'] == 200 && isset($data['Detalle'])) {
                            $products = $data['Detalle'];
                            foreach ($products as $product) {
                                echo "<tr>
                        <td class='border-b px-4 py-2'>{$product['pro_id']}</td>
                        <td class='border-b px-4 py-2'>{$product['pro_nombre']}</td>
                        <td class='border-b px-4 py-2'>{$product['tpro_nombre']}</td>
                        <td class='border-b px-4 py-2'>{$product['pro_marca']}</td>
                        <td class='border-b px-4 py-2 text-center'>
                        <button class='bg-yellow-400 text-black px-4 py-2 rounded-md hover:bg-yellow-500 mr-2' onclick='editProduct({$product["pro_id"]})'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='h-4 w-4'>
                                    <path d='M12 22h6a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v10'></path>
                                    <path d='M14 2v4a2 2 0 0 0 2 2h4'></path>
                                    <path d='M10.4 12.6a2 2 0 1 1 3 3L8 21l-4 1 1-4Z'></path>
                                </svg>
                        </button>
                            <button class='bg-red-700 inline-flex items-center justify-center text-white px-4 py-2 rounded-md hover:bg-red-800' onclick='deleteProduct({$product["pro_id"]})'>
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
                            echo "<tr><td colspan='6' class='text-center text-red-500'>No se encontraron productos</td></tr>";
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
    <script src="../js/eliminarproducto.js"></script>
    <script>
        function editProduct(id) {
            window.location.href = 'MetodosProductos/EditarProducto.php?id=' + id;
        }
    </script>
    <?php include 'MetodosProductos/CrearProducto.php' ?>
</body>

</html>