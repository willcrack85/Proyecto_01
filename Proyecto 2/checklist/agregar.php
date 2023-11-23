<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checklist Tracker</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <!-- Cabecera -->
    <header>
        <div class="contenedor">
            <h1>Checklist Tracker</h1>
        </div>
    </header>

    <!-- Menu con opciones Agregar, Mostrar y Buscar -->
    <div class="contenedor">
        <nav class="menu">
            <ul>
                <li><a href="agregar.php">Agregar Tarea</a></li>
                <li><a href="tareas.php">Mostrar Tareas</a></li>
                <li><a href="index.php">Buscar Tarea</a></li>
            </ul>
        </nav>
    </div><br>
    
    <!--Obtine la informacion para desplegar en los selects-->
    <?php
        require_once('class/agenda_funciones.php');
        $agenda = new Agenda();
        $categorias = $agenda->obtener_categorias();
        $agenda = new Agenda();
        $estados = $agenda->obtener_estados();
        
    ?>
    <!-- Contenedor -->

    <div class="contenedor">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" id="titulo" placeholder="Titulo de la tarea" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria">
                    <?php
                    foreach ($categorias as $categoria) {
                        echo "<option value='" . $categoria['id'] . "'>" . $categoria['categoria'] . "</option>";
                    }
                    ?>
                </select>

            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <textarea name="descripcion" id="descripcion" placeholder="Descripcion de la tarea" required></textarea>
            </div>
            <div class="form-group">
                <label for="responsable">Responsable</label>
                <input type="text" name="responsable" id="responsable" placeholder="responsable de la tarea">
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado">
                    <?php
                    foreach ($estados as $estado) {
                        echo "<option value='" . $estado['id'] . "'>" . $estado['estado'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hora_inicio">Hora de inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" required>
            </div>
            <div class="form-group">
                <label for="hora_fin">Hora de fin</label>
                <input type="time" name="hora_fin" id="hora_fin" required>
            </div>
            
            <input type="submit" value="Insertar Tarea" name="insertar">
        </form>
    </div>
    <?php

require_once('class/agenda_funciones.php');
error_reporting(0);
$agenda = new Agenda();

if(isset($_POST['insertar'])){
    $categoria = $_POST['categoria'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $responsable = $_POST['responsable'];
    $editado = $_POST[0];
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $resultado = $agenda->insertar_tarea($categoria, $titulo, $descripcion, $responsable, $editado, $fecha, $estado, $hora_inicio, $hora_fin);
    if($resultado){
        echo "Tarea insertada correctamente";
    }else{
        echo "Error al insertar la tarea";
    }
}

?>
    
    

</body>
</html>