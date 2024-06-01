<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administra tus clientes</title>
    <link rel="icon" href="../img/logo-app.jpg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
</head>
<body>
<?php include('menu.php'); ?>
    <div class="flex-1 p-6">
        <h1 class="text-6xl text-yellow-800 mb-1 oleo-script">Clientes</h1>
        <div class="mt-4 flex justify-end mb-6">
            <button class="custom-bg text-white px-4 py-2 rounded-md">Crear cliente</button>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-bold mb-4">Lista de clientes</h2>
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-200">
              <th class="px-4 py-2 text-left">#</th>
              <th class="px-4 py-2 text-left">Nombre & Apellido</th>
              <th class="px-4 py-2 text-right">DNI</th>
              <th class="px-4 py-2 text-right">Telefono</th>
              <th class="px-4 py-2 text-right">Email</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $response = file_get_contents('../class/ClientesConexion.php');
            $data = json_decode($response, true);
            
            if ($data && isset($data['Status']) && $data['Status'] == 200 && isset($data['Detalle'])) {
                $clients = $data['Detalle'];
                foreach ($clients as $client) {
                    echo "<tr>
                            <td class='border-b px-4 py-2'>{$client['cl_id']}</td>
                            <td class='border-b px-4 py-2'>{$client['cl_nombre']} {$client['cl_apellido']}</td>
                            <td class='border-b px-4 py-2 text-right'>{$client['cl_dni']}</td>
                            <td class='border-b px-4 py-2 text-right'>{$client['cli_numero']}</td>
                            <td class='border-b px-4 py-2 text-right'>{$client['cli_email']}</td>
                            <td class='border-b px-4 py-2 text-center'>
                                <button class='bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 mr-2'>Editar</button>
                                <button class='bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700'>Eliminar</button>
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
</body>
</html>