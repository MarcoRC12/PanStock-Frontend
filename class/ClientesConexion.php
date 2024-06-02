<?php
define('CLIENTES_URL', 'https://panstock.informaticapp.com/clientes');
function ListarClientes(){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => CLIENTES_URL,
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
function CrearClientes($nombre, $apellido, $documento, $td_id, $telefono ,$email){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => CLIENTES_URL.'/clientes',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
    'cl_nombre' => $nombre,
    'cl_apellido' => $apellido,
    'cl_documento' => $documento,
    'td_id' => $td_id,
    'cl_telefono' => $telefono,
    'cl_email' => $email),
    CURLOPT_HTTPHEADER => array(
      'Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VCL3F6cjhOSS9yMS9QRi5XQmFnRGY5eXN5R21Wa0ptOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlcHhoT0hsb2JKaVUvUi8ucnR1ZlJDWnpsOHhPZW4ucQ=='
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
}

function BuscarCliente($id){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => CLIENTES_URL.'/clientes/'.$id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: ••••••'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

}

function EditarCliente($id, $nombre, $apellido, $documento, $td_id, $telefono ,$email){


    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => CLIENTES_URL.'/clientes/'.$id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS =>
    'cl_nombre='.$nombre.
    '&cl_apellido='.$apellido.
    '&cl_documento='.$documento.
    '&td_id='.$td_id.
    '&cl_telefono='.$telefono.
    '&cl_email='.$email,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: ••••••'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

}

function Delete($id){

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => CLIENTES_URL.'/clientes/'.$id,
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

    curl_close($curl);
    return $response;
}
?>