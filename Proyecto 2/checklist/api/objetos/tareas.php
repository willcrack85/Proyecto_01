<?php

    class tareas {
        private $conn;
        private $nombre_tabla = 'tareas';
        public $id;
        public $categoria;
        public $titulo;
        public $descripcion;
        public $correo;
        public $ubicacion;
        public $fecha;
        public $repeticion;
        public $hora_inicio;
        public $hora_fin;

        public function __construct( $db ) {
            $this->conn = $db;
        }

        function insertar_tarea (){
            $query = "CALL insertar_tarea(?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(2, $this->categoria);
            $stmt->bindParam(3, $this->titulo);
            $stmt->bindParam(4, $this->descripcion);
            $stmt->bindParam(5, $this->responsable);
            $stmt->bindParam(6, $this->editado);
            $stmt->bindParam(7, $this->fecha);
            $stmt->bindParam(8, $this->estado);
            $stmt->bindParam(9, $this->hora_inicio);
            $stmt->bindParam(10, $this->hora_fin);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        function obtener_tareas () {
            $query = "CALL mostrar_tareas()";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
            }
            
        function readOne(){
            $query = "CALL mostrar_tareas_hoy2('".date('Y-m-d')."')";
            $stmt = $this->conn->prepare($query);
            //por fecha del dia
            $stmt->bindParam(1, $this->fecha);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->categoria = $row['categoria'];
            $this->titulo = $row['titulo'];
            $this->descripcion = $row['descripcion'];
            $this->correo = $row['correo'];
            $this->ubicacion = $row['ubicacion'];
            $this->fecha = $row['fecha'];
            $this->repeticion = $row['repeticion'];
            $this->hora_inicio = $row['hora_inicio'];
            $this->hora_fin = $row['hora_fin'];

        }

        //actualizar tarea
        function actualizar_tarea(){
            $query = "CALL actualizar_tarea(?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->bindParam(2, $this->categoria);
            $stmt->bindParam(3, $this->titulo);
            $stmt->bindParam(4, $this->descripcion);
            $stmt->bindParam(5, $this->responsable);
            $stmt->bindParam(6, $this->editado);
            $stmt->bindParam(7, $this->fecha);
            $stmt->bindParam(8, $this->estado);
            $stmt->bindParam(9, $this->hora_inicio);
            $stmt->bindParam(10, $this->hora_fin);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        //eliminar tarea por id
        function eliminar_tarea($id){
            $query = "CALL eliminar_tarea($id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        //MOSTRAR TAREAS POR FILTRO CAMPO , VALOR con procedimiento almacenado
        function mostrar_tareas_filtro($campo, $valor) {
            $query = "CALL filtrar_tareas(?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $campo);
            $stmt->bindParam(2, $valor);
            $stmt->execute();
            return $stmt;
        }

        //MOSTRAR TAREAS HOY
        function mostrar_tareas_hoy() {
            $query = "CALL mostrar_tareas_hoy2('".date('Y-m-d').strtotime("-1 day")."')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    
    }


?>