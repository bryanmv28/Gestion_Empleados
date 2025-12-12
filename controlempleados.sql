-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2025 a las 07:35:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `controlempleados`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_asistencia` (IN `p_cedula` VARCHAR(20), IN `p_fecha` DATE, IN `p_hora_entrada` TIME, IN `p_observaciones` TEXT)   BEGIN
    DECLARE v_id_empleado INT;
    
    -- Buscar el empleado por cédula
    SELECT id_empleado INTO v_id_empleado 
    FROM empleados 
    WHERE cedula = p_cedula AND estado = 1
    LIMIT 1;
    
    IF v_id_empleado IS NOT NULL THEN
        -- Insertar o actualizar asistencia
        INSERT INTO asistencia (id_empleado, fecha, hora_entrada, observaciones)
        VALUES (v_id_empleado, p_fecha, p_hora_entrada, p_observaciones)
        ON DUPLICATE KEY UPDATE 
            hora_entrada = p_hora_entrada,
            observaciones = p_observaciones;
            
        SELECT 'OK' as resultado, 'Asistencia registrada correctamente' as mensaje;
    ELSE
        SELECT 'ERROR' as resultado, 'Empleado no encontrado o inactivo' as mensaje;
    END IF;
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_dias_trabajados` (`p_id_empleado` INT, `p_mes` INT, `p_anio` INT) RETURNS INT(11) DETERMINISTIC BEGIN
    DECLARE v_dias INT;
    
    SELECT COUNT(*) INTO v_dias
    FROM asistencia
    WHERE id_empleado = p_id_empleado
    AND MONTH(fecha) = p_mes
    AND YEAR(fecha) = p_anio;
    
    RETURN v_dias;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_asistencia` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id_asistencia`, `id_empleado`, `fecha`, `hora_entrada`, `hora_salida`, `observaciones`, `fecha_registro`) VALUES
(1, 1, '2024-12-02', '08:00:00', '17:00:00', NULL, '2025-12-12 06:23:11'),
(2, 2, '2024-12-02', '08:15:00', '17:30:00', NULL, '2025-12-12 06:23:11'),
(3, 3, '2024-12-02', '08:05:00', '17:15:00', NULL, '2025-12-12 06:23:11'),
(4, 4, '2024-12-02', '08:10:00', '17:00:00', NULL, '2025-12-12 06:23:11'),
(5, 5, '2024-12-02', '08:20:00', '17:45:00', NULL, '2025-12-12 06:23:11'),
(6, 6, '2024-12-02', '07:55:00', '17:00:00', NULL, '2025-12-12 06:23:11'),
(7, 7, '2024-12-02', '08:00:00', '17:20:00', NULL, '2025-12-12 06:23:11'),
(8, 8, '2024-12-02', '08:30:00', '17:00:00', 'Llegada tarde por tráfico', '2025-12-12 06:23:11'),
(9, 1, '2024-12-09', '08:00:00', '17:00:00', NULL, '2025-12-12 06:23:11'),
(10, 2, '2024-12-09', '08:10:00', '17:25:00', NULL, '2025-12-12 06:23:11'),
(11, 3, '2024-12-09', '08:00:00', '17:00:00', NULL, '2025-12-12 06:23:11'),
(12, 4, '2024-12-09', '08:15:00', '17:10:00', NULL, '2025-12-12 06:23:11'),
(13, 5, '2024-12-09', '08:05:00', '17:30:00', NULL, '2025-12-12 06:23:11'),
(15, 7, '2024-12-09', '08:20:00', '17:15:00', NULL, '2025-12-12 06:23:11'),
(16, 1, '2025-12-12', '08:00:00', NULL, 'Presente', '2025-12-12 06:23:11'),
(17, 2, '2025-12-12', '08:15:00', NULL, 'Presente', '2025-12-12 06:23:11'),
(18, 3, '2025-12-12', '08:05:00', NULL, 'Presente', '2025-12-12 06:23:11'),
(19, 4, '2025-12-12', '08:10:00', NULL, 'Presente', '2025-12-12 06:23:11'),
(20, 5, '2025-12-12', '08:20:00', NULL, 'Presente', '2025-12-12 06:23:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL,
  `nombre_departamento` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(4) DEFAULT 1 COMMENT '1=Activo, 0=Inactivo',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `nombre_departamento`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(1, 'Recursos Humanos', 'Gestión del talento humano y procesos administrativos del personal', 1, '2025-12-12 06:23:11'),
(2, 'Tecnología', 'Desarrollo de software y soporte técnico', 1, '2025-12-12 06:23:11'),
(3, 'Ventas', 'Gestión comercial y atención al cliente', 1, '2025-12-12 06:23:11'),
(4, 'Administración', 'Gestión administrativa y financiera', 1, '2025-12-12 06:23:11'),
(5, 'Producción', 'Área de manufactura y producción', 1, '2025-12-12 06:23:11'),
(6, 'Marketing', 'Publicidad y estrategias de mercadeo', 1, '2025-12-12 06:23:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `estado` tinyint(4) DEFAULT 1 COMMENT '1=Activo, 0=Inactivo',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `cedula`, `id_departamento`, `cargo`, `fecha_ingreso`, `estado`, `fecha_creacion`) VALUES
(1, 'Juan', 'Pérez', '1234567890', 1, 'Gerente de RRHH', '2023-01-15', 1, '2025-12-12 06:23:11'),
(2, 'María', 'González', '0987654321', 2, 'Desarrolladora Senior', '2023-03-20', 1, '2025-12-12 06:23:11'),
(3, 'Carlos', 'López', '1122334455', 3, 'Ejecutivo de Ventas', '2023-05-10', 1, '2025-12-12 06:23:11'),
(4, 'Ana', 'Martínez', '5544332211', 4, 'Asistente Administrativa', '2023-06-01', 1, '2025-12-12 06:23:11'),
(5, 'Luis', 'Rodríguez', '6677889900', 2, 'Analista de Sistemas', '2023-07-15', 1, '2025-12-12 06:23:11'),
(6, 'Carmen', 'Sánchez', '9988776655', 5, 'Supervisor de Producción', '2023-08-20', 1, '2025-12-12 06:23:11'),
(7, 'Pedro', 'Torres', '3344556677', 6, 'Coordinador de Marketing', '2023-09-10', 1, '2025-12-12 06:23:11'),
(8, 'Laura', 'Ramírez', '7788990011', 1, 'Asistente de RRHH', '2023-10-05', 1, '2025-12-12 06:23:11');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_asistencias_completa`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_asistencias_completa` (
`id_asistencia` int(11)
,`fecha` date
,`hora_entrada` time
,`hora_salida` time
,`observaciones` text
,`id_empleado` int(11)
,`nombre_completo` varchar(101)
,`cedula` varchar(20)
,`cargo` varchar(100)
,`nombre_departamento` varchar(100)
,`horas_trabajadas` time
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_empleados_completa`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_empleados_completa` (
`id_empleado` int(11)
,`nombre` varchar(50)
,`apellido` varchar(50)
,`nombre_completo` varchar(101)
,`cedula` varchar(20)
,`cargo` varchar(100)
,`fecha_ingreso` date
,`estado` tinyint(4)
,`id_departamento` int(11)
,`nombre_departamento` varchar(100)
,`departamento_descripcion` text
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_asistencias_completa`
--
DROP TABLE IF EXISTS `vista_asistencias_completa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_asistencias_completa`  AS SELECT `a`.`id_asistencia` AS `id_asistencia`, `a`.`fecha` AS `fecha`, `a`.`hora_entrada` AS `hora_entrada`, `a`.`hora_salida` AS `hora_salida`, `a`.`observaciones` AS `observaciones`, `e`.`id_empleado` AS `id_empleado`, concat(`e`.`nombre`,' ',`e`.`apellido`) AS `nombre_completo`, `e`.`cedula` AS `cedula`, `e`.`cargo` AS `cargo`, `d`.`nombre_departamento` AS `nombre_departamento`, timediff(`a`.`hora_salida`,`a`.`hora_entrada`) AS `horas_trabajadas` FROM ((`asistencia` `a` join `empleados` `e` on(`a`.`id_empleado` = `e`.`id_empleado`)) join `departamentos` `d` on(`e`.`id_departamento` = `d`.`id_departamento`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_empleados_completa`
--
DROP TABLE IF EXISTS `vista_empleados_completa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_empleados_completa`  AS SELECT `e`.`id_empleado` AS `id_empleado`, `e`.`nombre` AS `nombre`, `e`.`apellido` AS `apellido`, concat(`e`.`nombre`,' ',`e`.`apellido`) AS `nombre_completo`, `e`.`cedula` AS `cedula`, `e`.`cargo` AS `cargo`, `e`.`fecha_ingreso` AS `fecha_ingreso`, `e`.`estado` AS `estado`, `d`.`id_departamento` AS `id_departamento`, `d`.`nombre_departamento` AS `nombre_departamento`, `d`.`descripcion` AS `departamento_descripcion` FROM (`empleados` `e` join `departamentos` `d` on(`e`.`id_departamento` = `d`.`id_departamento`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD UNIQUE KEY `unique_asistencia` (`id_empleado`,`fecha`),
  ADD KEY `idx_fecha` (`fecha`),
  ADD KEY `idx_empleado_fecha` (`id_empleado`,`fecha`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_nombre` (`nombre_departamento`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD KEY `idx_cedula` (`cedula`),
  ADD KEY `idx_departamento` (`id_departamento`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_nombre_completo` (`nombre`,`apellido`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
