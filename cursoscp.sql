-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-02-2026 a las 12:12:55
-- Versión del servidor: 8.0.45-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cursoscp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `dni` varchar(9) NOT NULL,
  `pass` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`dni`, `pass`) VALUES
('11111111A', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `codigo` smallint NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `abierto` tinyint(1) NOT NULL DEFAULT '1',
  `numeroplazas` smallint NOT NULL DEFAULT '20',
  `plazoinscripcion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`codigo`, `nombre`, `abierto`, `numeroplazas`, `plazoinscripcion`) VALUES
(1, 'Instalacion y uso de Apache', 0, 0, '2015-05-20'),
(2, 'Administracion avanzada de Apache', 1, 30, '2015-05-20'),
(3, 'Elaboracion de recursos didacticos', 1, 20, '2015-05-20'),
(4, 'Uso didactico de Moodle en primaria', 1, 10, '2015-05-20'),
(5, 'Uso didactico de Moodle en secundaria', 0, 20, '2015-01-20'),
(6, 'Moodle y el aula de musica', 1, 20, '2015-05-25'),
(7, 'Tratamiento de imagenes', 0, 20, '2015-02-20'),
(8, 'Seguridad en servidores Nginx', 1, 7, '2026-02-03'),
(9, 'Introducción a Docker y Contenedores', 1, 11, '2026-02-03'),
(10, 'Gestión de bases de datos PostgreSQL', 0, 40, '2026-02-03'),
(11, 'Desarrollo de APIs con Python', 1, 29, '2026-02-03'),
(12, 'Fundamentos de Inteligencia Artificial', 1, 20, '2026-02-03'),
(13, 'Curso de TIgueraje', 0, 5, '2026-02-05'),
(14, 'Curso de Cosas guays', 0, 7, '2026-02-06'),
(15, 'Curso de Cosas guays', 0, 7, '2026-02-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitantes`
--

CREATE TABLE `solicitantes` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `apellidos` varchar(40) NOT NULL DEFAULT '',
  `nombre` varchar(20) NOT NULL DEFAULT '',
  `telefono` varchar(12) NOT NULL DEFAULT '',
  `correo` varchar(50) NOT NULL DEFAULT '',
  `codcen` varchar(8) NOT NULL DEFAULT '',
  `coordinadortic` tinyint(1) NOT NULL DEFAULT '0',
  `grupotic` tinyint(1) NOT NULL DEFAULT '0',
  `nomgrupo` varchar(25) NOT NULL DEFAULT '',
  `pbilin` tinyint(1) NOT NULL DEFAULT '0',
  `cargo` tinyint(1) NOT NULL DEFAULT '0',
  `nombrecargo` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `situacion` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fechanac` date DEFAULT NULL,
  `especialidad` varchar(50) NOT NULL DEFAULT '',
  `puntos` tinyint UNSIGNED DEFAULT '0',
  `pass` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `solicitantes`
--

INSERT INTO `solicitantes` (`dni`, `apellidos`, `nombre`, `telefono`, `correo`, `codcen`, `coordinadortic`, `grupotic`, `nomgrupo`, `pbilin`, `cargo`, `nombrecargo`, `situacion`, `fechanac`, `especialidad`, `puntos`, `pass`) VALUES
('00112233T', 'Vila Mata', 'Cristina', '699111333', 'cristina.vi@edu.es', 'CEN005', 0, 0, 'Primaria-A', 0, 0, 'Interina', 'activo', '1996-11-11', 'Primaria', 2, 'prim00'),
('01234567J', 'Ortiz Bravo', 'Nerea', '699000111', 'nerea.ort@edu.es', 'CEN002', 0, 0, 'Sin asignar', 0, 0, 'Sustituta', 'inactivo', '1997-04-05', 'Dibujo', 1, 'art97'),
('11111111A', 'Castellanos Lopez', 'David', '123 45 67 89', 'david.castellanos2@educa.madrid.org', '28300', 1, 1, 'GrupoDavid', 1, 0, '', 'activo', '2026-02-05', 'Informatica', 11, '1234'),
('11223344C', 'Martín Ruíz', 'Elena', '622334455', 'emartin@ejemplo.com', '28005678', 0, 1, 'Grupo B', 0, 0, '', 'inactivo', NULL, 'Inglés', 3, 'clave03'),
('11223344K', 'Blanco Diez', 'Jorge', '600222444', 'jorge.bla@edu.es', 'CEN006', 1, 1, 'Coordinación', 1, 1, 'Director', 'activo', '1975-01-25', 'Historia', 14, 'hist11'),
('12345678A', 'García López', 'María', '600112233', 'mgarcia@ejemplo.com', '28001234', 1, 1, 'Innovación', 0, 1, 'Coordinador', 'activo', '1985-05-15', 'Informática', 9, 'clave01'),
('22334455L', 'Rubio Cano', 'Marta', '611333555', 'marta.rub@edu.es', 'CEN004', 0, 0, '-', 0, 2, 'Jefa de Estudios', 'activo', '1983-10-18', 'Química', 2, 'chem22'),
('23456789B', 'López Martínez', 'Ana', '611222333', 'ana.lopez@edu.es', 'CEN002', 0, 1, 'Grupo A', 0, 2, 'Jefa de Estudios', 'activo', '1990-08-23', 'Lengua', 5, 'clave456'),
('33445566M', 'Marín Pozo', 'Raúl', '622444666', 'raul.mar@edu.es', 'CEN001', 0, 1, 'Grupo B', 1, 0, 'Profesor', 'activo', '1987-05-30', 'Tecnología', 8, 'tecno33'),
('34567890C', 'Sánchez Ruiz', 'Carlos', '622333444', 'carlos.san@edu.es', 'CEN001', 0, 0, 'Ninguno', 1, 0, 'Profesor', 'activo', '1978-11-30', 'Inglés', 5, 'user789'),
('44556677N', 'Núñez Alba', 'Irene', '633555777', 'irene.nun@edu.es', 'CEN005', 0, 0, 'Letras', 0, 0, 'Profesora', 'inactivo', '1993-08-12', 'Filosofía', 1, 'filo44'),
('45678901D', 'Rodríguez Gil', 'Elena', '633444555', 'elena.rod@edu.es', 'CEN003', 1, 1, 'TIC-Primaria', 0, 0, 'Profesora', 'activo', '1992-02-15', 'Primaria', 9, 'mypass01'),
('55667788O', 'Vega Soto', 'Alberto', '644666888', 'alberto.ve@edu.es', 'CEN003', 1, 0, 'Digital', 1, 3, 'Secretario', 'activo', '1979-12-03', 'Economía', 9, 'econ55'),
('56789012E', 'Fernández Sanz', 'Pedro', '644555666', 'pedro.fer@edu.es', 'CEN002', 0, 0, '-', 0, 3, 'Secretario', 'activo', '1982-07-04', 'Geografía', 2, 'admin02'),
('66778899P', 'Pascual Cid', 'Sofía', '655777999', 'sofia.pas@edu.es', 'CEN006', 0, 0, 'Idiomas', 1, 0, 'Profesora', 'activo', '1986-02-28', 'Francés', 5, 'fra66'),
('6767A', 'Solis Torrijos', 'Hugo', '1234', '1234', '124', 0, 1, 'Oreiudos', 1, 1, 'Jefe De Estudios', 'activo', '2026-02-06', 'Informatica', 9, '1234'),
('67890123F', 'Gómez Hierro', 'Lucía', '655666777', 'lucia.gom@edu.es', 'CEN004', 0, 0, 'Pendiente', 1, 0, 'Interina', 'inactivo', '1995-12-01', 'Física', 4, 'lucia95'),
('77777777A', 'García Pérez', 'Juan', '600111222', 'juan.garcia@edu.es', 'CEN001', 1, 0, 'General', 1, 1, 'Director', 'activo', '1985-05-12', 'Matemáticas', 11, 'pass123'),
('77889900Q', 'Herrero Saez', 'Óscar', '666888000', 'oscar.her@edu.es', 'CEN002', 0, 1, 'TIC-Secund', 0, 0, 'Profesor', 'activo', '1984-06-22', 'Informática', 5, 'info77'),
('78901234G', 'Molina Soler', 'Marcos', '666777888', 'marcos.mol@edu.es', 'CEN001', 1, 0, 'Innovación', 1, 0, 'Profesor', 'activo', '1988-03-20', 'Biología', 9, 'biol88'),
('87654321B', 'Sánchez Pérez', 'Juan', '611223344', 'jsanchez@ejemplo.com', '28001234', 0, 0, '', 1, 0, '', 'activo', '1992-03-20', 'Matemáticas', 5, 'clave02'),
('88990011R', 'Lorenzo Mas', 'Paula', '677999111', 'paula.lor@edu.es', 'CEN004', 1, 1, 'Calidad', 0, 0, 'Profesora', 'activo', '1994-03-09', 'Religión', 9, 'rel88'),
('89012345H', 'Vázquez Lara', 'Sara', '677888999', 'sara.vaz@edu.es', 'CEN005', 0, 1, 'Bilingüe', 1, 0, 'Profesora', 'activo', '1991-06-10', 'Música', 8, 'musica7'),
('90123456I', 'Castro Ríos', 'David', '688999000', 'david.cas@edu.es', 'CEN003', 0, 0, 'Default', 0, 0, 'Profesor', 'activo', '1980-09-14', 'Educación Física', 2, 'fit2026'),
('99001122S', 'Cano Rius', 'Miguel', '688000222', 'miguel.can@edu.es', 'CEN001', 0, 0, 'Clásicas', 1, 0, 'Profesor', 'activo', '1981-07-17', 'Latín', 5, 'lat99'),
('a', 'a', 'a', 'a', 'a', 'a', 1, 1, 'a', 1, 0, '', 'activo', '2026-02-05', 'a', 11, 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `codigocurso` smallint NOT NULL DEFAULT '0',
  `fechasolicitud` date NOT NULL,
  `admitido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`dni`, `codigocurso`, `fechasolicitud`, `admitido`) VALUES
('67890123F', 8, '2026-02-03', 1),
('67890123F', 9, '2026-02-03', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `solicitantes`
--
ALTER TABLE `solicitantes`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`dni`,`codigocurso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `codigo` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
