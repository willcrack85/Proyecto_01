<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checklist Tracker</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
<h1>Filtro de tareas</h1>
<div class="contenedor">
        <nav class="menu">
            
            <ul>
                <li><a href="agregar.php">Agregar Tarea</a></li>
                <li><a href="tareas.php">Mostrar Tareas</a></li>
                <li><a href="index.php">Buscar Tarea</a></li>
            </ul>
        </nav>
    </div>
    <br><br><br>
    <div class="container" id="caja">
    <h2>Para el filtro de fecha utilizar el formato 1999-10-27</h2>
    <Form name="Formfiltro" method="post" action="index.php">
        <br/>
        Filtrar Por: 
        <select name="campos">
                <option value="categoria">Categoría</option>
                <option value="estado">Estado</option>
                <option value="responsable">Responsable</option>
                <option value="dia">Día</option>
                <option value="mes">Mes</option>
                <option value="año">Año</option>
            </select>
       con el valor
        <input type="text" name="valor">
        <input name="ConsultarFiltro" value="Filtrar Datos" type="submit"/>
        <input name="ConsultarTodos" value="Ver Todos" type="submit"/>
        <!--<input name="generar_informe" type="submit" value="Generar Informe">-->
        

    </Form>
    </div>
    
    <?php
    require_once('class/agenda_funciones.php');


    $obj_agenda = new Agenda();
    $agenda = $obj_agenda->mostrar_tareas();
    error_reporting(0);

    if(array_key_exists('ConsultarTodos', $_POST)){
        $obj_agenda = new Agenda();
        $agenda = $obj_agenda->mostrar_tareas();
    }

    if(array_key_exists('ConsultarFiltro', $_POST)){
        $obj_agenda = new Agenda();
        $agenda = $obj_agenda->mostrar_tareas_filtro($_REQUEST['campos'], $_REQUEST['valor']);
    }
    
    if(array_key_exists('generar_informe', $_POST)){
        $obj_agenda = new Agenda();
        $agenda = $obj_agenda->mostrar_tareas_filtro($_REQUEST['campos'], $_REQUEST['valor']);
        $obj_agenda->generarInforme($agenda);
    }
    

    $nfilas=count($agenda);
    // si hay tareas mostrar mensaje
    if ($nfilas>0) {
        echo "<div class='contenedor'>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Categoria</th>";
        echo "<th>Titulo</th>";
        echo "<th>Descripcion</th>";
        echo "<th>Responsable</th>";
        echo "<th>Editado</th>";
        echo "<th>Fecha</th>";
        echo "<th>Estado</th>";
        echo "<th>Hora inicio</th>";
        echo "<th>Hora fin</th>";
        echo "<th>Acciones</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($agenda as $tarea) {
            echo "<tr>";
            echo "<td>" . $tarea['categoria'] . "</td>";
            echo "<td>" . $tarea['titulo'] . "</td>";
            echo "<td>" . $tarea['descripcion'] . "</td>";
            echo "<td>" . $tarea['responsable'] . "</td>";
            echo "<td>" . $tarea['editado'] . "</td>";
            echo "<td>" . $tarea['fecha'] . "</td>";
            echo "<td>" . $tarea['estado'] . "</td>";
            echo "<td>" . $tarea['hora_inicio'] . "</td>";
            echo "<td>" . $tarea['hora_fin'] . "</td>";
            echo "<td>";
            echo "<a href='editar.php?id=" . $tarea['id'] . "'>Editar</a>";
            echo " | ";
            echo "<a href='index.php?id=" . $tarea['id'] . "'>Eliminar</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='contenedor'>";
        echo "<h2>No hay tareas</h2>";
        echo "</div>";
    }

    //Eliminar tarea
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $obj_agenda = new Agenda();
        $obj_agenda->eliminar_tarea($id);
    }



    ?>

    
</body>
</html>