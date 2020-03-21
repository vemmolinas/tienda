-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2020 a las 13:54:20
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `idArticulo` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `caracteristicas` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(250) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`idArticulo`, `descripcion`, `precio`, `caracteristicas`, `stock`, `imagen`) VALUES
(2, 'Television', 220, '22 Pulgadas, LED, Smart TV', 31, 'https://images-na.ssl-images-amazon.com/images/I/612gUJd0phL._SL1200_.jpg'),
(3, 'Móvil', 250, '4G, 25Mp, DualCAM, Gorilla Glass', 55, 'https://images-na.ssl-images-amazon.com/images/I/61TmUVua4XL._SL1016_.jpg'),
(4, 'Cascos', 30, 'Bluetooth 4.0, 25Gb de almacenamiento', 38, 'https://images-na.ssl-images-amazon.com/images/I/61s9D4c-UGL._SL1000_.jpg'),
(5, 'Ratón', 22, '6000 dpi, USB 3.0, inalámbrico\r\n', 48, 'https://images-na.ssl-images-amazon.com/images/I/61nYK91POwL._SL1500_.jpg'),
(6, 'Alfombrilla', 25, 'Iluminación RGB y carga inalámbrica', 58, 'https://images-na.ssl-images-amazon.com/images/I/51UrH20pkzL._SL1000_.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idUsuario` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tiquet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`idUsuario`, `idArticulo`, `fecha`, `cantidad`, `tiquet`) VALUES
(16, 2, '2019-01-27 13:26:37', 1, 1),
(16, 3, '2019-01-27 13:26:37', 1, 1),
(16, 3, '2019-04-27 13:27:07', 2, 2),
(16, 4, '2019-01-27 13:26:37', 1, 1),
(16, 5, '2019-04-27 13:27:07', 1, 2),
(16, 6, '2019-08-27 13:27:15', 1, 3),
(18, 2, '2020-01-06 13:28:33', 1, 5),
(18, 3, '2019-02-17 13:28:26', 2, 4),
(18, 4, '2020-01-17 13:28:40', 1, 6),
(18, 5, '2019-02-17 13:28:26', 1, 4),
(18, 6, '2020-01-06 13:28:33', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `rol` enum('administrador','consultor') COLLATE utf8_spanish_ci NOT NULL,
  `fechaNac` date NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `password`, `rol`, `fechaNac`, `nombre`, `apellidos`, `correo`) VALUES
(16, 'cliente1', '1284b58a06354cb8912104a02eb5000a32332f66b10bf2de4578134369df2212536d3445db61f22509d00aa61927b978a5d498a562051dd953390abd144777bc', 'consultor', '1987-11-11', 'AGATA', 'LISOWSKA', 'agata@gmail.com'),
(17, 'yolanda', '1284b58a06354cb8912104a02eb5000a32332f66b10bf2de4578134369df2212536d3445db61f22509d00aa61927b978a5d498a562051dd953390abd144777bc', 'administrador', '1980-06-25', 'YOLANDA', 'IGLESIAS SUAREZ', 'yolanda@cifp.com'),
(18, 'cliente2', '1284b58a06354cb8912104a02eb5000a32332f66b10bf2de4578134369df2212536d3445db61f22509d00aa61927b978a5d498a562051dd953390abd144777bc', 'consultor', '1986-06-28', 'EMMANUEL', 'MOLINAS', 'vemma@gmail.com'),
(19, 'ana', '1284b58a06354cb8912104a02eb5000a32332f66b10bf2de4578134369df2212536d3445db61f22509d00aa61927b978a5d498a562051dd953390abd144777bc', 'administrador', '1984-08-25', 'ANA', 'ESCUDERO', 'ana@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`idArticulo`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idUsuario`,`idArticulo`,`fecha`),
  ADD KEY `fk_idArticulo` (`idArticulo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `idArticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_idArticulo` FOREIGN KEY (`idArticulo`) REFERENCES `articulos` (`idArticulo`),
  ADD CONSTRAINT `fk_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/********************************************************************************/
/**   USUARIOS DE LA BASE DE DATOS***/

# Privilegios para `AdminCarrito`@`localhost`

GRANT USAGE ON *.* TO 'AdminCarrito'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT ALL PRIVILEGES ON `ventas`.* TO 'AdminCarrito'@'localhost' WITH GRANT OPTION;


# Privilegios para `acceso`@`localhost`

GRANT USAGE ON *.* TO 'acceso'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT SELECT ON `ventas`.`usuarios` TO 'acceso'@'localhost';



# Privilegios para `consultor`@`localhost`

GRANT USAGE ON *.* TO 'consultor'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT SELECT, INSERT ON `ventas`.`compras` TO 'consultor'@'localhost';

GRANT SELECT, INSERT (stock), UPDATE, REFERENCES (stock) ON `ventas`.`articulos` TO 'consultor'@'localhost';

GRANT SELECT, INSERT ON `ventas`.`usuarios` TO 'consultor'@'localhost';