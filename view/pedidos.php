<?php

include '../class/PedidosConexion.php';

$data = ListarPedidos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestionar los pedidos</title>
  <link rel="icon" href="../img/logo-app.jpg">
  <link rel="stylesheet" type="text/css" href="../lib/alertifyjs/css/alertify.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/TableContainer.css">
</head>

<body>
  <?php include('menu.php'); ?>
  <div class="flex-1 p-6">
    <h1 class="text-6xl text-yellow-800 mb-1 oleo-script">Pedidos</h1>
    <div class="mt-4 flex justify-end mb-3">
      <button class="custom-bg text-white px-4 py-2 rounded-md">Crear pedido</button>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-lg font-bold mb-2">Lista de pedidos</h2>
      <div class="table-container">
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-200">
              <th class="px-4 py-2 text-left">#</th>
              <th class="px-4 py-2 text-left">Cliente</th>
              <th class="px-4 py-2 text-left">Número de pedido</th>
              <th class="px-4 py-2 text-left">Direccióm</th>
              <th class="px-4 py-2 text-left">Fecha de entrega</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($data && isset($data['Status']) && $data['Status'] == 200 && isset($data['Detalle'])) {
              $orders = $data['Detalle'];
              foreach ($orders as $order) {
                echo "<tr>
                        <td class='border-b px-4 py-2'>{$order['pe_id']}</td>
                        <td class='border-b px-4 py-2'>{$order['cl_nombre']} {$order['cl_apellido']}</td>
                        <td class='border-b px-4 py-2'>{$order['pe_numero']}</td>
                        <td class='border-b px-4 py-2'>{$order['pe_direccion']}</td>
                        <td class='border-b px-4 py-2'>{$order['pe_fechaentrega']}</td>
                        <td class='border-b px-4 py-2 text-center'>
                        <button class='bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 mr-2' onclick='showForm()'>Editar</button>
                            <button class='bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700' onclick='deleteOrder({$order["pe_id"]})'>Eliminar</button>
                        </td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='6' class='text-center text-red-500'>No se encontraron pedidos</td></tr>";
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
</body>

</html>