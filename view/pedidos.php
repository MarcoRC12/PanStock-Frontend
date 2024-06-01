<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar los pedidos</title>
    <link rel="icon" href="../img/logo-app.jpg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
</head>
<body>
    <?php include('menu.php'); ?>
    <div class="flex-1 p-6">
      <h1 class="text-6xl text-yellow-800 mb-1 oleo-script">Pedidos</h1>
      <div class="mt-4 flex justify-end mb-6">
        <button class="custom-bg text-white px-4 py-2 rounded-md">Crear pedido</button>
      </div>
      <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-bold mb-4">Lista de pedidos</h2>
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-200">
              <th class="px-4 py-2 text-left">Número de pedido</th>
              <th class="px-4 py-2 text-left">Descripción</th>
              <th class="px-4 py-2 text-right">Precio unitario</th>
              <th class="px-4 py-2 text-right">Subtotal</th>
              <th class="px-4 py-2 text-right">Total</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border-b px-4 py-2">ORD001</td>
              <td class="border-b px-4 py-2">Venta de productos de oficina</td>
              <td class="border-b px-4 py-2 text-right">$50.99</td>
              <td class="border-b px-4 py-2 text-right">$255.95</td>
              <td class="border-b px-4 py-2 text-right">$255.95</td>
              <td class="border-b px-4 py-2 text-center">
                <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 mr-2">Editar</button>
                <button class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Eliminar</button>
              </td>
            </tr>
            <tr>
              <td class="border-b px-4 py-2">ORD002</td>
              <td class="border-b px-4 py-2">Venta de artículos de limpieza</td>
              <td class="border-b px-4 py-2 text-right">$25.50</td>
              <td class="border-b px-4 py-2 text-right">$153.00</td>
              <td class="border-b px-4 py-2 text-right">$153.00</td>
              <td class="border-b px-4 py-2 text-center">
                <button class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 mr-2">Editar</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Eliminar</button>
              </td>
            </tr>
            <tr>
              <td class="border-b px-4 py-2">ORD003</td>
              <td class="border-b px-4 py-2">Venta de equipos de cómputo</td>
              <td class="border-b px-4 py-2 text-right">$1200.00</td>
              <td class="border-b px-4 py-2 text-right">$3600.00</td>
              <td class="border-b px-4 py-2 text-right">$3600.00</td>
              <td class="border-b px-4 py-2 text-center">
                <button class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 mr-2">Editar</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>