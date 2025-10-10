-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 31-05-2025 a las 22:36:57
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `multiples-inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributo`
--

DROP TABLE IF EXISTS `atributo`;
CREATE TABLE IF NOT EXISTS `atributo` (
  `idatributo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `idempresa` int NOT NULL,
  PRIMARY KEY (`idatributo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `atributo`
--

INSERT INTO `atributo` (`idatributo`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`, `idempresa`) VALUES
(1, 'MARCA', '1', '2025-05-05 22:26:52', '2025-05-17 17:07:34', NULL, 1),
(2, 'TAMAÑO', '1', '2025-05-05 22:28:11', '2025-05-17 17:07:47', NULL, 1),
(3, 'TIPO DE CUADERNO', '1', '2025-05-05 22:29:39', '2025-05-17 17:08:15', NULL, 1),
(4, 'NÚMERO DE HOJA', '1', '2025-05-05 22:30:25', '2025-05-31 17:24:04', NULL, 1),
(5, 'TIPO DE HOJA', '1', '2025-05-13 22:27:05', '2025-05-31 17:24:25', NULL, 1),
(6, 'GÉNERO', '1', '2025-05-31 17:30:30', '2025-05-31 17:30:30', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributoproducto`
--

DROP TABLE IF EXISTS `atributoproducto`;
CREATE TABLE IF NOT EXISTS `atributoproducto` (
  `idatributoproducto` int NOT NULL AUTO_INCREMENT,
  `idproducto` int NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `precio_pvp` float NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `idvaloratributo` int DEFAULT NULL,
  PRIMARY KEY (`idatributoproducto`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `atributoproducto`
--

INSERT INTO `atributoproducto` (`idatributoproducto`, `idproducto`, `estado`, `precio_pvp`, `created_at`, `updated_at`, `deleted_at`, `idvaloratributo`) VALUES
(4, 17, '1', 0, '2025-05-27 14:10:09', '2025-05-27 14:10:09', NULL, 4),
(3, 17, '1', 0, '2025-05-27 14:10:09', '2025-05-27 14:10:09', NULL, 3),
(5, 18, '1', 0, '2025-05-31 12:26:26', '2025-05-31 17:22:24', '2025-05-31 17:22:24', 3),
(6, 18, '1', 0, '2025-05-31 12:26:26', '2025-05-31 17:22:24', '2025-05-31 17:22:24', 4),
(7, 18, '1', 0, '2025-05-31 12:26:26', '2025-05-31 17:22:24', '2025-05-31 17:22:24', 5),
(8, 18, '1', 0, '2025-05-31 12:26:26', '2025-05-31 17:22:24', '2025-05-31 17:22:24', 6),
(9, 18, '1', 0, '2025-05-31 12:26:26', '2025-05-31 17:22:24', '2025-05-31 17:22:24', 7),
(10, 18, '1', 0, '2025-05-31 12:26:26', '2025-05-31 17:22:24', '2025-05-31 17:22:24', 8),
(11, 18, '1', 0, '2025-05-31 12:26:26', '2025-05-31 17:22:24', '2025-05-31 17:22:24', 9),
(12, 18, '1', 0, '2025-05-31 17:22:24', '2025-05-31 17:22:39', '2025-05-31 17:22:39', 3),
(13, 18, '1', 0, '2025-05-31 17:22:24', '2025-05-31 17:22:39', '2025-05-31 17:22:39', 4),
(14, 18, '1', 0, '2025-05-31 17:22:24', '2025-05-31 17:22:39', '2025-05-31 17:22:39', 6),
(15, 18, '1', 0, '2025-05-31 17:22:24', '2025-05-31 17:22:39', '2025-05-31 17:22:39', 7),
(16, 18, '1', 0, '2025-05-31 17:22:24', '2025-05-31 17:22:39', '2025-05-31 17:22:39', 8),
(17, 18, '1', 0, '2025-05-31 17:22:24', '2025-05-31 17:22:39', '2025-05-31 17:22:39', 9),
(18, 18, '1', 0, '2025-05-31 17:22:24', '2025-05-31 17:22:39', '2025-05-31 17:22:39', 5),
(19, 18, '1', 0, '2025-05-31 17:22:24', '2025-05-31 17:22:39', '2025-05-31 17:22:39', 10),
(20, 18, '1', 0, '2025-05-31 17:22:39', '2025-05-31 17:22:39', NULL, 3),
(21, 18, '1', 0, '2025-05-31 17:22:39', '2025-05-31 17:22:39', NULL, 4),
(22, 18, '1', 0, '2025-05-31 17:22:39', '2025-05-31 17:22:39', NULL, 6),
(23, 18, '1', 0, '2025-05-31 17:22:39', '2025-05-31 17:22:39', NULL, 7),
(24, 18, '1', 0, '2025-05-31 17:22:39', '2025-05-31 17:22:39', NULL, 8),
(25, 18, '1', 0, '2025-05-31 17:22:39', '2025-05-31 17:22:39', NULL, 9),
(26, 19, '1', 0, '2025-05-31 17:35:38', '2025-05-31 17:35:38', NULL, 11),
(27, 19, '1', 0, '2025-05-31 17:35:38', '2025-05-31 17:35:38', NULL, 12),
(28, 19, '1', 0, '2025-05-31 17:35:38', '2025-05-31 17:35:38', NULL, 13),
(29, 19, '1', 0, '2025-05-31 17:35:38', '2025-05-31 17:35:38', NULL, 14),
(30, 19, '1', 0, '2025-05-31 17:35:38', '2025-05-31 17:35:38', NULL, 15),
(31, 19, '1', 0, '2025-05-31 17:35:38', '2025-05-31 17:35:38', NULL, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcategoria` int NOT NULL AUTO_INCREMENT,
  `idempresa` int NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `idempresa`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'NORMA', '1', '2025-04-23 10:38:44', '2025-05-16 22:44:17', NULL),
(2, 1, 'CUADERNO', '1', '2025-05-04 21:39:35', '2025-05-31 17:32:26', NULL),
(3, 1, 'CUADERNO DE 100 HOJAS', '1', '2025-05-31 17:32:15', '2025-05-31 17:32:15', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `idcliente` int NOT NULL AUTO_INCREMENT,
  `idempresa` int NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `ci` varchar(50) NOT NULL DEFAULT '',
  `tipo` varchar(2) NOT NULL DEFAULT '1',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `idempresa`, `nombre`, `ci`, `tipo`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'CARLOS', '0942096470', '0', '1', '2025-04-22 12:09:45', '2025-04-22 21:03:45', NULL),
(2, 1, 'MARINA', '2222222222', '1', '1', '2025-04-23 10:40:16', '2025-04-23 10:40:16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `idcompra` int NOT NULL AUTO_INCREMENT,
  `idempresa` int NOT NULL,
  `idcliente` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idcompra`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detcompra`
--

DROP TABLE IF EXISTS `detcompra`;
CREATE TABLE IF NOT EXISTS `detcompra` (
  `iddetcompra` int NOT NULL AUTO_INCREMENT,
  `idcompra` int NOT NULL,
  `idproducto` int NOT NULL,
  `precio` float NOT NULL DEFAULT '0',
  `iva` float NOT NULL DEFAULT '0',
  `cantidad` int NOT NULL DEFAULT '0',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetcompra`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detrol`
--

DROP TABLE IF EXISTS `detrol`;
CREATE TABLE IF NOT EXISTS `detrol` (
  `iddetrol` int NOT NULL AUTO_INCREMENT,
  `idrol` int NOT NULL,
  `idpagina` int NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `leer` varchar(2) NOT NULL DEFAULT '1',
  `actualizar` varchar(2) NOT NULL DEFAULT '1',
  `editar` varchar(2) NOT NULL DEFAULT '1',
  `crear` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetrol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detventa`
--

DROP TABLE IF EXISTS `detventa`;
CREATE TABLE IF NOT EXISTS `detventa` (
  `iddetventa` int NOT NULL AUTO_INCREMENT,
  `idventa` int NOT NULL,
  `idproducto` int NOT NULL,
  `precio` float NOT NULL DEFAULT '0',
  `iva` float NOT NULL DEFAULT '0',
  `cantidad` int NOT NULL DEFAULT '0',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetventa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `idempresa` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `direccion` varchar(200) NOT NULL DEFAULT '',
  `logo` varchar(400) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idempresa`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `nombre`, `direccion`, `logo`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ROJANO DEV', 'MILAGRO', 'logo-cr-svg-blanco.svg?v=1', '1', NULL, '2025-04-22 21:04:06', NULL),
(2, 'SADSAD', 'SADASD', 'logo-cr-svg-blanco.svg?v=1', '0', '2025-04-06 17:30:30', '2025-04-07 22:43:18', '2025-04-07 22:43:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagina`
--

DROP TABLE IF EXISTS `pagina`;
CREATE TABLE IF NOT EXISTS `pagina` (
  `idpagina` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idpagina`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `idproducto` int NOT NULL AUTO_INCREMENT,
  `idcategoria` int NOT NULL,
  `idempresa` int NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `pvp` float NOT NULL DEFAULT '0',
  `stock` int NOT NULL DEFAULT '0',
  `imagen` varchar(400) NOT NULL DEFAULT '',
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `tipo` varchar(2) NOT NULL DEFAULT 's',
  `slug` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idproducto`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `idcategoria`, `idempresa`, `nombre`, `pvp`, `stock`, `imagen`, `descripcion`, `estado`, `created_at`, `updated_at`, `deleted_at`, `tipo`, `slug`) VALUES
(18, 2, 1, 'PRUEBA CON MAS ATRIBUTOS 3', 0.77, 0, 'uploads/2025/05/31/trans_imagen_recortada_683b3bb2bafbd.png', '<p>Prueba</p>', '1', '2025-05-31 12:26:26', '2025-05-31 22:30:37', '2025-05-31 22:30:37', 's', NULL),
(17, 2, 1, 'CUADERNO DE PRUEBA', 0.77, 0, 'uploads/2025/05/27/trans_imagen_recortada_68360e04873f7.png', '<p>fdgdk gjh <font color=\"#000000\" style=\"background-color: rgb(255, 255, 0);\">jgfhkfgk </font>hfg</p>', '1', '2025-05-27 14:10:09', '2025-05-31 22:30:40', '2025-05-31 22:30:40', 's', NULL),
(16, 2, 1, 'CUADERNO PRUEBA', 0.77, 0, 'uploads/2025/05/27/trans_imagen_recortada_6835fa83a30b5.png', '<p>saasdasedsd<b>sddd</b></p>', '1', '2025-05-27 12:46:56', '2025-05-31 22:30:43', '2025-05-31 22:30:43', 's', NULL),
(19, 2, 1, 'CUADERNO DE CUADROS DE 100 HOJAS', 0.77, 0, 'uploads/2025/05/31/trans_imagen_recortada_683b842a8be79.png', '<p>¡Descubre el cuaderno perfecto para tus ideas!</p><p>📘 Cuaderno de Cuadros Grande – 100 hojas de papel de alta calidad con espiral resistente.</p><p>✨ Ideal para:</p><p>✔️ Estudiantes (¡perfecto para matemáticas y dibujo técnico!)</p><p>✔️ Profesionales (organiza tus proyectos con claridad)</p><p>✔️ Creativos (diseña, bosqueja y plasma tus ideas)</p><p>📏 Cuadrícula grande – Más espacio para escribir y dibujar con comodidad.</p><p>🌀 Encuadernación espiral – Se abre completamente y es fácil de usar.</p><p>¡Dale vida a tus ideas con este cuaderno versátil y duradero! 🚀</p>', '1', '2025-05-31 17:35:38', '2025-05-31 17:35:38', NULL, 's', NULL),
(15, 2, 1, 'CUADERNO GRANDE, GOAT 100', 0.77, 0, 'uploads/2025/05/27/trans_imagen_recortada_6835e0bc0c056.png', '<p>Esto es una <u>prueba</u></p>', '1', '2025-05-27 10:57:03', '2025-05-31 22:30:46', '2025-05-31 22:30:46', 's', NULL),
(14, 1, 1, 'CUADERNO GRANDE, GOAT 100H', 0.77, 0, 'uploads/2025/05/17/trans_imagen_recortada_682905c8efb09.png', '<p>Descripción de <b>imagen</b></p>', '1', '2025-05-17 16:55:35', '2025-05-31 22:30:50', '2025-05-31 22:30:50', 's', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `idrol` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'super_admin', '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `idempresa` int NOT NULL,
  `idrol` int NOT NULL,
  `usuario` varchar(200) NOT NULL DEFAULT '',
  `pass` varchar(400) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `logo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'logo-cr-svg-blanco.svg',
  PRIMARY KEY (`idusuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `idempresa`, `idrol`, `usuario`, `pass`, `email`, `estado`, `created_at`, `updated_at`, `deleted_at`, `logo`) VALUES
(1, 1, 1, 'super_admin', '$2y$10$K5CMP.hTMX1mo9KOckxOTOqB5irDZTzx44apXc/e4hFbWOQS5RptC', 'c.rojano.95@gmail.com', '1', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoratributo`
--

DROP TABLE IF EXISTS `valoratributo`;
CREATE TABLE IF NOT EXISTS `valoratributo` (
  `idvaloratributo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `idatributo` int DEFAULT NULL,
  PRIMARY KEY (`idvaloratributo`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `valoratributo`
--

INSERT INTO `valoratributo` (`idvaloratributo`, `nombre`, `deleted_at`, `updated_at`, `created_at`, `idatributo`) VALUES
(4, 'PELIKAN', NULL, '2025-05-27 14:10:09', '2025-05-27 14:10:09', 1),
(3, 'NORMA', NULL, '2025-05-27 14:10:09', '2025-05-27 14:10:09', 1),
(5, 'MASCULINO', NULL, '2025-05-31 12:26:26', '2025-05-31 12:26:26', 4),
(6, 'X', NULL, '2025-05-31 12:26:26', '2025-05-31 12:26:26', 2),
(7, 'XXL', NULL, '2025-05-31 12:26:26', '2025-05-31 12:26:26', 2),
(8, 'L', NULL, '2025-05-31 12:26:26', '2025-05-31 12:26:26', 2),
(9, 'XS', NULL, '2025-05-31 12:26:26', '2025-05-31 12:26:26', 2),
(10, 'FEMENINO', NULL, '2025-05-31 17:22:24', '2025-05-31 17:22:24', 4),
(11, 'MASCULINO', NULL, '2025-05-31 17:35:38', '2025-05-31 17:35:38', 6),
(12, 'MIS APUNTES', NULL, '2025-05-31 17:35:38', '2025-05-31 17:35:38', 1),
(13, '100', NULL, '2025-05-31 17:35:38', '2025-05-31 17:35:38', 4),
(14, 'GRANDE', NULL, '2025-05-31 17:35:38', '2025-05-31 17:35:38', 2),
(15, 'ESPIRAL', NULL, '2025-05-31 17:35:38', '2025-05-31 17:35:38', 3),
(16, 'CUADROS', NULL, '2025-05-31 17:35:38', '2025-05-31 17:35:38', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `idventa` int NOT NULL AUTO_INCREMENT,
  `idempresa` int NOT NULL,
  `idcliente` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `n_factura` varchar(50) NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
