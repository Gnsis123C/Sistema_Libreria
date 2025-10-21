-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-10-2025 a las 03:33:17
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_libreria`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_crear_accesos_rol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_accesos_rol` (IN `p_id_rol` INT)   BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_idpagina INT;
    DECLARE v_idpermiso INT;
    DECLARE v_idrol_local INT;
    
    -- Declarar cursor para recorrer empleados del departamento
    DECLARE cur_permisos CURSOR FOR 
        SELECT idpagina
        FROM pagina 
        WHERE estado = 1;
    
    -- Declarar handler para cuando no hay más registros
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    -- Abrir cursor
    OPEN cur_permisos;
    
    -- Loop para recorrer cada empleado (simulando FOREACH)
    read_loop: LOOP
        FETCH cur_permisos INTO v_idpagina;
        
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET v_idrol_local = p_id_rol;
        
        -- Insertar detalle_rol por defecto para el nuevo rol
        INSERT INTO detalle_rol (idrol, idpagina, crear, leer, actualizar, eliminar, estado) VALUES (v_idrol_local, v_idpagina, 1, 1, 1, 1, 1);
        
    END LOOP;
    
    -- Cerrar cursor
    CLOSE cur_permisos;
    
END$$

DELIMITER ;

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
  PRIMARY KEY (`idatributo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `atributo`
--

INSERT INTO `atributo` (`idatributo`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MARCA', '1', '2025-10-17 12:03:48', '2025-10-17 12:03:48', NULL),
(2, 'SKU', '1', '2025-10-17 12:03:57', '2025-10-17 12:03:57', NULL),
(3, 'COLOR', '1', '2025-10-17 12:04:03', '2025-10-17 12:04:03', NULL),
(4, 'TAMAñO-DIMENSIONES', '1', '2025-10-17 12:04:17', '2025-10-17 12:04:17', NULL),
(5, 'MATERIAL', '1', '2025-10-17 12:04:23', '2025-10-17 12:04:23', NULL),
(6, 'PESO', '1', '2025-10-17 12:04:28', '2025-10-17 12:04:28', NULL),
(7, 'CóDIGO DE BARRAS', '1', '2025-10-17 12:04:50', '2025-10-17 12:04:50', NULL),
(8, 'MEDIA PUNTA', '1', '2025-10-18 09:36:04', '2025-10-18 09:36:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcategoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'LáPICES Y PORTAMINAS', '1', '2025-10-14 22:59:27', '2025-10-14 23:00:12', NULL),
(2, 'BOLíGRAFOS  ESFEROS', '1', '2025-10-14 23:01:09', '2025-10-14 23:01:09', NULL),
(3, 'MARCADORES Y RESALTADORES', '1', '2025-10-14 23:01:14', '2025-10-14 23:01:14', NULL),
(4, 'BORRADORES Y TAJADORES', '1', '2025-10-14 23:01:20', '2025-10-14 23:01:20', NULL),
(5, 'REGLAS Y ESCUADRAS', '1', '2025-10-14 23:01:25', '2025-10-14 23:01:25', NULL),
(6, 'CORRECTORES', '1', '2025-10-14 23:01:30', '2025-10-14 23:01:30', NULL),
(7, 'PEGAMENTOS Y CINTAS ADHESIVAS', '1', '2025-10-14 23:01:36', '2025-10-14 23:01:36', NULL),
(8, 'TIJERAS ESCOLARES', '1', '2025-10-14 23:01:41', '2025-10-14 23:01:41', NULL),
(9, 'JUEGOS GEOMéTRICOS', '1', '2025-10-14 23:01:46', '2025-10-14 23:01:46', NULL),
(10, 'CUADERNOS', '1', '2025-10-14 23:01:52', '2025-10-14 23:01:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `idcompra` int NOT NULL AUTO_INCREMENT,
  `idpersona` int NOT NULL,
  `idusuario` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idcompra`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `idpersona`, `idusuario`, `fecha`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, 1, '2025-10-20', '1', '2025-10-20 21:40:47', '2025-10-20 22:50:52', NULL),
(3, 2, 1, '2025-10-20', '1', '2025-10-20 21:41:22', '2025-10-20 21:41:22', NULL),
(4, 3, 1, '2025-10-20', '1', '2025-10-21 03:10:43', '2025-10-21 03:10:43', NULL),
(5, 3, 1, '2025-10-20', '1', '2025-10-21 03:31:34', '2025-10-21 03:31:34', NULL);

--
-- Disparadores `compra`
--
DROP TRIGGER IF EXISTS `ELIMINAR_DETALLE_COMPRA`;
DELIMITER $$
CREATE TRIGGER `ELIMINAR_DETALLE_COMPRA` AFTER DELETE ON `compra` FOR EACH ROW DELETE FROM detalle_compra WHERE idcompra = OLD.idcompra
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `editar_detalle_compra`;
DELIMITER $$
CREATE TRIGGER `editar_detalle_compra` AFTER UPDATE ON `compra` FOR EACH ROW BEGIN
    IF NEW.deleted_at IS NOT NULL THEN
        UPDATE detalle_compra 
        SET estado = 0 
        WHERE idcompra = NEW.idcompra;
    ELSEIF NEW.deleted_at IS NULL THEN
        UPDATE detalle_compra 
        SET estado = 1 
        WHERE idcompra = NEW.idcompra;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_atributo_producto`
--

DROP TABLE IF EXISTS `detalle_atributo_producto`;
CREATE TABLE IF NOT EXISTS `detalle_atributo_producto` (
  `iddetalle_atributo_producto` int NOT NULL AUTO_INCREMENT,
  `idvaloratributo` int NOT NULL,
  `idproducto` int NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetalle_atributo_producto`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalle_atributo_producto`
--

INSERT INTO `detalle_atributo_producto` (`iddetalle_atributo_producto`, `idvaloratributo`, `idproducto`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 2, '1', '2025-10-18 09:36:04', '2025-10-18 09:48:02', '2025-10-18 09:48:02'),
(2, 3, 2, '1', '2025-10-18 09:36:04', '2025-10-18 09:48:02', '2025-10-18 09:48:02'),
(3, 3, 2, '1', '2025-10-18 09:48:02', '2025-10-18 09:48:02', NULL),
(4, 1, 2, '1', '2025-10-18 09:48:02', '2025-10-18 09:48:02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

DROP TABLE IF EXISTS `detalle_compra`;
CREATE TABLE IF NOT EXISTS `detalle_compra` (
  `iddetalle_compra` int NOT NULL AUTO_INCREMENT,
  `idcompra` int NOT NULL,
  `idproducto` int NOT NULL,
  `precio_compra` float NOT NULL DEFAULT '0',
  `iva` float NOT NULL DEFAULT '0',
  `cantidad` int NOT NULL DEFAULT '0',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `venta_usado_cantidad` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`iddetalle_compra`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`iddetalle_compra`, `idcompra`, `idproducto`, `precio_compra`, `iva`, `cantidad`, `estado`, `created_at`, `updated_at`, `deleted_at`, `venta_usado_cantidad`) VALUES
(2, 2, 2, 1, 15, 3, '1', '2025-10-20 21:40:47', '2025-10-20 21:40:47', NULL, 0),
(3, 3, 2, 1.5, 15, 100, '1', '2025-10-20 21:41:22', '2025-10-20 21:41:22', NULL, 0),
(4, 4, 2, 1.5, 15, 100, '1', '2025-10-21 03:10:43', '2025-10-21 03:10:43', NULL, 0),
(5, 5, 2, 1, 15, 5, '1', '2025-10-21 03:31:34', '2025-10-21 03:31:34', NULL, 0);

--
-- Disparadores `detalle_compra`
--
DROP TRIGGER IF EXISTS `UPDATE_STOCK_DELETE`;
DELIMITER $$
CREATE TRIGGER `UPDATE_STOCK_DELETE` AFTER DELETE ON `detalle_compra` FOR EACH ROW UPDATE producto SET stock = stock - OLD.cantidad WHERE idproducto = OLD.idproducto
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `anadir_num_stock`;
DELIMITER $$
CREATE TRIGGER `anadir_num_stock` AFTER INSERT ON `detalle_compra` FOR EACH ROW BEGIN

UPDATE producto SET stock = stock + NEW.cantidad WHERE idproducto = NEW.idproducto;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `editar_stock_producto`;
DELIMITER $$
CREATE TRIGGER `editar_stock_producto` AFTER UPDATE ON `detalle_compra` FOR EACH ROW BEGIN

IF NEW.estado = '1' THEN
UPDATE producto SET stock = stock + NEW.cantidad WHERE idproducto = NEW.idproducto;
END IF;

IF NEW.estado = '0' THEN
UPDATE producto SET stock = stock - NEW.cantidad WHERE idproducto = NEW.idproducto;
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_rol`
--

DROP TABLE IF EXISTS `detalle_rol`;
CREATE TABLE IF NOT EXISTS `detalle_rol` (
  `iddetalle_rol` int NOT NULL AUTO_INCREMENT,
  `idrol` int NOT NULL,
  `idpagina` int NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `leer` varchar(2) NOT NULL DEFAULT '1',
  `actualizar` varchar(2) NOT NULL DEFAULT '1',
  `eliminar` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1',
  `crear` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetalle_rol`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalle_rol`
--

INSERT INTO `detalle_rol` (`iddetalle_rol`, `idrol`, `idpagina`, `nombre`, `estado`, `leer`, `actualizar`, `eliminar`, `crear`, `created_at`, `updated_at`, `deleted_at`) VALUES
(64, 12, 3, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(63, 12, 2, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(62, 12, 1, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(61, 1, 8, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(60, 1, 7, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(59, 1, 6, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(72, 13, 3, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(71, 13, 2, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(70, 13, 1, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(58, 1, 5, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(57, 1, 4, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(56, 1, 3, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(55, 1, 2, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(54, 1, 1, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(65, 12, 4, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(66, 12, 5, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(67, 12, 6, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(68, 12, 7, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(69, 12, 8, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(73, 13, 4, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(74, 13, 5, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(75, 13, 6, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(76, 13, 7, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(77, 13, 8, '', '1', '1', '1', '1', '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
CREATE TABLE IF NOT EXISTS `detalle_venta` (
  `iddetalle_venta` int NOT NULL AUTO_INCREMENT,
  `idventa` int NOT NULL,
  `idproducto` int NOT NULL,
  `precio_venta` float NOT NULL DEFAULT '0',
  `iva` float NOT NULL DEFAULT '0',
  `cantidad` int NOT NULL DEFAULT '0',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `temporada` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `iddetalle_compra` int NOT NULL,
  PRIMARY KEY (`iddetalle_venta`)
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
  `ruc` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`idempresa`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `nombre`, `direccion`, `logo`, `estado`, `created_at`, `updated_at`, `deleted_at`, `ruc`) VALUES
(1, 'GenyCar', 'El Deseo, Santa Rosa, No.2', 'uploads/2025/10/20/logolibreria_68f6fd77438cd.png', '1', NULL, '2025-10-20 22:26:47', NULL, '0942096470001');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pagina`
--

INSERT INTO `pagina` (`idpagina`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'usuario', '1', NULL, NULL, NULL),
(2, 'empresa', '1', NULL, NULL, NULL),
(3, 'rol', '1', NULL, NULL, NULL),
(4, 'categoria', '1', NULL, NULL, NULL),
(5, 'atributo', '1', NULL, NULL, NULL),
(6, 'cliente', '1', NULL, NULL, NULL),
(7, 'proveedor', '1', NULL, NULL, NULL),
(8, 'producto', '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `idpersona` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `telefono` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1',
  `direccion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo` varchar(2) NOT NULL DEFAULT '1',
  `cedula_ruc` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `nombre_completo`, `email`, `telefono`, `direccion`, `tipo`, `cedula_ruc`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CARLOS ROJANO', 'c.rojano.95@gmail.com', '0939311237', 'Milagro', '0', '0942096470', '1', '2025-10-17 13:23:30', '2025-10-17 18:29:11', NULL),
(2, 'PROVEEDOR', 'proveedor@gmail.com', '0939311237', 'Milagro', '1', '0916609365', '1', '2025-10-17 13:32:31', '2025-10-20 16:45:16', NULL),
(3, 'CHUTA', 'chuta@gmail.com', '0939311237', 'Milagro', '1', '0942096470001', '1', '2025-10-20 22:10:15', '2025-10-20 22:10:15', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `idproducto` int NOT NULL AUTO_INCREMENT,
  `idempresa` int NOT NULL,
  `idcategoria` int NOT NULL,
  `codigo_barras` varchar(50) NOT NULL DEFAULT '',
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `precio_venta` float NOT NULL DEFAULT '0',
  `stock` int NOT NULL DEFAULT '0',
  `stock_minimo` int NOT NULL DEFAULT '0',
  `imagen` varchar(400) NOT NULL DEFAULT '',
  `descripcion` longtext NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `slug` varchar(500) NOT NULL DEFAULT '',
  `stock_usado` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idproducto`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `idempresa`, `idcategoria`, `codigo_barras`, `nombre`, `precio_venta`, `stock`, `stock_minimo`, `imagen`, `descripcion`, `estado`, `created_at`, `updated_at`, `deleted_at`, `slug`, `stock_usado`) VALUES
(2, 1, 2, '7701234567890', 'LAPICERO BIC AZUL CRISTAL', 0.35, 208, 10, 'uploads/2025/10/18/trans_imagen_recortada_68f3a5d225b1f.png', '<p>Lapicero de tinta azul con punta media de 1.0 mm. Ideal para uso escolar y de oficina.</p>', '1', '2025-10-18 09:36:04', '2025-10-20 22:54:22', NULL, 'lapicero-bic-azul-cristal', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'super_admin', '1', NULL, NULL, NULL),
(13, 'ventas', '1', '2025-10-11 22:10:27', '2025-10-11 22:29:27', NULL),
(12, 'trabajador', '1', '2025-10-11 22:10:58', '2025-10-11 22:10:55', NULL);

--
-- Disparadores `rol`
--
DROP TRIGGER IF EXISTS `crear_permisos`;
DELIMITER $$
CREATE TRIGGER `crear_permisos` AFTER INSERT ON `rol` FOR EACH ROW BEGIN
call sp_crear_accesos_rol(NEW.idrol);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `eliminar_permisos`;
DELIMITER $$
CREATE TRIGGER `eliminar_permisos` AFTER DELETE ON `rol` FOR EACH ROW BEGIN
DELETE FROM detalle_rol WHERE idrol = OLD.idrol;
END
$$
DELIMITER ;

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
  `nombre` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`idusuario`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `idempresa`, `idrol`, `usuario`, `pass`, `email`, `estado`, `created_at`, `updated_at`, `deleted_at`, `nombre`) VALUES
(1, 1, 1, 'admin_genesis', '$2y$10$aK4XFgiV3cPjVhSsyT4PXOq.H.tCtqZWZ4BJXwRSthYYeNoPK7Qz.', 'gquintanam@unemi.edu.ec', '1', NULL, '2025-10-11 23:59:10', NULL, 'Génesis'),
(6, 1, 1, 'crojano', '$2y$10$VHOJa5mvInV83qskN1xx6uSV6qqBbJYLsOFBQJ.5jhFgVvgke7mIq', 'c.rojano.95@gmail.com', '1', '2025-10-11 18:10:52', '2025-10-21 03:24:50', NULL, 'CARLOS ROJANO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoratributo`
--

DROP TABLE IF EXISTS `valoratributo`;
CREATE TABLE IF NOT EXISTS `valoratributo` (
  `idvaloratributo` int NOT NULL AUTO_INCREMENT,
  `idatributo` int NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idvaloratributo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `valoratributo`
--

INSERT INTO `valoratributo` (`idvaloratributo`, `idatributo`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'AZUL', '1', '2025-10-18 09:33:40', '2025-10-18 09:33:40', NULL),
(3, 8, '0.1MM', '1', '2025-10-18 09:36:04', '2025-10-18 09:36:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `idventa` int NOT NULL AUTO_INCREMENT,
  `idusuario` int NOT NULL,
  `idpersona` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `precio_total` float NOT NULL,
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
