<?php
include '../../class/PedidosConexion.php';
include '../../class/ProductoPedidosConexion.php';
include '../../class/ClientesConexion.php';
include '../../class/ProductosConexion.php';

// Verificar si se ha enviado el documento
if (isset($_GET['documento'])) {
    $documento = $_GET['documento'];
    BuscarClienteDocumento($documento);
    exit;
}

// Listar Productos
$data_products = ListarProductos();

// Capturar ID del pedido
$pedido_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($pedido_id) {
    // Obtener los datos del pedido
    $pedido_data = BuscarPedido($pedido_id);

    if ($pedido_data && $pedido_data['Status'] == 200) {
        $pedido = $pedido_data['Detalle'][0]; // Acceder al primer elemento del array
    } else {
        // Manejar error si no se pueden obtener los datos del pedido
        die("Error al obtener los datos del pedido.");
    }

    /*
    // Obtener los productos del pedido
    $productos_pedido_data = BuscarProductoPedidos($pedido_id);

    if ($productos_pedido_data && $productos_pedido_data['Status'] == 200) {
        $productos_pedido = $productos_pedido_data['Detalle'][0];
    } else {
        // Manejar error si no se pueden obtener los datos de los productos del pedido
        die("Error al obtener los datos de los productos del pedido.");
    }*/
} else {
    // Manejar error si no se proporciona ID del pedido
    die("ID de pedido no proporcionado.");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pedido</title>
    <link rel="icon" href="../../img/logo-app.jpg">
    <link rel="stylesheet" type="text/css" href="../../lib/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../../lib/alertifyjs/css/themes/default.css">
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
    <script>
        function actualizarTotal() {
            var tableBody = document.querySelector('table tbody');
            var rows = tableBody.querySelectorAll('tr');
            var total = 0;

            rows.forEach(function(row) {
                var precioTotal = parseFloat(row.cells[5].innerText);
                total += precioTotal;
            });

            document.getElementById('pe_preciototal').value = total.toFixed(2);
        }

        function buscarCliente() {
            var documento = document.getElementById('cl_documento').value;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'RegistrarPedido.php?documento=' + documento, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.Status === 200 && response.Detalle.length > 0) {
                                var cliente = response.Detalle[0];
                                document.getElementById('cl_id').value = cliente.cl_id;
                                alertify.success('Cliente encontrado');
                            } else {
                                alertify.error('Cliente no encontrado');
                            }
                        } catch (e) {
                            console.error('Error al parsear JSON:', e);
                            console.error('Respuesta del servidor:', xhr.responseText);
                            alertify.error('Error al procesar la respuesta del servidor.');
                        }
                    } else {
                        console.error('Error en la solicitud AJAX:', xhr.status, xhr.statusText);
                        alertify.error('Error en la solicitud AJAX.');
                    }
                }
            };
            xhr.send();
        }

        function pedidos() {
            window.location.href = '../pedidos.php';
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('productorderForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var productoSelect = document.getElementById('pro_id');
                var productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
                var productoId = productoSelect.value;
                var numOrden = document.getElementById('prope_numorden').value;
                var descripcion = document.getElementById('prope_descripcion').value;
                var cantidad = document.getElementById('prope_cantidad').value;
                var precioUnitario = document.getElementById('prope_precio').value;
                var precioTotal = (cantidad * precioUnitario).toFixed(2);

                var tableBody = document.querySelector('table tbody');
                var row = document.createElement('tr');
                row.id = productoId;
                row.dataset.orderNumber = numOrden;
                row.dataset.description = descripcion;

                row.innerHTML = `
                    <td class="h-12 px-4 text-left align-middle hidden">${productoId}</td>
                    <td class="h-12 px-4 text-left align-middle">${productoNombre}</td>
                    <td class="h-12 px-4 text-left align-middle hidden">${numOrden}</td>
                    <td class="h-12 px-4 text-left align-middle">${precioUnitario}</td>
                    <td class="h-12 px-4 text-left align-middle">${cantidad}</td>
                    <td class="h-12 px-4 text-left align-middle">${precioTotal}</td>
                    <td class="h-12 px-4 text-left align-middle hidden">${descripcion}</td>
                    <td class="h-12 px-4 text-left align-middle">
                        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="removeRow(this)">
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='h-4 w-4'>
                                <path d='M3 6h18'></path>
                                <path d='M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6'></path>
                                <path d='M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2'></path>
                            </svg>
                        </button>
                    </td>
                `;

                tableBody.appendChild(row);
                actualizarTotal();
                hideForm();
            });
        });

        function removeRow(button) {
            button.closest('tr').remove();
            actualizarTotal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editpedidosForm').addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('ajax', true);

                var productos = [];
                document.querySelectorAll('table tbody tr').forEach(function(row) {
                    var producto = {
                        pro_id: row.id,
                        prope_numorden: row.dataset.orderNumber,
                        prope_descripcion: row.dataset.description,
                        prope_cantidad: row.cells[4].innerText,
                        prope_precio: row.cells[3].innerText
                    };
                    productos.push(producto);
                });

                formData.append('productos', JSON.stringify(productos));

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'RegistrarPedido.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                var response = JSON.parse(xhr.responseText);
                                if (response.Status === 200) {
                                    alertify.success(response.Message);
                                    setTimeout(function() {
                                        window.location.href = '../pedidos.php';
                                    }, 2000);
                                } else {
                                    alertify.error(response.Message);
                                    if (response.Errores) {
                                        response.Errores.forEach(function(error) {
                                            alertify.error(error);
                                        });
                                    }
                                }
                            } catch (e) {
                                console.error('Error al parsear JSON:', e);
                                console.error('Respuesta del servidor:', xhr.responseText);
                                alertify.error('Error al procesar la respuesta del servidor.');
                            }
                        } else {
                            console.error('Error en la solicitud AJAX:', xhr.status, xhr.statusText);
                            alertify.error('Error en la solicitud AJAX.');
                        }
                    }
                };
                xhr.send(formData);
            });

        });
    </script>
    <div class="flex w-full max-w-5xl items-center justify-between gap-8 px-4 py-12 md:px-6 lg:px-8">
        <div class="hidden w-full max-w-md items-center justify-center lg:flex">
            <img src="../../img/logo-app-fondoBlanco.jpg" width="200" height="200" alt="Company Logo" class="max-w-[200px]" style="aspect-ratio: 200 / 200; object-fit: cover;" />
        </div>
        <div class="w-full max-w-lg space-y-2">
            <div class="relative bg-white rounded-lg border bg-card text-card-foreground shadow-sm w-full p-6">
                <div class="flex flex-col space-y-1.5 mb-4">
                    <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Modificar Pedido</h3>
                </div>
                <form id="editpedidosForm" method="post">
                    <input type="hidden" name="pe_id" value="<?= htmlspecialchars($pedido_id) ?>">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="cl_documento" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Cliente</label>
                            <div class="flex space-x-2">
                                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="text" id="cl_documento" name="cl_documento" value="<?= htmlspecialchars($pedido['cl_documento'] ?? '') ?>" required />
                                <input type="hidden" id="cl_id" name="cl_id" value="<?= htmlspecialchars($pedido['cl_id'] ?? '') ?>" readonly />
                                <button type="button" class="bg-yellow-500 text-white px-4 py-2 rounded-md" onclick="event.preventDefault(); buscarCliente();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground">
                                        <circle cx="9" cy="9" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="pe_numero">Número de pedido</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="number" id="pe_numero" name="pe_numero" value="<?= htmlspecialchars($pedido['pe_numero'] ?? '') ?>" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="pe_direccion">Dirección de Entrega</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="text" id="pe_direccion" name="pe_direccion" value="<?= htmlspecialchars($pedido['pe_direccion'] ?? '') ?>" required />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="pe_fechaentrega">Fecha de entrega</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="date" id="pe_fechaentrega" name="pe_fechaentrega" value="<?= htmlspecialchars($pedido['pe_fechaentrega'] ?? '') ?>" required />
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium">Productos</h3>
                        <button type="button" class="inline-flex items-center justify-center whitespace-nowrap text-white font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-blue-500 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3" onclick="showForm()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                <path d="M5 12h14"></path>
                                <path d="M12 5v14"></path>
                            </svg>
                            Agregar Producto
                        </button>
                    </div>
                    <div class="relative w-full overflow-auto">
                        <table class="w-full caption-bottom text-sm">
                            <thead class="[&amp;_tr]:border-b">
                                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden [&amp;:has([role=checkbox])]:pr-0">ID Producto</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">Producto</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden [&amp;:has([role=checkbox])]:pr-0">Numero de orden</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">Precio Unitario</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">Cantidad</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">Precio Total</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden [&amp;:has([role=checkbox])]:pr-0">Descripción</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0"></th>
                                </tr>
                            </thead>
                            <tbody class="[&amp;_tr:last-child]:border-0">
                                <?php foreach ($productos_pedido as $producto) : ?>
                                    <tr id="<?php echo $producto['pro_id']; ?>" data-order-number="<?php echo $producto['prope_numorden']; ?>" data-description="<?php echo $producto['prope_descripcion']; ?>">
                                        <td class="h-12 px-4 text-left align-middle hidden"><?php echo htmlspecialchars($producto['pro_id']); ?></td>
                                        <td class="h-12 px-4 text-left align-middle"><?php echo htmlspecialchars($producto['pro_nombre']); ?></td>
                                        <td class="h-12 px-4 text-left align-middle hidden"><?php echo htmlspecialchars($producto['prope_numorden']); ?></td>
                                        <td class="h-12 px-4 text-left align-middle"><?php echo htmlspecialchars($producto['prope_precio']); ?></td>
                                        <td class="h-12 px-4 text-left align-middle"><?php echo htmlspecialchars($producto['prope_cantidad']); ?></td>
                                        <td class="h-12 px-4 text-left align-middle"><?php echo htmlspecialchars($producto['prope_precio'] * $producto['prope_cantidad']); ?></td>
                                        <td class="h-12 px-4 text-left align-middle hidden"><?php echo htmlspecialchars($producto['prope_descripcion']); ?></td>
                                        <td class="h-12 px-4 text-left align-middle">
                                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="removeRow(this)">
                                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='h-4 w-4'>
                                                    <path d='M3 6h18'></path>
                                                    <path d='M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6'></path>
                                                    <path d='M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2'></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <label for="pe_preciototal" class="block text-gray-700">Precio Total S/. </label>
                        <input type="number" step="0.01" id="pe_preciototal" name="pe_preciototal" value="<?= htmlspecialchars($pedido['pe_preciototal'] ?? '') ?>" readonly />
                    </div>
                    <div class="flex justify-end pt-4">
                        <button type="button" class="mr-2 bg-red-500 text-white px-4 py-2 rounded-md" onclick="pedidos()">Cancelar</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
                    </div>
                </form>
                <?php include 'RegistarProductoPedidos.php'; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../lib/alertifyjs/alertify.js"></script>
</body>

</html>