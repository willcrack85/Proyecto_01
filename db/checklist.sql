-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql.wccorp.duckdns.org
-- Tiempo de generación: 20-10-2023 a las 02:20:12
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-05:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `checklist`
--
DROP DATABASE IF EXISTS `db_checklist`;
CREATE DATABASE IF NOT EXISTS `db_checklist` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `db_checklist`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `actualizar_tarea`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `actualizar_tarea` (IN `p_id` INT, IN `p_categoria` VARCHAR(100), IN `p_titulo` VARCHAR(100), IN `p_descripcion` VARCHAR(200), IN `p_responsable` VARCHAR(100), IN `p_editado` INT(11), IN `p_fecha` DATE, IN `p_estado` VARCHAR(100), IN `p_hora_inicio` TIME, IN `p_hora_fin` TIME)   BEGIN
UPDATE tareas SET categoria_id = p_categoria, titulo = p_titulo, descripcion = p_descripcion, responsable = p_responsable, editado = p_editado=1, fecha = p_fecha, estado_id = p_estado, hora_inicio = p_hora_inicio, hora_fin = p_hora_fin WHERE id = p_id;
END$$

DROP PROCEDURE IF EXISTS `buscar_tarea`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `buscar_tarea` (IN `p_titulo` VARCHAR(100))   BEGIN
    SELECT * FROM tareas WHERE titulo = p_titulo;
END$$

DROP PROCEDURE IF EXISTS `eliminar_tarea`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `eliminar_tarea` (IN `p_id` INT)   BEGIN
DELETE FROM tareas WHERE id = p_id;
END$$

DROP PROCEDURE IF EXISTS `filtrar_tareas`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `filtrar_tareas` (IN `p_campo` VARCHAR(100), IN `p_valor` VARCHAR(100))   BEGIN
SET @s = CONCAT("SELECT t.id, c.categoria, t.titulo, t.descripcion, t.responsable, t.editado, t.fecha, e.estado, t.hora_inicio, t.hora_fin FROM tareas t JOIN categorias c ON t.categoria_id = c.id JOIN estados e ON t.estado_id = e.id WHERE ", p_campo, " LIKE CONCAT('%", p_valor, "%')");
PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$

DROP PROCEDURE IF EXISTS `filtrar_tareas2`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `filtrar_tareas2` (IN `p_campo` VARCHAR(100), IN `p_valor` VARCHAR(100))   BEGIN
  SET @s = CONCAT(
    "SELECT t.id, c.categoria, t.titulo, t.descripcion, t.responsable, t.editado, t.fecha, e.estado, t.hora_inicio, t.hora_fin
    FROM tareas t
    JOIN categorias c ON t.categoria_id = c.id
    JOIN estados e ON t.estado_id = e.id
    WHERE ",
    CASE
      WHEN p_campo = 'dia' THEN "DATE_FORMAT(t.fecha, '%Y-%m-%d')"
      WHEN p_campo = 'semana' THEN "DATE_FORMAT(t.fecha, '%X-%V')"
      WHEN p_campo = 'mes' THEN "DATE_FORMAT(t.fecha, '%Y-%m')"
      WHEN p_campo = 'año' THEN "DATE_FORMAT(t.fecha, '%Y')"
      ELSE "1" -- Si el campo de búsqueda no coincide con día, semana, mes o año, se seleccionarán todos los registros.
    END,
    " LIKE CONCAT('%", p_valor, "%')"
  );

  PREPARE stmt FROM @s;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END$$

DROP PROCEDURE IF EXISTS `insertar_tare`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `insertar_tarea` (IN `p_categoria_id` INT, IN `p_titulo` VARCHAR(255), IN `p_descripcion` TEXT, IN `p_responsable` VARCHAR(255), IN `p_editado` DATETIME, IN `p_fecha` DATE, IN `p_estado_id` INT, IN `p_hora_inicio` TIME, IN `p_hora_fin` TIME)   BEGIN
    INSERT INTO `tareas` (`categoria_id`, `titulo`, `descripcion`, `responsable`, `editado`, `fecha`, `estado_id`, `Hora_inicio`, `Hora_fin`)
    VALUES (p_categoria_id, p_titulo, p_descripcion, p_responsable, p_editado, p_fecha, p_estado_id, p_hora_inicio, p_hora_fin);
END$$

DROP PROCEDURE IF EXISTS `mostrar_tareas`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `mostrar_tareas` ()   BEGIN
SELECT t.id, c.categoria, t.titulo, t.descripcion, t.responsable, t.editado, t.fecha, e.estado, t.hora_inicio, t.hora_fin FROM tareas t JOIN categorias c ON t.categoria_id = c.id JOIN estados e ON t.estado_id = e.id;
END$$

DROP PROCEDURE IF EXISTS `mostrar_tareas_fecha`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `mostrar_tareas_fecha` (IN `p_fecha` DATE)   BEGIN
SELECT t.id, c.categoria, t.titulo, t.descripcion, t.responsable, t.editado, t.fecha, e.estado, t.hora_inicio, t.hora_fin FROM tareas t JOIN categorias c ON t.categoria_id = c.id JOIN estados e ON t.estado_id = e.id WHERE fecha = p_fecha;
END$$

DROP PROCEDURE IF EXISTS `mostrar_tareas_hoy2`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `mostrar_tareas_hoy2` (IN `p_fecha` DATE)   BEGIN
SELECT t.id, c.categoria, t.titulo, t.descripcion, t.responsable, t.editado, t.fecha, e.estado, t.hora_inicio, t.hora_fin FROM tareas t JOIN categorias c ON t.categoria_id = c.id JOIN estados e ON t.estado_id = e.id WHERE t.fecha = p_fecha;
END$$

DROP PROCEDURE IF EXISTS `obtener_categorias`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `obtener_categorias` ()   BEGIN
    SELECT * FROM categorias;
END$$

DROP PROCEDURE IF EXISTS `obtener_estados`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `obtener_estados` ()   BEGIN
    SELECT * FROM estados;
END$$

DROP PROCEDURE IF EXISTS `validar_titulo`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `validar_titulo` (IN `p_titulo` VARCHAR(100))   BEGIN
IF (SELECT COUNT(*) FROM tareas WHERE titulo = p_titulo) > 0 THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El titulo ya existe';
END IF;
END$$

DROP PROCEDURE IF EXISTS `verificar_tarea`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `verificar_tarea` (IN `p_titulo` VARCHAR(100))   BEGIN
SELECT * FROM tareas WHERE titulo = p_titulo;
END$$

DROP PROCEDURE IF EXISTS `visualizar_tarea`$$
CREATE DEFINER=`willcrackcorp`@`localhost` PROCEDURE `visualizar_tarea` (IN `p_id` INT)   BEGIN
SELECT * FROM tareas WHERE id = p_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'Trabajo'),
(2, 'Personal'),
(3, 'Escolar'),
(4, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `estado`) VALUES
(1, 'Por Hacer'),
(2, 'En progreso'),
(3, 'Terminada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

DROP TABLE IF EXISTS `tareas`;
CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `editado` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `categoria_id`, `titulo`, `descripcion`, `responsable`, `editado`, `fecha`, `estado_id`, `hora_inicio`, `hora_fin`) VALUES
(1, 3, 'Proyecto 1', 'Primer proyecto de la materia DS7. Listo para presentar', 'Angelo Guillen', 0, '2023-10-25', 1, '20:20:00', '21:45:00'),
(3, 2, 'a', 'a', 'a', 0, '2023-10-26', 2, '09:30:00', '11:30:00'),
(4, 1, 'b', 'b', 'b', 0, '2023-10-26', 2, '19:06:00', '20:10:00'),
(5, 3, 'c', 'c', 'Angelo Guillen', 0, '2023-10-28', 3, '21:25:00', '13:19:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `estado_id` (`estado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
