<?php

include '../../class/InventarioConexion.php';
include '../../class/ProductosConexion.php';

//Capturar id de inventario
$inventario_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($inventario_id) {
    // Obtener los datos de inventario
    $inventario_data = BuscarInventario($inventario_id);

    if ($inventario_data && $inventario_data['Status'] == 200) {
        $invetario = $inventario_data['Detalle'][0]; //Acceder al elemento array
    } else {
        die('Error al obtener los datos de inventario');
    }
} else {
    die('id de inventario no proporcionado');
}

//Listar Productos
$data_products = ListarProductos();

//Procesar la solicitud PUT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    // Obtener los datos
    $proid = $_POST['pro_id'];
    $invcantidadtotal = $_POST['inv_cantidad_total'];
    $invcantidaddisponible = $_POST['inv_cantidad_disponible'];
    $invfechaadquisicion = $_POST['inv_fecha_adquisicion'];

    $resultado = ModificarInventario($inventario_id, $proid, $invcantidadtotal, $invcantidaddisponible, $invfechaadquisicion);

    // Asegurarse de que solo se envíe un JSON en la respuesta
    header('Content-Type: application/json');
    echo json_encode($resultado);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar invetario del producto</title>
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
                <h1 class="text-5xl tracking-tighter oleo-script">Editar Inventario del producto</h1>
            </div>
            <form id="editInventoryForm" class="bg-white shadow-md rounded-lg p-6 space-y-2" method="POST" action="">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="inv_id" value="<?= htmlspecialchars($inventario_id) ?>">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="producto">Producto</label>
                    <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="pro_id" name="pro_id" required>
                        <?php foreach ($data_products["Detalle"] as $proid) : ?>
                            <option value="<?= htmlspecialchars($proid["pro_id"]) ?>" <?= (isset($invetario["pro_id"]) && $invetario['pro_id'] == $proid['pro_id']) ? 'selected' : '' ?>><?= htmlspecialchars($proid['pro_nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="lastName">Cantidad Total</label>
                    <input type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="invcantidadtotal" name="inv_cantidad_total" value="<?= htmlspecialchars($invetario['inv_cantidad_total'] ?? '') ?>" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="dni">Cantidad Disponible</label>
                    <input type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="invcantidaddisponible" name="inv_cantidad_disponible" value="<?= htmlspecialchars($invetario['inv_cantidad_disponible'] ?? '') ?>" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="phone">Fecha de adquisición</label>
                    <input type="date" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="invfechaadquisicion" name="inv_fecha_adquisicion" value="<?= htmlspecialchars($invetario['inv_fecha_adquisicion'] ?? '') ?>" required />
                </div>
                <div class="flex justify-end pt-4">
                    <button type="button" class="mr-2 bg-red-600 text-white px-4 py-2 rounded-md" onclick="inventario()">Cancelar</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Modificar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../lib/alertifyjs/alertify.js"></script>
    <script>
        function inventario() {
            window.location.href = '../inventario.php';
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editInventoryForm').addEventListener('submit', function(event) {
                event.preventDefault();
                var form = event.target;

                var formData = new FormData(form);
                var queryString = new URLSearchParams(formData).toString(); // Serializar datos

                var xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true); // Mantener POST
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (xhr.status === 200 && response.Status === 200) {
                                alertify.success('Datos actualizados');
                                window.location.href = '../inventario.php';
                            } else {
                                alertify.error('Error al actualizar los datos');
                            }
                        } catch (e) {
                            console.error('Error al parsear la respuesta:', xhr.responseText);
                            alertify.error('Error al procesar la solicitud');
                        }
                    }
                };
                xhr.send(queryString + '&_method=PUT'); // Añadir _method=PUT
            });
        });
    </script>
</body>

</html>