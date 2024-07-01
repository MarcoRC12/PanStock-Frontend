<?php
include '../../class/TiempoApiConexion.php';
include '../../class/ProductosConexion.php';
include '../../class/ProduccionConexion.php';
include '../../class/InventarioConexion.php';
include '../../class/ProduccionInventarioConexion.php';

$ListarProductos = ListarProductos();
$ListarInventario = ListarInventario();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $horaini = tiempohora();
    $fecha = tiempofecha();
    $id = CrearProduccion($_POST['producto'], $horaini, '00:00:00', $fecha);
    //var_dump($id);
    foreach($_POST['inventario'] as $data){
        if (!empty($data['cantidad']) && !empty($data['producto_id'])) {
                $respuesta  =  Crearproduccioninventario($data['producto_id'], $id['id'], $data['cantidad']);
            // var_dump($respuesta);
            header('Location: ../produccion.php');
            exit();
        }
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

    <div class="flex w-full items-center justify-between gap-8 px-4 py-12 md:px-6 lg:px-8">
        <div class="hidden w-full max-w-md items-center justify-center lg:flex">
            <img src="../../img/logo-app-fondoBlanco.jpg" width="200" height="200" alt="Company Logo" class="max-w-[200px]" style="aspect-ratio: 200 / 200; object-fit: cover;" />
        </div>
        <div class="w-full space-y-2">
            <div class="relative bg-white rounded-lg border bg-card text-card-foreground shadow-sm w-full p-6">
                <div class="flex flex-col space-y-1.5 mb-4">
                    <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Nuevo Pedido</h3>
                </div>
                <form id="pedidosForm" method="post">
                    <table id="inventarioTable" class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b">Inventario</th>
                                <th class="py-2 px-4 border-b">Producto</th>
                            </tr>
                        </thead>
                        <td>
                            <select id="inventario" name="inventario" class="block w-full bg-white border border-gray-300 rounded py-2 px-4">
                                <?php foreach ($ListarInventario['Detalle'] as $Inventario) : ?>
                                    <option value="<?php echo $Inventario['inv_id'] ?>"><?php echo $Inventario['pro_nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="selected-products" style="margin-top: 10px;"></div>

                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <img id="productoImagen" alt="producto" style="display:none; margin-top: 10px; max-width: 200px; height: auto;"/>
                                <select id="producto" name="producto" class="block w-full bg-white border border-gray-300 rounded py-2 px-4 mt-2">
                                    <?php foreach ($ListarProductos['Detalle'] as $producto) : ?>
                                        <option data-imagen="<?php echo "https://panstock.informaticapp.com/public/productos/" . $producto['pro_imagen'] ?>" value="<?php echo $producto['pro_id'] ?>"><?php echo $producto['pro_nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </td>

                        <tbody>
                        </tbody>
                    </table>
                    <div class="grid grid-cols-2 gap-4">

                        <div class="flex justify-end pt-4">
                            <button type="button" class="mr-2 bg-red-500 text-white px-4 py-2 rounded-md" onclick="produccion()">Cancelar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Empezar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function produccion() {
            window.location.href = '../produccion.php';
        }
        document.getElementById('inventario').addEventListener('change', function() {
    // Obtener el option seleccionado
    var selectedOption = this.options[this.selectedIndex];
    var selectedValue = selectedOption.value;
    var selectedText = selectedOption.text;

    // Obtener el contenedor para los productos seleccionados
    var container = document.getElementById('selected-products');

    // Verificar si el producto ya ha sido agregado
    var inputs = container.querySelectorAll('.product-item');
    var productoRepetido = false;

    inputs.forEach(function(input) {
        var productId = input.querySelector('.product-id').value;

        if (productId === selectedValue) {
            productoRepetido = true;
            return;
        }
    });

    // Mostrar mensaje si el producto ya ha sido agregado
    if (productoRepetido) {
        alert('¡Este producto ya ha sido añadido al inventario!');
        return;
    }

    // Contar el número actual de inputs en el contenedor para el autoincremento
    var inputCount = container.querySelectorAll('.product-input').length;

    // Crear un nuevo div para contener el input y el botón eliminar
    var newDiv = document.createElement('div');
    newDiv.classList.add('product-item', 'flex', 'items-center', 'mb-2');

    // Crear input oculto para el ID del producto
    var productIdInput = document.createElement('input');
    productIdInput.type = 'hidden';
    productIdInput.name = 'inventario[' + inputCount + '][producto_id]';
    productIdInput.value = selectedValue;
    productIdInput.classList.add('product-id');

    // Crear el input para el nombre del producto
    var newInput = document.createElement('input');
    newInput.type = 'text';
    newInput.name = 'inventario[' + inputCount + '][nombre]';
    newInput.value = selectedText;
    newInput.readOnly = true;
    newInput.classList.add('block', 'w-full', 'bg-white', 'border', 'border-gray-300', 'rounded', 'py-2', 'px-4', 'mr-2', 'product-input');

    // Crear el input para la cantidad
    var newQuantityInput = document.createElement('input');
    newQuantityInput.type = 'number';
    newQuantityInput.name = 'inventario[' + inputCount + '][cantidad]';
    newQuantityInput.value = 1; // Valor por defecto
    newQuantityInput.classList.add('block', 'w-16', 'bg-white', 'border', 'border-gray-300', 'rounded', 'py-2', 'px-4', 'mr-2', 'quantity-input');

    // Crear el botón eliminar
    var deleteButton = document.createElement('button');
    deleteButton.textContent = 'Eliminar';
    deleteButton.type = 'button';
    deleteButton.classList.add('bg-red-500', 'hover:bg-red-600', 'text-white', 'py-2', 'px-4', 'rounded', 'focus:outline-none');

    // Función para eliminar el elemento al hacer clic en el botón
    deleteButton.addEventListener('click', function() {
        newDiv.remove(); // Eliminar el div que contiene el input y el botón
    });

    // Agregar los elementos al nuevo div
    newDiv.appendChild(productIdInput);
    newDiv.appendChild(newInput);
    newDiv.appendChild(newQuantityInput);
    newDiv.appendChild(deleteButton);

    // Agregar el nuevo div al contenedor
    container.appendChild(newDiv);
});

        document.getElementById('producto').addEventListener('change', function() {
            // Obtener el option seleccionado
            var selectedOption = this.options[this.selectedIndex];
            // Obtener el atributo data-imagen del option seleccionado
            var imagenUrl = selectedOption.getAttribute('data-imagen');
            // Obtener el elemento img
            var imgElement = document.getElementById('productoImagen');

            // Si existe una imagen, mostrarla. Si no, ocultar el elemento img.
            if (imagenUrl) {
                imgElement.src = imagenUrl;
                imgElement.style.display = 'block';
            } else {
                imgElement.style.display = 'none';
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../lib/alertifyjs/alertify.js"></script>
</body>

</html>