SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `ArturoBecerra`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Entrada_Almacen`
--

CREATE TABLE IF NOT EXISTS `Entrada_Almacen` (
  `id_entrada` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL DEFAULT '0',
  `id_proveedor` int(10) unsigned NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cancelada` enum('n','s') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id_entrada`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `fecha` (`fecha`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=204 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Entrada_Almacen_Articulo`
--

CREATE TABLE IF NOT EXISTS `Entrada_Almacen_Articulo` (
  `id_entrada_almacen_articulo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_entrada` int(10) unsigned NOT NULL DEFAULT '0',
  `id_articulo` int(10) unsigned NOT NULL DEFAULT '0',
  `cantidad` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_entrada_almacen_articulo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1475 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Inventario_Inicial_Presentacion`
--

CREATE TABLE IF NOT EXISTS `Inventario_Inicial_Presentacion` (
  `id_inventario_presentacion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_articulo` int(10) unsigned NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cantidad` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_inventario_presentacion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=283 ;

-- --------------------------------------------------------

ALTER TABLE `Usuario` ADD `eliminado` ENUM( 'n', 's' ) NOT NULL DEFAULT 'n';