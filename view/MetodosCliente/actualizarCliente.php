<?php
include '../../class/ClientesConexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_input(INPUT_POST, 'cl_id', FILTER_VALIDATE_INT);
    $nombre = filter_input(INPUT_POST, 'cl_nombre', FILTER_SANITIZE_STRING);
    $apellido = filter_input(INPUT_POST, 'cl_apellido', FILTER_SANITIZE_STRING);
    $documento = filter_input(INPUT_POST, 'cl_documento', FILTER_SANITIZE_STRING);
    $td_id = filter_input(INPUT_POST, 'td_id', FILTER_VALIDATE_INT);
    $telefono = filter_input(INPUT_POST, 'cl_telefono', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'cl_email', FILTER_SANITIZE_STRING);

    $resultado = EditarCliente($id, $nombre, $apellido, $documento, $td_id, $telefono, '');

    if ($resultado && $resultado['Status'] == 200) {
        header('Location: ../clientes.php?status=success');
    } else {
        header('Location: ../clientes.php?status=error');
    }
    exit();
}
?>
