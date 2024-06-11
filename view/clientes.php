<?php

include '../class/ClientesConexion.php';
include '../class/TipoDocumento.php';

// Metodo Registrar Cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
  // Obtener los datos del formulario
  $nombre = $_POST['cl_nombre'];
  $apellido = $_POST['cl_apellido'];
  $documento = $_POST['cl_documento'];
  $td_id = $_POST['td_id'];
  $telefono = $_POST['cl_telefono'];
  $email = $_POST['cl_email'];

  // Llamar a la función para crear un nuevo cliente
  $resultado = CrearClientes($nombre, $apellido, $documento, $td_id, $telefono, $email);

  // Asegurarse de que solo se envíe un JSON en la respuesta
  header('Content-Type: application/json');
  echo json_encode($resultado);
  exit();
}

// Manejar la eliminación del cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
  $id = $_POST['cl_id'];
  $resultado = Delete($id);

  header('Content-Type: application/json');
  echo json_encode($resultado);
  exit();
}

// Obtener la lista de clientes
$data = ListarClientes();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administra tus clientes</title>
  <link rel="icon" href="../img/logo-app.jpg">
  <link rel="stylesheet" type="text/css" href="../lib/alertifyjs/css/alertify.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/TableContainer.css">
</head>

<body>
  <?php include 'menu.php'; ?>
  <div class="flex-1 p-6">
    <h1 class="text-6xl text-yellow-800 mb-1 oleo-script">Clientes</h1>
    <div class="mt-4 flex justify-end mb-3">
      <button class="custom-bg text-white px-4 py-2 rounded-md" onclick="showForm()">Crear nuevo cliente</button>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-lg font-bold mb-2">Lista de clientes</h2>
      <div class="table-container">
        <table class="w-full table-auto">
          <thead class="sticky top-0">
            <tr class="bg-gray-200">
              <th class="px-4 py-2 text-left">#</th>
              <th class="px-4 py-2 text-left">Nombre & Apellido</th>
              <th class="px-4 py-2 text-left">DNI</th>
              <th class="px-4 py-2 text-left">Telefono</th>
              <th class="px-4 py-2 text-left">Email</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($data && isset($data['Status']) && $data['Status'] == 200 && isset($data['Detalle'])) {
              $clients = $data['Detalle'];
              foreach ($clients as $client) {
                $clientData = htmlspecialchars(json_encode($client), ENT_QUOTES, 'UTF-8');
                echo "<tr>
                        <td class='border-b px-4 py-2'>{$client['cl_id']}</td>
                        <td class='border-b px-4 py-2'>{$client['cl_nombre']} {$client['cl_apellido']}</td>
                        <td class='border-b px-4 py-2'>{$client['cl_documento']}</td>
                        <td class='border-b px-4 py-2'>{$client['cl_telefono']}</td>
                        <td class='border-b px-4 py-2'>{$client['cl_email']}</td>
                        <td class='border-b px-4 py-2 text-center'>
                        <button class='bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 mr-2' onclick='editClient({$client["cl_id"]})'>Editar</button>
                        <button class='bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700' onclick='deleteClient({$client["cl_id"]})'>Eliminar</button>
                        </td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='6' class='text-center text-red-500'>No se encontraron clientes</td></tr>";
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
  <script src="../js/eliminarcliente.js"></script>
  <script>
    function editClient(id) {
      window.location.href = 'MetodosCliente/EditarCliente.php?id=' + id;
    }
  </script>
  <?php include 'MetodosCliente/CrearCliente.php'; ?>
</body>

</html>