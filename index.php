<?php
require('./config/conexion.php');
//esto nos permite devolver  un json en lugar de una página html
header("Content-Type: application/json");

$metodo = $_SERVER['REQUEST_METHOD']; //GET, POST, PUT, DELETE etc..

switch ($metodo) {
  case 'GET':
    echo "Consulta de registro tipo GET";
    break;
  case 'POST':
    echo "Consulta de registro de tipo POST";
    break;
  case 'PUT':
    echo "Edición o actualizacion de registro de tipo PUT";
    break;
  case 'DELETE':
    echo "Eliminacion de registro de tipo DELETE";
    break;
  default:
    echo  "Método no permitido";
    break;
}
