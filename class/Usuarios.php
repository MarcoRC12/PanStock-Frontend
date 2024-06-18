<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['usu_usuario'];
    $password = $_POST['usu_contrasena'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://panstock.informaticapp.com/usuarios',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VCL3F6cjhOSS9yMS9QRi5XQmFnRGY5eXN5R21Wa0ptOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlcHhoT0hsb2JKaVUvUi8ucnR1ZlJDWnpsOHhPZW4ucQ=='
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $data = json_decode($response, true);

    if ($data['Status'] == "404") {
        echo json_encode(['status' => 'error', 'message' => 'Datos Incorrectos']);
    } else if ($data['Detalle'][0]['usu_usuario'] == $username && $data['Detalle'][0]['usu_contrasena'] == $password) {
        echo json_encode(['status' => 'success', 'message' => 'Login exitoso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos Incorrectos']);
    }
    exit;  // Asegúrate de que no haya más salida después de esto
}
