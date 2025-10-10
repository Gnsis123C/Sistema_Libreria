-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-05-2025 a las 02:47:15
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
  `idproducto` int NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `precio_pvp` float NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `stock` int NOT NULL,
  `imagen_principal` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`idatributo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `marca` (
  `idmarca` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `imagen` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`idmarca`)
)

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `idempresa`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'CUADERNO', '1', '2025-04-23 10:38:44', '2025-04-23 15:39:45', NULL),
(2, 1, 'CUADERNO PEQUEñO', '1', '2025-05-04 21:39:35', '2025-05-04 21:39:35', NULL);

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
  `descripcion` varchar(400) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `tipo` varchar(2) NOT NULL DEFAULT 's',
  PRIMARY KEY (`idproducto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
