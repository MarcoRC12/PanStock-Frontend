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
            <button class="custom-bg text-white px-4 py-2 rounded-md" onclick="showForm()">Crear producto</button>
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
                        <button class='bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 mr-2' onclick='editProduct({$product["pro_id"]})'>Editar</button>
                            <button class='bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700' onclick='deleteProduct({$product["pro_id"]})'>Eliminar</button>
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