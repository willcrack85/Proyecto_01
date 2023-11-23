<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checklist Tracker</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>
    <!-- colocar titulo al centro -->
    <div class="contenedor">
        <h1>Modificar Tarea</h1>
    </div>
    <br>
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


    <!-- tabla para mostrar las tareas -->
    <div class="contenedor">
        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Responsable</th>
                    <th>Editado</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Hora inicio</th>
                    <th>Hora fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>

</body>


<?php

require_once('class/agenda_funciones.php');
$agenda = new Agenda();
$tareas = $agenda->visualizar_tarea($_GET['id']);
$agenda = new Agenda();
$categorias = $agenda->obtener_categorias();
$agenda = new Agenda();
$estados = $agenda->obtener_estados();

foreach ($tareas as $tarea) {
  
 
?>

<form class="editar"  id="editar" action="actualizar.php">
    <td><input type="hidden" name="id" value="<?php echo $tarea['id']?>"></td>
    <tr>
    <td>
        <select name="categoria" id="categoria">
        <?php
        foreach ($categorias as $categoria) {
            echo "<option value='" . $categoria['id'] . "'";
            if ($categoria['id'] === $tarea['categoria_id']) {
                echo ' selected';
            }
            echo ">" . $categoria['categoria'] . "</option>";
        }
        ?>
        </select>
        
    </td>
    <td><input type="text" name="titulo" value="<?php echo $tarea['titulo']?>"></td>
    <td><input type='text' name='descripcion' value="<?php echo $tarea['descripcion'] ?>"></td>
    <td><input type="text" name="responsable" value="<?php echo $tarea['responsable']?>"></td>
    <td><input type="text" name="editado" value="<?php echo $tarea['editado']?>" readonly></td>
    <td><input type="date" name="fecha" value="<?php echo $tarea['fecha']?>"></td>
    <td><select name="estado" id="estado">
        <?php
        foreach ($estados as $estado) {
            echo "<option value='" . $estado['id'] . "'";
            if ($estado['id'] === $tarea['estado_id']) {
                echo ' selected';
            }
            echo ">" . $estado['estado'] . "</option>";
        }
        ?>
        </select></td>
    <td><input type="time" name="hora_inicio" value="<?php echo $tarea['hora_inicio']?>"></td>
    <td><input type="time" name="hora_fin" value="<?php echo $tarea['hora_fin']?>"></td>
    <td><input type="submit" value="actualizar"></td>
    </tr>
</form>
</html>

<?php
}
?>
