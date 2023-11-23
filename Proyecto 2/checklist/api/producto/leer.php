<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// incluir archivos de conexion y objetos
include_once '../configuracion/conexion.php';
include_once '../objetos/tareas.php';

//Api para leer tareas

//instanciamos la base de datos
$database = new Conexion();
$db = $database->obtenerConexion();

//instanciamos el objeto tarea
$tarea = new tareas($db);

//leemos las tareas
$stmt = $tarea->obtener_tareas();
$num = $stmt->rowCount();

//verificamos si hay tareas
if($num>0){
    //arreglo de tareas
    $tareas_arr = array();
    $tareas_arr["tareas"] = array();

    //obtenemos los datos de las tareas
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $tarea_item = array(
            "id" => $id,
            "categoria" => $categoria,
            "titulo" => $titulo,
            "descripcion" => $descripcion,
            "responsable" => $responsable,
            "editado" => $editado,
            "fecha" => $fecha,
            "estado" => $estado,
            "hora_inicio" => $hora_inicio,
            "hora_fin" => $hora_fin
        );

        array_push($tareas_arr["tareas"], $tarea_item);
    }

    //Código de respuesta
    http_response_code(200);

    //Mostramos los datos en formato json
    echo json_encode($tareas_arr);
}else{
    //Código de respuesta
    http_response_code(404);

    //Mensaje de respuesta
    echo json_encode(array("mensaje" => "No se encontraron tareas"));
}
?>