<?php
define('produccioninventario_URL', 'https://panstock.informaticapp.com/produccioninventario');

function Listarproduccioninventario(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => produccioninventario_URL,
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
    return json_decode($response, true);
}

function Buscarproduccioninventario($id)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
         CURLOPT_URL => produccioninventario_URL . '/' . $id,
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
    return json_decode($response, true);
}

function Crearproduccioninventario($inv_id, $produ_id, $produinv_cantidad)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => produccioninventario_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'inv_id' => $inv_id,
            'produ_id' => $produ_id,
            'produinv_cantidad' => $produinv_cantidad
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VCL3F6cjhOSS9yMS9QRi5XQmFnRGY5eXN5R21Wa0ptOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlcHhoT0hsb2JKaVUvUi8ucnR1ZlJDWnpsOHhPZW4ucQ=='
        ),
    ));

    $response = curl_exec($curl);

    if ($response === false) {
        $response = json_encode(['Status' => 500, 'Error' => curl_error($curl)]);
    }

    curl_close($curl);
    return json_decode($response, true);
}

function Editarproduccioninventario($id, $proid, $peid, $propenumorden, $propedescripcion, $propecantidad, $propeentregado, $propeprecio)
{
    $curl = curl_init();

    $data = http_build_query(array(
        'pro_id' => $proid,
        'pe_id' => $peid,
        'prope_numorden' => $propenumorden,
        'prope_descripcion' => $propedescripcion,
        'prope_cantidad' => $propecantidad,
        'prope_entregado' => $propeentregado,
        'prope_precio' => $propeprecio
    ));

    curl_setopt_array($curl, array(
        CURLOPT_URL => produccioninventario_URL . '/' . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VCL3F6cjhOSS9yMS9QRi5XQmFnRGY5eXN5R21Wa0ptOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlcHhoT0hsb2JKaVUvUi8ucnR1ZlJDWnpsOHhPZW4ucQ=='
        ),
    ));

    $response = curl_exec($curl);

    if ($response === false) {
        $response = json_encode(['Status' => 500, 'Error' => curl_error($curl)]);
    }

    curl_close($curl);
    return json_decode($response, true);
}

function Eliminarproduccioninventario($id)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => produccioninventario_URL . '/' . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VCL3F6cjhOSS9yMS9QRi5XQmFnRGY5eXN5R21Wa0ptOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlcHhoT0hsb2JKaVUvUi8ucnR1ZlJDWnpsOHhPZW4ucQ=='
        ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
    return array('Status' => $httpcode, 'Response' => $response);
}
