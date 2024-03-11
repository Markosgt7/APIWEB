<?php
require('./config/conexion.php');
//esto nos permite devolver  un json en lugar de una página html
header("Content-Type: application/json");

$metodo = $_SERVER['REQUEST_METHOD']; //GET, POST, PUT, DELETE etc..
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$buscarId = explode("/", $path);
$id = ($path !== '/') ? end($buscarId) : null; //obtiene el ultimo valorde mi url que  es el id del registro a buscar

switch ($metodo) {
  case 'GET':
    //echo "Consulta de registro tipo GET";
    consulta($conexiondb, $id);
    break;
  case 'POST':
    //echo "Consulta de registro de tipo POST";
    insert($conexiondb);
    break;
  case 'PUT':
    //echo "Edición o actualizacion de registro de tipo PUT";
    actualizar($conexiondb, $id);
    break;
  case 'DELETE':
    //echo "Eliminacion de registro de tipo DELETE";
    eliminar($conexiondb, $id);
    break;
  default:
    echo  "Método no permitido";
    break;
}

function consulta($conexiondb, $id)
{
  $sql = ($id === null) ? "SELECT * FROM usuarios" : "SELECT * FROM usuarios WHERE id=$id";
  $rspt = $conexiondb->query($sql);
  if ($rspt) {
    $datos = array();
    while ($row = $rspt->fetch_assoc()) {
      $datos[] = $row;
    }
    echo json_encode($datos);
    $conexiondb->close();
  }
}
function insert($conexiondb)
{
  $dato = json_decode(file_get_contents('php://input'), true);
  $nombre = $dato['nombre'];

  $sql = "INSERT INTO usuarios(nombre) VALUES ('$nombre')";
  $rspt = $conexiondb->query($sql);

  if ($rspt) {
    $dato['id'] = $conexiondb->insert_id;
    echo json_encode($dato);
  } else {
    echo json_encode(array('errior' => 'Error al crear usuario'));
  }
  $conexiondb->close();
}
function eliminar($conexiondb, $id)
{
  //echo "El id a borra es->" . $id;
  $sql = "DELETE FROM usuarios WHERE id='$id'";
  $rspt = $conexiondb->query($sql);
  if (!$rspt) {
    die("Fallo la eliminación");
  } else {
    echo json_encode(array('mensaje' => 'Usuario Eliminado Correctamente'));
  }
  $conexiondb->close();
}
function actualizar($conexiondb, $id)
{
  $dato = json_decode(file_get_contents('php://input'), true);
  $nombre = $dato['nombre'];
  //echo "El id a actualizar  es->" . $id . " con nombre->" . $nombre;
  $sql = "UPDATE usuarios SET nombre='$nombre' WHERE id='$id'";
  $rspt = $conexiondb->query($sql);
  if (!$rspt) {
    echo json_encode(array('mensaje' => 'Error al Actualizar'));
  } else {
    echo json_encode(array('mensaje' => 'Usuario Actualizado'));
  }
  $conexiondb->close();
}
