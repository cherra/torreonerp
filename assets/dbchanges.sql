ALTER TABLE  `Usuario` ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
ALTER TABLE  `Usuario` CHANGE  `nombre`  `nombre` CHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '',
CHANGE  `apellido`  `apellido` CHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '',
CHANGE  `username`  `username` CHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '',
CHANGE  `password`  `password` CHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE  `tipo`  `tipo` ENUM(  'normal',  'admin',  'limit',  'vendedor' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'normal',
CHANGE  `eliminado`  `eliminado` ENUM(  'n',  's' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'n'

--
-- Estructura de tabla para la tabla `Permisos`
--

CREATE TABLE IF NOT EXISTS `Permisos` (
  `id_permiso` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permKey` varchar(50) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `submenu` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `method` varchar(100) NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '1',
  `icon` varchar(32) NOT NULL,
  PRIMARY KEY (`id_permiso`),
  UNIQUE KEY `permKey` (`permKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PermisosRol`
--

CREATE TABLE IF NOT EXISTS `PermisosRol` (
  `id_permisorol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_rol` bigint(20) NOT NULL,
  `id_permiso` bigint(20) NOT NULL,
  `valor` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_permisorol`),
  UNIQUE KEY `roleID_2` (`id_rol`,`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PermisosUsuario`
--

CREATE TABLE IF NOT EXISTS `PermisosUsuario` (
  `id_permisousuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `id_permiso` bigint(20) NOT NULL,
  `valor` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_permisousuario`),
  UNIQUE KEY `userID` (`id_usuario`,`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Roles`
--

CREATE TABLE IF NOT EXISTS `Roles` (
  `id_rol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `roleName` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RolesUsuario`
--

CREATE TABLE IF NOT EXISTS `RolesUsuario` (
  `id_rolusuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `id_rol` bigint(20) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rolusuario`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_rol` (`id_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;