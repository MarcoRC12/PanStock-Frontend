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

//Listar Productos
$data_products = ListarProductos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear Pedido
    $clid = $_POST['cl_id'];
    $penumero = $_POST['pe_numero'];
    $pedireccion = $_POST['pe_direccion'];
    $pefechaentrega = $_POST['pe_fechaentrega'];
    $pepreciototal = $_POST['pe_preciototal'];

    $response = CrearPedido($clid, $penumero, $pedireccion, $pefechaentrega, $pepreciototal);

    if ($response['Status'] === 200) {
        $peid = $response['id'];

        // Crear ProductoPedidos
        foreach ($_POST['productos'] as $producto) {
            CrearProductoPedidos(
                $producto['pro_id'],
                $peid,
                $producto['prope_numorden'],
                $producto['prope_descripcion'],
                $producto['prope_cantidad'],
                0, // Suponiendo que la cantidad entregada inicialmente es 0
                $producto['prope_precio']
            );
        }

        echo "<script>alertify.success('Pedido y productos registrados exitosamente');</script>";
    } else {
        echo "<script>alertify.error('Error al registrar el pedido');</script>";
    }
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

        function showForm() {
            // Aquí puedes agregar la lógica para mostrar el formulario de agregar producto
            // Por ejemplo, mostrar un modal o una sección oculta en la página
            alert('Mostrar formulario de agregar producto');
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
    </script>
    <div class="flex w-full max-w-5xl items-center justify-between gap-8 px-4 py-12 md:px-6 lg:px-8">
        <div class="hidden w-full max-w-md items-center justify-center lg:flex">
            <img src="../../img/logo-app-fondoBlanco.jpg" width="200" height="200" alt="Company Logo" class="max-w-[200px]" style="aspect-ratio: 200 / 200; object-fit: cover;" />
        </div>
        <div class="w-full max-w-lg space-y-2">
            <div class="relative bg-white rounded-lg border bg-card text-card-foreground shadow-sm w-full p-6">
                <div class="flex flex-col space-y-1.5 mb-4">
                    <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Nuevo Pedido</h3>
                </div>
                <form id="pedidosForm" method="post">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="cl_documento" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Cliente</label>
                            <div class="flex space-x-2">
                                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="text" id="cl_documento" name="cl_documento" required />
                                <input type="hidden" id="cl_id" name="cl_id" readonly />
                                <button type="button" class="bg-yellow-500 text-white px-4 py-2 rounded-md" onclick="event.preventDefault(); buscarCliente();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground">
                                        <circle cx="9" cy="9" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="numero">Número de pedido</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="number" id="numpedido" name="pe_numero" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="direccion">Dirección</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="text" id="direccion" name="pe_direccion" required />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="fechaentrega">Fecha de entrega</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="date" id="fechaentrega" name="pe_fechaentrega" required />
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
                                <!-- Aquí irán las filas de productos, se pueden añadir dinámicamente con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex justify-end">
                        Total: S/.<input type="number" step="0.01" id="pe_preciototal" name="pe_preciototal" readonly />
                    </div>
                    <div class="flex justify-end pt-4">
                        <button type="button" class="mr-2 bg-red-500 text-white px-4 py-2 rounded-md" onclick="pedidos()">Cancelar</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../lib/alertifyjs/alertify.js"></script>
    <?php include 'RegistarProductoPedidos.php'; ?>
</body>

</html>