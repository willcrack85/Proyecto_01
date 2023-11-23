<?php
require_once('class/agenda_funciones.php');

$agenda = new Agenda();
error_reporting(0);

//Volver a la página principal luego de eliminar
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $agenda->eliminar_tarea($id);
    header('Location: index.php');
}
?>