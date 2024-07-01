<?php
include '../class/TiempoApiConexion.php';
include '../class/ProduccionConexion.php';
include '../class/ProduccionInventarioConexion.php';
include '../class/ProductosConexion.php';

$Listarproduccioninventario = Listarproduccioninventario();
$Listarproduccion = ListarProduccion();

// var_dump($Listarproduccion, $Listarproduccion);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['executeFunction'])) {
    $respuesta = EditarProduccion($_POST['executeFunction'], $_POST['hora'], $_POST['cantidad']);
    //   var_dump($respuesta);
    header('Location: produccion.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestiona la producción</title>
    <link rel="icon" href="../img/logo-app.jpg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
</head>

<body>
    <?php include('menu.php'); ?>
    <div class="flex-1 p-6">
        <h1 class="text-6xl text-yellow-800 mb-1 oleo-script">Producción de los productos - ACTIVOS</h1>
        <input id="hora" type="text" readonly class="hora-input block w-full bg-gray-100 border border-gray-300 rounded py-2 px-4 text-center text-xl font-mono" />
        <table id="inventarioTable" class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b">Inventario</th>
                    <th class="py-2 px-4 border-b">Producto</th>
                    <th class="py-2 px-4 border-b">Terminado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Listarproduccion['Detalle'] as $Produccion) : ?>

                    <form method="POST">

                        <?php if ($Produccion['produ_terminado'] == '0') : ?>
                            <tr class="items-center justify-center border">
                                <td class="flex flex-row items-center justify-center space-x-4">
                                    <?php foreach ($Listarproduccioninventario['Detalle'] as $Inventario) : ?>
                                        <div class="flex flex-col justify-between">
                                            <?php if ($Inventario['produ_id'] == $Produccion['produ_id']) : ?>
                                                <p type="text" value="<?php echo $Inventario['pro_nombre'] ?>" readonly><?php echo $Inventario['pro_nombre'] ?></p>
                                                <img src="<?php echo "https://panstock.informaticapp.com/public/productos/" . $Inventario['pro_imagen'] ?>" alt="" style="max-width: 100px; height: auto;">
                                                <p style="text-align: center;"><?php echo $Inventario['produinv_cantidad'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <div style="display: inline-block; text-align: center;">
                                        <img src="<?php echo "https://panstock.informaticapp.com/public/productos/" . $Produccion['pro_imagen'] ?>" alt="producto" style="max-width: 100px; max-height: 100px;">
                                        <br>
                                        <input type="text" value="<?php echo $Inventario['pro_nombre'] ?>" readonly style="text-align: center;">
                                    </div>
                                </td>

                                <td class="flex flex-col items-center justify-center">
                                    <p>Tiempo inicio</p>
                                    <input type="text" value="<?php echo $Produccion['produ_horainicio'] ?>" readonly style="text-align: center;">
                                    <p>Cantidad Producida <input name="cantidad" class=" bg-white border border-gray-300 rounded py-2 px-4 mr-2 quantity-input" type="text" style="text-align: center;"></p>
                                    <input hidden name="hora" type="text" readonly class="hora-input w-full bg-gray-100 border border-gray-300 rounded py-2 px-4 text-center text-xl font-mono" />

                                    <button type="submit" name="executeFunction" value="<?php echo $Produccion['produ_id'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Terminar</button>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </form>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="MetodosProduccion/NuevaProduccion.php" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Nueva Produccion</a>
    </div>

    <script>
        function añadirFila() {
            var table = document.getElementById("inventarioTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();
            for (var i = 0; i < 3; i++) {
                var newCell = newRow.insertCell(i);
                var newText = document.createTextNode('Nuevo ' + (i + 1));
                newCell.appendChild(newText);
                newCell.className = "py-2 px-4 border-b";
            }
        }
    </script>
    </div>
    </div>
</body>
<script src="../lib/jquery-3.7.1.min.js"></script>
<script>
    var settings = {
        "url": "http://worldtimeapi.org/api/timezone/America/Lima",
        "method": "GET",
        "timeout": 0,
    };

    function actualizarHora() {
        $.ajax(settings).done(function(response) {
            var dateTime = new Date(response.datetime);
            var hora = dateTime.toLocaleTimeString('es-PE', {
                hour12: false
            });
            $('.hora-input').val(hora);
        });
    }

    // Actualizar hora al cargar la página
    actualizarHora();

    // Actualizar hora cada segundo
    setInterval(actualizarHora, 1000);
</script>

</html>