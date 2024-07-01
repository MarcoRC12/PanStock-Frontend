<?php
define('Produccion_URL', 'https://panstock.informaticapp.com/produccion');

function ListarProduccion()
{

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => Produccion_URL,
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

function BuscarProduccion($id)
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => Produccion_URL . '/' . $id,
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

function CrearProduccion($pro_id, $produ_horainicio, $produ_horafin, $produ_fecha)
{

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => Produccion_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
      'pro_id' => $pro_id,
      'produ_horainicio' => $produ_horainicio,
      'produ_horafin' => $produ_horafin,
      'produ_fecha' => $produ_fecha,
      'produ_terminado' => '0',
      'produ_cantidadproducida' => '0'
      
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

function EditarProduccion($id, $produ_horafin, $cantidad){

  $BuscarPro = BuscarProduccion($id);
// var_dump($BuscarPro);
  $data = http_build_query(array(
      'pro_id' => $BuscarPro['Detalle']['0']['pro_id'],
      'produ_horainicio' => $BuscarPro['Detalle']['0']['produ_horainicio'],
      'produ_horafin' => $produ_horafin,
      'produ_fecha' => $BuscarPro['Detalle']['0']['produ_fecha'],
      'produ_terminado' => '1',
      'produ_cantidadproducida' => $cantidad
      
  ));
    $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => Produccion_URL . '/' . $id,
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

function EliminarProduccion($id)
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => Produccion_URL . '/' . $id,
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

function hora(){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://worldtimeapi.org/api/timezone/America/Lima',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  return json_decode($response, true);
}