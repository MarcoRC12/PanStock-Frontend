<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['us_usu'];
    $password = $_POST['us_pas'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://panaderia.informaticapp.com/usuarios/' . $username . '&' . $password,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VnQk52YmVqbFhDdjJ5Nkx1MUlCRC5YU3VTQmFSSjVLOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlUzU0Lmh3RXlQL2V1OGFVeEp5dEVtSHdLdlBCeUowSw=='
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    if ($data['Status'] == "404") {
        echo json_encode(['status' => 'error', 'message' => 'Datos Incorrectos']);
    } else if ($data['Detalle'][0]['us_usuario'] == $username && $data['Detalle'][0]['us_password'] == $password) {
        echo json_encode(['status' => 'success', 'message' => 'Login exitoso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos Incorrectos']);
    }
    exit;  // Asegúrate de que no haya más salida después de esto
}
?>
