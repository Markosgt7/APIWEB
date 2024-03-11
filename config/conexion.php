<?php
include_once('env.php');

$conexiondb = null;  // variable de conexión a la base de datos

try {
  $conexiondb = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($conexiondb->connect_error) {
    throw new Exception("Conexion fallida:" . $conexiondb->connect_error);
  }
} catch (Exception $e) {
  echo 'Error al conectar a la base de datos: ' . $e->getMessage();
}
