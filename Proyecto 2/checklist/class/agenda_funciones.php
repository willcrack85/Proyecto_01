<?php
//Libreria para crear los informes
//require 'vendor/autoload.php';

//guardar los datos en la base de datos
require_once('modelo.php');
//conectar a la base de datos   
class Agenda extends modeloCredencialesBD{
    protected $categoria;
    protected $titulo;
    protected $descripcion;
    protected $responsable;
    protected $editado;
    protected $fecha;
    protected $estado;
    protected $hora_inicio;
    protected $hora_fin;
    public function __construct(){
        parent::__construct();
    }

    public function insertar_tarea($categoria, $titulo, $descripcion, $responsable, $editado, $fecha, $estado, $hora_inicio, $hora_fin){
        
        $this->categoria = $categoria;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->responsable = $responsable;
        $this->editado = $editado;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        
        $instruccion = "CALL insertar_tarea('$this->categoria', '$this->titulo', '$this->descripcion', '$this->responsable', '$this->editado', '$this->fecha', '$this->estado', '$this->hora_inicio', '$this->hora_fin')";
        $consulta = $this->_db->query($instruccion); //ejecutar la consulta
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC); //obtener los datos de la consulta
        if(!$resultado){
            //echo "Fallo al insertar la tarea";
        }else{
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }

    }
    //Funcion para mostrar las Categorias
    public function obtener_categorias() {
        $instruccion = "CALL obtener_categorias()";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        if(!$resultado) {
            //echo " FALLO AL MOSTRAR LAS CATEGORIAS";
        }else{
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    
    //Funcion para mostrar los estados
    public function obtener_estados() {
        $instruccion = "CALL obtener_estados()";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        if(!$resultado) {
            //echo " FALLO AL MOSTRAR LAS ESTADOS";
        }else{
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }

    //Funcion para mostrar las tareas con la fecha actual
    public function mostrar_tareas_hoy(){
        $instruccion = "CALL mostrar_tareas_hoy2('".date('Y-m-d',strtotime('-0 day'))."')";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        if(!$resultado){
            //echo "Fallo al mostrar las tareas";
        }else{
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }

    //Funcion para mostrar las tareas
    public function mostrar_tareas(){
        $instruccion = "CALL mostrar_tareas()";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        if(!$resultado){
            //echo " FALLO AL MOSTRAR LAS TAREAS";
        }else{
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }

    //Funcion para mostrar las tareas con filtro
    public function mostrar_tareas_filtro($campos, $valor){

        if($campos == "categoria" || $campos == "estado" || $campos == "responsables"){
            $instruccion = "CALL filtrar_tareas('$campos', '$valor')";
        }else {
            $instruccion = "CALL filtrar_tareas2('$campos', '$valor')";
        }
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        if(!$resultado){
            //echo "Fallo al mostrar las tareas";
        }else{
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }

    //Funcion para VISUALIZAR las tareas por id
    public function visualizar_tarea($id){
        $this->id = $id;
        $instruccion = "CALL visualizar_tarea('$this->id')";
        $consulta = $this->_db->query($instruccion);
        
        if(!$consulta){
            //echo "Fallo al visualizar la tarea";
            return false;
        }
        
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        $consulta->close(); // Cierra la consulta
        
        $this->_db->close(); // Cierra la conexión
    
        return $resultado;
    }
    

    //Funcion para ACTUALIZAR las tareas por id
    public function actualizar_tarea($id, $categoria, $titulo, $descripcion, $responsable, $editado, $fecha, $estado, $hora_inicio, $hora_fin){
        $this->id = $id;
        $this->categoria = $categoria;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->responsable = $responsable;
        $this->editado = $editado++;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $instruccion = "CALL actualizar_tarea('$this->id','$this->categoria', '$this->titulo', '$this->descripcion', '$this->responsable', '$this->editado', '$this->fecha', '$this->estado', '$this->hora_inicio', '$this->hora_fin')";
        $consulta = $this->_db->query($instruccion);
        
        if($consulta==0){
            echo "Fallo al actualizar la tarea <hr>";
        }else{
            echo "Tarea actualizada correctamente";
            $this->_db->close();
        }
    }

    //Funcion para ELIMINAR las tareas por id
    public function eliminar_tarea($id){
        $this->id = $id;
        $instruccion = "CALL eliminar_tarea('$this->id')";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
        if(!$resultado){
            echo "Fallo al eliminar la tarea";
        }else{
            echo "Tarea eliminada correctamente";
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }

    
    
}
?>