<?php
//actualizar producto mediante API 
// metodo http - PUT
// encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
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

//obtenemos los datos del producto a actualizar
$data = json_decode(file_get_contents("php://input"));

//verificamos que los datos no esten vacios

if(
!empty($data->id) &&
!empty('$data->$categoria') &&
!empty('$data->$titulo') &&
!empty('$data->$descripcion') &&
!empty('$data->$responsable') &&
!empty('$data->$editado') &&
!empty('$data->$fecha') &&
!empty('$data->$estado') &&
!empty('$data->$hora_inicio') &&
!empty('$data->$hora_fin')

){
    //asignamos los valores a los atributos del objeto
    $tarea->id = $data->id;
    $tarea->categoria = $data->categoria;
    $tarea->titulo = $data->titulo;
    $tarea->descripcion = $data->descripcion;
    $tarea->responsable = $data->responsable;
    $tarea->editado = $data->editado;
    $tarea->fecha = $data->fecha;
    $tarea->estado = $data->estado;
    $tarea->hora_inicio = $data->hora_inicio;
    $tarea->hora_fin = $data->hora_fin;

    //actualizamos el producto
    if($tarea->actualizar_tarea()){
        //codigo de respuesta
        http_response_code(200);
        //mensaje de respuesta
        echo json_encode(array("mensaje" => "Tarea actualizada"));
    }else{
        //codigo de respuesta
        http_response_code(503);
        //mensaje de respuesta
        echo json_encode(array("mensaje" => "No se pudo actualizar la tarea"));
    }
}else{
    //codigo de respuesta
    http_response_code(400);
    //mensaje de respuesta
    echo json_encode(array("mensaje" => "No se pudo actualizar la tarea. Datos incompletos"));
}



?>