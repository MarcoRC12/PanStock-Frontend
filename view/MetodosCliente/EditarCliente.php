<?php

include '../../class/ClientesConexion.php';
include '../../class/TipoDocumento.php';

// Capturar ID del cliente
$cliente_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($cliente_id) {
    // Obtener los datos del cliente
    $cliente_data = BuscarCliente($cliente_id);

    if ($cliente_data && $cliente_data['Status'] == 200) {
        $cliente = $cliente_data['Detalle'][0]; // Acceder al primer elemento del array
    } else {
        // Manejar error si no se pueden obtener los datos del cliente
        die("Error al obtener los datos del cliente.");
    }
} else {
    // Manejar error si no se proporciona ID del cliente
    die("ID de cliente no proporcionado.");
}

// Verificar si se ha enviado un formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $cliente_id = $_POST['cl_id'];
    $nombre = $_POST['cl_nombre'];
    $apellido = $_POST['cl_apellido'];
    $documento = $_POST['cl_documento'];
    $td_id = $_POST['td_id'];
    $telefono = $_POST['cl_telefono'];
    $email = $_POST['cl_email'];

    // Realizar la solicitud PUT para editar el cliente
    $resultado = EditarCliente($cliente_id, $nombre, $apellido, $documento, $td_id, $telefono, $email);

    // Verificar si la solicitud fue exitosa
    if ($resultado && isset($resultado['Status']) && $resultado['Status'] == 200) {
        // Mostrar mensaje de éxito con Alertify
        echo "<script>
                alertify.success('Datos actualizados');
              </script>";
        // Redireccionar a la página de clientes después de unos segundos
        echo "<script>
                setTimeout(function() {
                  window.location.href = '../clientes.php';
                }, 3000);
              </script>";
    } else {
        // Mostrar mensaje de error con Alertify
        echo "<script>
                alertify.error('Error al editar el cliente');
              </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cliente</title>
    <link rel="icon" href="../../img/logo-app.jpg">
    <link rel="stylesheet" type="text/css" href="../../lib/alertifyjs/css/alertify.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
</head>

<body>
    <style>
        body {
            background-color: #D9C39C;
        }

        .oleo-script {
            font-family: 'Oleo Script', cursive;
        }
    </style>
    <div class="flex w-full max-w-5xl items-center justify-between gap-8 px-4 py-12 md:px-6 lg:px-8">
        <div class="hidden w-full max-w-md items-center justify-center lg:flex">
            <img src="../../img/logo-app-fondoBlanco.jpg" width="200" height="200" alt="Company Logo" class="max-w-[200px]" style="aspect-ratio: 200 / 200; object-fit: cover;" />
        </div>
        <div class="w-full max-w-md space-y-2">
            <div class="space-y-2">
                <h1 class="text-5xl tracking-tighter oleo-script">Editar Cliente</h1>
            </div>
            <form class=" bg-white shadow-md rounded-lg p-6 space-y-2" method="POST" action="actualizarCliente.php">
                <input type="hidden" name="cl_id" value="<?= htmlspecialchars($cliente_id) ?>">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="firstName">
                            Nombre
                        </label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="firstName" name="cl_nombre" value="<?= htmlspecialchars($cliente['cl_nombre'] ?? '') ?>" required />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="lastName">
                            Apellido
                        </label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="lastName" name="cl_apellido" placeholder="Doe" value="<?= htmlspecialchars($cliente['cl_apellido'] ?? '') ?>" required />
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="td_id">
                        Tipo de documento
                    </label>
                    <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="td_id" name="td_id" required>
                        <?php foreach ($data_tdocumento["Detalle"] as $td) : ?>
                            <option value="<?= htmlspecialchars($td["td_id"]) ?>" <?= (isset($cliente['td_id']) && $cliente['td_id'] == $td['td_id']) ? 'selected' : '' ?>><?= htmlspecialchars($td["td_nombre"]) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="dni">
                        DNI
                    </label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="dni" name="cl_documento" value="<?= htmlspecialchars($cliente['cl_documento'] ?? '') ?>" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="phone">
                        Telefono
                    </label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="phone" name="cl_telefono" type="tel" value="<?= htmlspecialchars($cliente['cl_telefono'] ?? '') ?>" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">
                        Email
                    </label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="email" name="cl_email" type="email" value="<?= htmlspecialchars($cliente['cl_email'] ?? '') ?>" required />
                </div>
                <div class="flex justify-end pt-4">
                    <button type="button" class="mr-2 bg-red-600 text-white px-4 py-2 rounded-md" onclick="clientes()">Cancelar</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Modificar</button>
                </div>
                <div class="space-y-2"></div>
            </form>
        </div>
    </div>
    <script>
        function clientes() {
            window.location.href = '../clientes.php';
        }
    </script>
</body>

</html>