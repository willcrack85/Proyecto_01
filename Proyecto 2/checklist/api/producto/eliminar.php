<?
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//incluimos el archivo de configuracion de la base de datos
include_once '../configuracion/conexion.php';
//incluimos el archivo de objeto producto
include_once '../objetos/tareas.php';
//obtenemos la conexion a la base de datos
$conexion = new Conexion();
$db = $conexion->obtenerConexion();
//instanciamos el objeto tareas
$tarea = new tareas($db);

//obtenemos los datos del producto a eliminar
$data = json_decode(file_get_contents("php://input"));

//obtenemos el id del producto a eliminar verificando que no este vacio y procedemos a eliminarlo

if(!empty($data->id)){
    $tarea->id = $data->id;
    if($tarea->eliminar_tarea($data->id)){
        //Código de respuesta
        http_response_code(200);
        //Mensaje de respuesta
        echo json_encode(array("mensaje" => "Tarea eliminada"));
    }else{
        //Código de respuesta
        http_response_code(503);
        //Mensaje de respuesta
        echo json_encode(array("mensaje" => "No se pudo eliminar la tarea"));
    }
}else{
    //Código de respuesta
    http_response_code(400);
    //Mensaje de respuesta
    echo json_encode(array("mensaje" => "No se pudo eliminar la tarea. Datos incompletos"));
}

?>