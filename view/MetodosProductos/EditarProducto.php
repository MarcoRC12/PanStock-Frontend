<?php

include '../../class/ProductosConexion.php';
include '../../class/TipoProductos.php';

//Capturar el id del producto
$producto_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($producto_id) {
    // obtener los datos del producto
    $producto_data = BuscarProducto($producto_id);

    if ($producto_data && $producto_data['Status'] == 200) {
        $producto = $producto_data['Detalle'][0];
    } else {
        die("Error al obtener los datos del ");
    }
} else {
    die("ID del producto no existe");
}

// Procesar la solicitud PUT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    // Obtener los datos del formulario
    $pronombre = $_POST['pro_nombre'];
    $prodescripcion = $_POST['pro_descripcion'];
    $tproid = $_POST['tpro_id'];
    $promarca = $_POST['pro_marca'];
    $proimagen = $_POST['pro_imagen'];

    // Llamar a la función para editar el cliente
    $resultado = EditarProducto($producto_id, $pronombre, $prodescripcion, $tproid, $promarca, $proimagen);

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
    <title>Editar producto</title>
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
                <h1 class="text-5xl tracking-tighter oleo-script">Editar Producto</h1>
            </div>
            <form id="editProductForm" class="bg-white shadow-md rounded-lg p-6 space-y-2" method="POST" action="">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="pro_id" value="<?= htmlspecialchars($producto_id) ?>">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="firstName">Nombre</label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="Name" name="pro_nombre" value="<?= htmlspecialchars($producto['pro_nombre'] ?? '') ?>" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="descripcion">Apellido</label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="descripcion" name="pro_descripcion" value="<?= htmlspecialchars($producto['pro_descripcion'] ?? '') ?>" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="tpro_id">Tipo de producto</label>
                    <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="tpro_id" name="tpro_id" required>
                        <?php foreach ($data_tproducto["Detalle"] as $tpro) : ?>
                            <option value="<?= htmlspecialchars($tpro["tpro_id"]) ?>" <?= (isset($producto['tpro_id']) && $producto['tpro_id'] == $tpro['tpro_id']) ? 'selected' : '' ?>><?= htmlspecialchars($tpro["tpro_nombre"]) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="marca">Marca</label>
                    <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="pro_marca" name="pro_marca" required>
                        <option value="La Panadería" <?= (isset($producto['pro_marca']) && $producto['pro_marca'] == 'La Panadería') ? 'selected' : '' ?>>La Panadería</option>
                        <option value="La Repostería" <?= (isset($producto['pro_marca']) && $producto['pro_marca'] == 'La Repostería') ? 'selected' : '' ?>>La Repostería</option>
                        <option value="Dulce Delicia" <?= (isset($producto['pro_marca']) && $producto['pro_marca'] == 'Dulce Delicia') ? 'selected' : '' ?>>Dulce Delicia</option>
                        <option value="Pan Saludable" <?= (isset($producto['pro_marca']) && $producto['pro_marca'] == 'Pan Saludable') ? 'selected' : '' ?>>Pan Saludable</option>
                        <option value="Galletería Fina" <?= (isset($producto['pro_marca']) && $producto['pro_marca'] == 'Galletería Fina') ? 'selected' : '' ?>>Galletería Fina</option>
                        <option value="Pasteles Gourmet" <?= (isset($producto['pro_marca']) && $producto['pro_marca'] == 'Pasteles Gourmet') ? 'selected' : '' ?>>Pasteles Gourmet</option>
                        <option value="Bagels & More" <?= (isset($producto['pro_marca']) && $producto['pro_marca'] == 'Bagels & More') ? 'selected' : '' ?>>Bagels & More</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <input type="hidden" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="image" name="pro_imagen" value="<?= htmlspecialchars($producto['pro_imagen'] ?? '') ?>" required />
                </div>
                <div class="flex justify-end pt-4">
                    <button type="button" class="mr-2 bg-red-600 text-white px-4 py-2 rounded-md" onclick="productos()">Cancelar</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Modificar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../lib/alertifyjs/alertify.js"></script>
    <script>
        function productos() {
            window.location.href = '../productos.php';
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editProductForm').addEventListener('submit', function(event) {
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
                                window.location.href = '../productos.php';
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