DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `idrol` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `pagina`;
CREATE TABLE IF NOT EXISTS `pagina` (
  `idpagina` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `detalle_rol`;
CREATE TABLE IF NOT EXISTS `detalle_rol` (
  `iddetalle_rol` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idrol` integer NOT NULL,
  `idpagina` integer NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `leer` varchar(2) NOT NULL DEFAULT '1',
  `actualizar` varchar(2) NOT NULL DEFAULT '1',
  `editar` varchar(2) NOT NULL DEFAULT '1',
  `crear` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `idempresa` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `direccion` varchar(200) NOT NULL DEFAULT '',
  `logo` varchar(400) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idempresa` integer NOT NULL,
  `idrol` integer NOT NULL,
  `usuario` varchar(200) NOT NULL DEFAULT '',
  `pass` varchar(400) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcategoria` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `idproducto` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idempresa` integer NOT NULL,
  `idcategoria` integer NOT NULL,
  `codigo_barras` varchar(50) NOT NULL DEFAULT '',
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `precio_venta` float NOT NULL DEFAULT 0,
  `stock` integer NOT NULL DEFAULT 0,
  `stock_minimo` integer NOT NULL DEFAULT 0,
  `imagen` varchar(400) NOT NULL DEFAULT '',
  `descripcion` longtext NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `atributo`;
CREATE TABLE IF NOT EXISTS `atributo` (
  `idatributo` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `valoratributo`;
CREATE TABLE IF NOT EXISTS `valoratributo` (
  `idvaloratributo` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idatributo` integer NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `detalle_atributo_producto`;
CREATE TABLE IF NOT EXISTS `detalle_atributo_producto` (
  `iddetalle_atributo_producto` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idvaloratributo` integer NOT NULL,
  `idproducto` integer NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `idpersona` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre_completo` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `telefono` varchar(2) NOT NULL DEFAULT '1',
  `direccion` varchar(2) NOT NULL DEFAULT '1',
  `tipo` varchar(2) NOT NULL DEFAULT '1',
  `cedula_ruc` varchar(2) NOT NULL DEFAULT '1',
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `idventa` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idusuario` integer NOT NULL,
  `idpersona` integer NOT NULL,
  `fecha` date NULL,
  `numero_factura` varchar(50) NOT NULL,
  `precio_total` float NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `detalle_venta`;
CREATE TABLE IF NOT EXISTS `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idventa` integer NOT NULL,
  `idproducto` integer NOT NULL,
  `precio_venta` float NOT NULL DEFAULT 0,
  `iva` float NOT NULL DEFAULT 0,
  `cantidad` integer NOT NULL DEFAULT 0,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `temporada` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `idcompra` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idpersona` integer NOT NULL,
  `idusuario` integer NOT NULL,
  `fecha` date NULL,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);

DROP TABLE IF EXISTS `detalle_compra`;
CREATE TABLE IF NOT EXISTS `detalle_compra` (
  `iddetalle_compra` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idcompra` integer NOT NULL,
  `idproducto` integer NOT NULL,
  `precio_compra` float NOT NULL DEFAULT 0,
  `iva` float NOT NULL DEFAULT 0,
  `cantidad` integer NOT NULL DEFAULT 0,
  `estado` varchar(2) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
);