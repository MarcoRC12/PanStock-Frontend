<?php
function tiempohora(){
    $hora = hora();
    //var_dump($hora['datetime']);
    $dateTime = new DateTime($hora['datetime']);
    
    // Obtener la fecha y la hora por separado
    $fecha = $dateTime->format('Y-m-d');
    $hora = $dateTime->format('H:i:s.v'); // Aquí 'v' representa los milisegundos con al menos 3 dígitos
    
    // Ajustar los milisegundos a dos dígitos
    $horaini = substr($hora, 0, 8); // Obtener solo los primeros 12 caracteres (incluyendo los milisegundos)
    
    // Mostrar los resultados
//   echo "Fecha: " . $fecha . "<br>";
    // echo "Hora con dos milisegundos: " . $horaini . "<br>";
    return $horaini;
}

function tiempofecha(){
    $hora = hora();
    //var_dump($hora['datetime']);
    $dateTime = new DateTime($hora['datetime']);
    
    // Obtener la fecha y la hora por separado
    $fecha = $dateTime->format('Y-m-d');
    $hora = $dateTime->format('H:i:s.v'); // Aquí 'v' representa los milisegundos con al menos 3 dígitos
    
    // Ajustar los milisegundos a dos dígitos
    $horaini = substr($hora, 0, 8); // Obtener solo los primeros 12 caracteres (incluyendo los milisegundos)
    
    // Mostrar los resultados
//   echo "Fecha: " . $fecha . "<br>";
    // echo "Hora con dos milisegundos: " . $horaini . "<br>";
    return $fecha;
}


