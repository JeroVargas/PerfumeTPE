-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2026 a las 03:15:27
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `perfumetpe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `perfume`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(5, 'Floral'),
(6, 'Amaderado'),
(7, 'Cítrico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfume`
--

CREATE TABLE `perfume` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `nota` varchar(30) NOT NULL,
  `precio` int(11) NOT NULL,
  `tipo_variante` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `perfume`
--

INSERT INTO `perfume` (`id`, `id_categoria`, `nombre`, `nota`, `precio`, `tipo_variante`) VALUES
(3, 5, 'Dior J’adore', 'jazmín', 45000, 'Floral'),
(4, 6, 'Bleu de Chanel', 'cedro', 30000, 'Amaderado'),
(5, 7, 'Acqua di Gio', 'bergamota', 28000, 'Cítrico'),
(7, 7, 'Enses angria', 'pimienta roja', 71500, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(11) NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `level`) VALUES
(2, 'aaa@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$UVZ5STluc2hVblpuaUY1cQ$RfB4QVWc1YzSm6tpjJ+t8JZbC3b3sMFCRAxiM8dvyLU', 'usuario'),
(4, 'hola@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$TVRMRXdEcWxMeWtOaldVZg$J/Ao+lNzmdKNRMD849d2p8sLjjwp5Efl8JFMrOKwB1U', 'usuario'),
(6, 'adminperfume@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$bC4xNlI0M2ZkWHFpektxTw$4+rdx98nXhuJ7hdE8fhJQcoL8RFyKFUUMGmlwQjTy4g', 'admin'),
(7, 'as@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$ZjFPMDF0UGUyT3NqZXd5eA$D2r+3GLaBbWSVRh/pMWuddS/eayiKyzLKKCxFjNUJrc', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `categorias` ADD `imagen` TEXT NULL AFTER `nombre`;
--
-- Indices de la tabla `perfume`
--
ALTER TABLE `perfume`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `perfume`
--
ALTER TABLE `perfume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `perfume`
--
ALTER TABLE `perfume`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
