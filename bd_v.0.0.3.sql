-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-10-2025 a las 03:33:10
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  PRIMARY KEY (`iddetalle_compra`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalle_rol`
--

INSERT INTO `detalle_rol` (`iddetalle_rol`, `idrol`, `idpagina`, `nombre`, `estado`, `leer`, `actualizar`, `eliminar`, `crear`, `created_at`, `updated_at`, `deleted_at`) VALUES
(24, 12, 3, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(23, 12, 2, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(22, 12, 1, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(4, 1, 1, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(5, 1, 2, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(6, 1, 3, '', '1', '1', '1', '1', '1', NULL, NULL, NULL),
(25, 13, 1, '', '1', '1', '1', '1', '1', NULL, '2025-10-12 03:30:19', NULL),
(26, 13, 2, '', '1', '1', '1', '1', '1', NULL, '2025-10-12 03:30:15', NULL),
(27, 13, 3, '', '1', '1', '1', '1', '1', NULL, '2025-10-12 03:30:19', NULL);

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
  PRIMARY KEY (`idempresa`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `nombre`, `direccion`, `logo`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gen&Car', 'El Deseo, Santa Rosa #2', '/assets/img/logolibreria.jpg', '1', NULL, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pagina`
--

INSERT INTO `pagina` (`idpagina`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'usuario', '1', NULL, NULL, NULL),
(2, 'empresa', '1', NULL, NULL, NULL),
(3, 'rol', '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `idpersona` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `telefono` varchar(2) NOT NULL DEFAULT '1',
  `direccion` varchar(2) NOT NULL DEFAULT '1',
  `tipo` varchar(2) NOT NULL DEFAULT '1',
  `cedula_ruc` varchar(2) NOT NULL DEFAULT '1',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(6, 1, 1, 'crojano', '$2y$10$VHOJa5mvInV83qskN1xx6uSV6qqBbJYLsOFBQJ.5jhFgVvgke7mIq', 'c.rojano.95@gmail.com', '1', '2025-10-11 18:10:52', '2025-10-11 18:10:14', NULL, 'CARLOS ROJANO');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
