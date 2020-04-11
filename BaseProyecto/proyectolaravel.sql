-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-04-2020 a las 18:01:41
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
-- Base de datos: `proyectolaravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`id`, `nombre`, `descripcion`, `condicion`, `created_at`, `updated_at`) VALUES
(5, 'Bolivariano', 'Banco Bolivariano', 1, '2020-01-18 01:29:45', '2020-01-18 01:29:45'),
(6, 'Internacional', 'Internacional', 1, '2020-01-18 01:30:07', '2020-01-18 01:30:07'),
(7, 'Pacifico', 'Banco del Pacífico', 1, '2020-01-18 01:30:41', '2020-01-18 01:30:41'),
(99, 'Sin Banco', 'No existe', 1, NULL, NULL),
(100, 'Banco General Rumiñahui', 'BGR', 1, '2020-02-11 02:37:43', '2020-02-11 02:37:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `imagen`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 'Arroces', 'Arroces', 'XFhy0GK8vaj5jc7p.jpg', 1, '2019-08-25 07:42:47', '2019-12-10 02:33:41'),
(2, 'Aceites comestibles', 'Aceites Comestibles', 'imCCLw8ion88sNLz.jpg', 1, '2019-08-25 07:44:01', '2019-12-10 02:33:06'),
(3, 'Aceites de Parrilla', 'Aceites de Parrilla', 'VBFG78aTVJLj0BTv.jpg', 1, '2019-08-25 07:44:41', '2019-12-10 02:32:28'),
(4, 'Carnes de Res', 'Carnes de Res', 'UpI1bKZ17Jl4NyHo.jpg', 1, '2019-08-25 07:45:08', '2019-12-10 02:31:50'),
(5, 'Carnes de Conejo', 'Carnes de Conejo', '4lzgCd2S8apYhIHU.jpg', 1, '2019-08-25 07:45:45', '2019-12-10 02:31:15'),
(6, 'Carnes de Soya', 'Carnes de Soya', 'dMoWyloK4W3qNggU.jpg', 1, '2019-08-25 07:46:13', '2019-12-10 02:30:43'),
(7, 'Leches', 'Leches Semidescremada', 'nrYE9a6GFeFiu68r.jpg', 1, '2019-08-25 07:47:01', '2019-12-10 02:30:15'),
(8, 'Leche des', 'Leche descremada', 'iC0XNb18kGpbImvH.jpg', 1, '2019-08-25 07:47:20', '2019-12-10 02:42:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Cliente 1', 'CEDULA', '0107645436', 'Cdla Torresol', '0992826240', 'jgabriel36@yahoo.com', '2019-08-25 07:58:01', '2019-08-25 07:58:01'),
(2, 'Cliente 2', 'CEDULA', '09135673983', 'Pichincha 710', '2516437', 'marita36@hotmail.com', '2019-08-25 07:59:12', '2019-08-25 07:59:12'),
(3, 'Cliente 3', 'CEDULA', '09623765478', 'Urb Portofino', '046042356', 'maslimpio36@hotmail.com', '2019-08-25 08:00:16', '2019-08-25 08:00:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes_banco`
--

CREATE TABLE `clientes_banco` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcliente` int(10) UNSIGNED NOT NULL,
  `idbanco` int(10) UNSIGNED NOT NULL,
  `banco` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_cta` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cuenta` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes_banco`
--

INSERT INTO `clientes_banco` (`id`, `idcliente`, `idbanco`, `banco`, `tipo_cta`, `cuenta`, `estado`, `created_at`, `updated_at`) VALUES
(3, 1, 5, 'Bolivariano', 'CORRIENTE', '234789654', 'Registrada', '2020-01-18 16:56:59', '2020-01-18 16:56:59'),
(4, 2, 7, 'Pacifico', 'CORRIENTE', '45578654', 'Registrada', '2020-01-18 16:57:56', '2020-01-18 16:57:56'),
(5, 3, 7, 'Pacifico', 'CORRIENTE', '45764323', 'Registrada', '2020-01-20 05:35:17', '2020-01-20 05:35:17'),
(6, 2, 100, 'Banco General Rumiñahui', 'CORRIENTE', '23364578', 'Registrada', '2020-02-11 02:39:24', '2020-02-11 02:39:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes_tarjetas`
--

CREATE TABLE `clientes_tarjetas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcliente` int(10) UNSIGNED NOT NULL,
  `idtarjeta` int(10) UNSIGNED NOT NULL,
  `tarjeta` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idbanco` int(10) UNSIGNED NOT NULL,
  `ntarjeta` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes_tarjetas`
--

INSERT INTO `clientes_tarjetas` (`id`, `idcliente`, `idtarjeta`, `tarjeta`, `idbanco`, `ntarjeta`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'Visa', 5, '4567809987', 'Activo', '2020-01-18 02:32:21', '2020-01-18 02:32:21'),
(2, 2, 8, 'Pacificard', 7, '678965456', 'Activo', '2020-01-18 02:33:46', '2020-01-18 02:33:46'),
(3, 3, 8, 'Pacificard', 7, NULL, 'Activo', '2020-01-21 04:07:47', '2020-01-21 04:07:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(10) UNSIGNED NOT NULL,
  `idproveedor` int(10) UNSIGNED NOT NULL,
  `idusuario` int(10) UNSIGNED NOT NULL,
  `tipo_identificacion` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_compra` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `idproveedor`, `idusuario`, `tipo_identificacion`, `num_compra`, `fecha_compra`, `impuesto`, `total`, `estado`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Cedula', '001', '2019-09-30 00:00:00', '0.12', '30.00', 'Registrado', NULL, NULL),
(2, 2, 1, 'FACTURA', '002', '2019-10-25 00:00:00', '0.12', '202.00', 'Anulado', '2019-10-26 07:19:07', '2019-10-27 10:50:03'),
(3, 3, 1, 'FACTURA', '003', '2019-10-25 00:00:00', '0.12', '14.00', 'Registrado', '2019-10-26 07:20:37', '2019-10-26 07:20:37'),
(4, 2, 1, 'FACTURA', '004', '2019-10-26 00:00:00', '0.12', '54.00', 'Registrado', '2019-10-27 10:51:37', '2019-10-27 10:51:37'),
(5, 1, 1, 'FACTURA', '005', '2019-10-28 00:00:00', '0.12', '144.00', 'Registrado', '2019-10-29 04:02:35', '2019-10-29 04:02:35'),
(6, 1, 1, 'FACTURA', '6', '2020-01-03 00:00:00', '0.12', '780.00', 'Registrado', '2020-01-03 05:35:46', '2020-01-03 05:35:46'),
(7, 2, 1, 'FACTURA', '10', '2020-01-17 00:00:00', '0.12', '1560.00', 'Registrado', '2020-01-18 03:36:21', '2020-01-18 03:36:21'),
(8, 3, 1, 'FACTURA', '11', '2020-01-19 00:00:00', '0.12', '780.00', 'Registrado', '2020-01-20 03:09:09', '2020-01-20 03:09:09'),
(9, 1, 1, 'FACTURA', '26', '2020-03-21 00:00:00', '0.12', '670.00', 'Registrado', '2020-03-21 19:13:24', '2020-03-21 19:13:24');

--
-- Disparadores `compras`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockCompraAnular` AFTER UPDATE ON `compras` FOR EACH ROW BEGIN
  UPDATE productos p
    JOIN detalle_compras di
      ON di.idproducto = p.id
     AND di.idcompra = new.id
     set p.stock = p.stock - di.cantidad;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcompra` int(10) UNSIGNED NOT NULL,
  `idproducto` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `idcompra`, `idproducto`, `cantidad`, `precio`) VALUES
(1, 1, 1, 5, '12.34'),
(2, 2, 5, 30, '6.00'),
(3, 2, 3, 20, '1.10'),
(4, 3, 4, 20, '0.70'),
(5, 4, 3, 30, '1.10'),
(6, 4, 4, 30, '0.70'),
(7, 5, 4, 80, '0.70'),
(8, 5, 3, 80, '1.10'),
(9, 6, 5, 100, '6.00'),
(10, 6, 4, 100, '0.70'),
(11, 6, 3, 100, '1.10'),
(12, 7, 5, 200, '6.00'),
(13, 7, 4, 200, '0.70'),
(14, 7, 3, 200, '1.10'),
(15, 8, 5, 100, '6.00'),
(16, 8, 4, 100, '0.70'),
(17, 8, 3, 100, '1.10'),
(18, 9, 5, 100, '6.00'),
(19, 9, 4, 100, '0.70');

--
-- Disparadores `detalle_compras`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockCompra` AFTER INSERT ON `detalle_compras` FOR EACH ROW BEGIN
 UPDATE productos SET stock = stock + NEW.cantidad 
 WHERE productos.id = NEW.idproducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idventa` int(10) UNSIGNED NOT NULL,
  `idproducto` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `idventa`, `idproducto`, `cantidad`, `precio`, `descuento`) VALUES
(2, 10, 1, 2, '6.00', '2.00'),
(3, 11, 1, 1, '1.25', '0.00'),
(4, 11, 4, 1, '0.70', '0.00'),
(5, 12, 3, 3, '1.10', '2.00'),
(6, 13, 3, 10, '1.10', '0.00'),
(7, 14, 5, 6, '6.00', '0.00'),
(8, 14, 4, 6, '0.70', '0.00'),
(9, 15, 5, 5, '6.00', '0.00'),
(10, 15, 4, 5, '0.70', '0.00'),
(11, 16, 4, 5, '0.70', '0.00'),
(12, 16, 3, 5, '1.10', '0.00'),
(13, 17, 5, 5, '6.00', '0.00'),
(14, 17, 4, 5, '0.70', '0.00'),
(15, 18, 5, 5, '6.00', '0.00'),
(16, 18, 4, 5, '0.70', '0.00'),
(17, 19, 5, 5, '6.00', '0.00'),
(18, 19, 4, 5, '0.70', '0.00'),
(19, 20, 5, 5, '6.00', '0.00'),
(20, 20, 4, 5, '0.70', '0.00'),
(21, 21, 5, 5, '6.00', '0.00'),
(22, 21, 4, 5, '0.70', '0.00'),
(23, 22, 5, 5, '6.00', '0.00'),
(24, 22, 4, 5, '0.70', '0.00'),
(25, 23, 5, 5, '6.00', '0.00'),
(26, 23, 4, 5, '0.70', '0.00'),
(27, 24, 5, 2, '6.00', '0.00'),
(28, 24, 4, 2, '0.70', '0.00'),
(29, 25, 5, 5, '6.00', '0.00'),
(30, 25, 4, 5, '0.70', '0.00'),
(31, 26, 5, 8, '6.00', '0.00'),
(32, 26, 4, 8, '0.70', '0.00'),
(33, 27, 5, 5, '6.00', '0.00'),
(34, 27, 4, 5, '0.70', '0.00'),
(35, 28, 4, 5, '0.70', '0.00'),
(36, 28, 5, 5, '6.00', '0.00'),
(37, 29, 5, 5, '6.00', '0.00'),
(38, 29, 4, 5, '0.70', '0.00'),
(39, 30, 5, 10, '6.00', '0.00'),
(40, 31, 4, 8, '0.70', '0.00'),
(41, 32, 4, 5, '0.70', '0.00'),
(42, 33, 4, 5, '0.70', '0.00'),
(43, 34, 4, 5, '0.70', '0.00'),
(44, 35, 4, 5, '0.70', '0.00'),
(45, 36, 5, 5, '6.00', '0.00'),
(46, 37, 4, 5, '0.70', '0.00'),
(47, 38, 5, 5, '6.00', '0.00'),
(48, 38, 4, 5, '0.70', '0.00');

--
-- Disparadores `detalle_ventas`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
 UPDATE productos SET stock = stock - NEW.cantidad 
 WHERE productos.id = NEW.idproducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Efectivo', 'Ventas en efectivo'),
(2, 'Cheque', 'Ventas en cheque'),
(3, 'Tarjeta', 'Ventas con tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2018_12_07_212527_create_categorias_table', 1),
(3, '2018_12_16_202808_create_productos_table', 1),
(4, '2018_12_19_144040_create_proveedores_table', 1),
(5, '2018_12_19_210020_create_clientes_table', 1),
(6, '2018_12_20_144948_create_roles_table', 1),
(7, '2018_12_20_000000_create_users_table', 2),
(12, '2018_12_27_214559_create_compras_table', 3),
(13, '2018_12_27_214622_create_detalle_compras_table', 3),
(14, '2019_10_31_022036_create_ventas_table', 4),
(15, '2019_10_31_022242_create_detalle_ventas_table', 4),
(19, '2019_12_25_064711_create_bancos_table', 6),
(28, '2019_12_31_184650_create_tarjeta_table', 7),
(34, '2019_12_25_222955_create_clientes_tarjetas_table', 12),
(35, '2019_12_26_141551_create_clientes_banco_table', 12),
(39, '2020_01_02_180001_create_pagos_table', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(10) UNSIGNED NOT NULL,
  `factura` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_pago` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idcliente` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idbanco` int(10) UNSIGNED NOT NULL,
  `nombre_banco` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idtarjeta` int(10) UNSIGNED NOT NULL,
  `nombre_tarjeta` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `factura`, `tipo_pago`, `idcliente`, `nombre`, `idbanco`, `nombre_banco`, `idtarjeta`, `nombre_tarjeta`, `valor`, `created_at`, `updated_at`) VALUES
(1, '35', 'Cheque', 3, 'Cliente 2', 7, 'Pacifico', 99, 'Sin Tarjeta', 30, '2020-03-23 16:07:41', '2020-03-23 16:07:41'),
(2, '35', 'Cheque', 3, 'Cliente 2', 7, 'Pacifico', 99, 'Sin Tarjeta', 30, '2020-03-23 16:48:48', '2020-03-23 16:48:48'),
(3, '36', 'Cheque', 3, 'Cliente 2', 7, 'Pacifico', 99, 'Sin Tarjeta', 4, '2020-03-23 17:37:05', '2020-03-23 17:37:05'),
(4, '37', 'Cheque', 2, 'Cliente 1', 7, 'Pacifico', 99, 'Sin Tarjeta', 34, '2020-03-23 21:44:32', '2020-03-23 21:44:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcategoria` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `idcategoria`, `codigo`, `nombre`, `precio_venta`, `stock`, `condicion`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 2, '234567', 'Aceite La Favorita', '1.25', 50, 1, 'MD2sBht6tI1U8IxZ.jpg', '2019-08-25 07:48:21', '2019-12-09 06:20:36'),
(2, 2, '346784', 'Aceite el Cocinero', '2.00', 1, 1, 'cfXw1fld7sVPbfB0.jpg', '2019-08-25 07:49:04', '2019-12-09 06:20:13'),
(3, 2, '4578965', 'Aceite de Oliva', '1.10', 498, 1, 'zkq9ipZqh051mCPB.jpg', '2019-08-25 07:49:58', '2019-12-09 06:19:50'),
(4, 2, '456745', 'Aceite Girasol', '0.70', 611, 1, 'NEt4mjveiJOx4Il9.jpg', '2019-08-25 07:50:49', '2019-12-09 06:19:30'),
(5, 1, '456', 'Arroz Flor', '6.00', 405, 1, 'JUwMDyPTdEpKUl6P.jpg', '2019-08-25 07:51:43', '2019-12-10 02:43:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Luis Arturo Gonzalez', 'CEDULA', '09103456788', 'Cdla Samanes 4 Mz 238 Villa 10', '28237865', 'luis36@hotmail.com', '2019-08-25 07:54:31', '2019-08-25 07:54:31'),
(2, 'Carlos Gomez', 'CEDULA', '1034678396', 'Cdla Sauces 1 Mz F55 Villa 12', '1124873', 'carlos.gomez.24@yahoo.com', '2019-08-25 07:55:34', '2019-08-25 07:55:34'),
(3, 'Francesco Martinez', 'CEDULA', '0963452346', 'Cdla Sauces 4', '2624356', 'francesca6@yahoo.com', '2019-08-25 07:56:47', '2019-08-25 07:56:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Administrador', 1, NULL, NULL),
(2, 'Vendedor', 'Vendedor', 1, NULL, NULL),
(3, 'Comprador', 'Comprador', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `externa` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idbancos` int(10) UNSIGNED NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`id`, `nombre`, `descripcion`, `externa`, `idbancos`, `condicion`, `created_at`, `updated_at`) VALUES
(7, 'Visa', 'Visa', 'Nacional', 5, 1, NULL, NULL),
(8, 'Pacificard', 'Pacificar Pacifico', 'Nacional', 7, 1, NULL, NULL),
(9, 'Experta', 'Consumos Nacionales', 'NACIONAL', 6, 1, '2020-01-18 18:45:57', '2020-01-18 18:45:57'),
(99, 'Sin Tarjeta', 'No existe tarjeta', 'Ninguna', 99, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `idrol` int(10) UNSIGNED NOT NULL,
  `imagen` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `usuario`, `password`, `condicion`, `idrol`, `imagen`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'CEDULA', '0914567854', 'Cdla. Sauces 2', '0995643678', 'prueba123@hotmail.com', 'Admin1970', '$2y$10$lo/iYvMVo9pSQhjyuBxrh.9JMAlUnnrVY1aXEEdNAZfWIyY5snK2.', 1, 1, 'fW0LnERUSiPNeC5w.jpg', 'E9kgtJZyoSfVOm8qGECRLkyh4W49KfWy6bIM7vtqgMGJqPE2guBjqC6Jl2Pb', '2019-08-25 08:01:59', '2019-12-10 02:47:13'),
(2, 'Patricio Garzon', 'CEDULA', '10347393848', 'Cdla Sauces 9 Mz F50 Villa 12', '2624567', 'patriciogarzon40@gmail.com', 'patricio2', '$2y$10$h.fKAyZeTrPoPwEH2wOLfuLEggO9Z.i.NGwpasDvqf77mD2Nkx3xW', 1, 2, '3P1vzdVk3alyMqoz.jpg', NULL, '2019-08-25 08:03:40', '2019-12-09 06:18:28'),
(3, 'Lorena Gonzalez', 'CEDULA', '104534875', 'Urb. Riberas del Batan', '0451067456', 'lorena36@hotmail.com', 'jessileo1974', '$2y$10$tZT58igSfw1VIWD6/apGSuTXkgEE.wdMLcv2fKlSZ/TWAIG0Uczwa', 1, 2, 'nia1Yirf3biifYPE.jpg', 'Oem9t0EAIDcbWvWyt8eIJWKSO7eWT7E8MKrMeOj1bf0DQT93dO9XAnPPO9wO', '2019-09-16 08:34:13', '2019-12-09 06:17:54'),
(4, 'Jorge Zamora', 'CEDULA', '09234576835', 'Cdla. Sauces 7', '2237896', 'jorgezamora36@hotmail.com', 'jorge2019', '$2y$10$OA/1EY7HhDOp.BFQXzNAGu0f8rg80KJ.ex3lEoa2OPp2tq0b8y8nC', 1, 2, '0iyfb0ztq1cC6WT4.jpg', NULL, '2019-12-08 14:37:46', '2019-12-08 14:37:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcliente` int(10) UNSIGNED NOT NULL,
  `idusuario` int(10) UNSIGNED NOT NULL,
  `tipo_identificacion` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_venta` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_venta` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `idcliente`, `idusuario`, `tipo_identificacion`, `num_venta`, `fecha_venta`, `impuesto`, `total`, `estado`, `created_at`, `updated_at`) VALUES
(10, 1, 2, 'CEDULA', '001', '2019-11-11 00:00:00', '2.34', '6.00', 'Registrado', NULL, NULL),
(11, 1, 1, 'FACTURA', '002', '2019-11-13 00:00:00', '0.20', '1.95', 'Anulado', '2019-11-14 01:46:12', '2019-11-14 02:17:53'),
(12, 3, 1, 'FACTURA', '003', '2019-11-13 00:00:00', '0.20', '1.30', 'Registrado', '2019-11-14 02:19:10', '2019-11-14 02:19:10'),
(13, 3, 1, 'FACTURA', '10', '2020-01-02 00:00:00', '0.20', '11.00', 'Registrado', '2020-01-03 04:11:31', '2020-01-03 04:11:31'),
(14, 3, 1, 'FACTURA', '18', '2020-01-12 00:00:00', '0.20', '40.20', 'Registrado', '2020-01-12 07:51:14', '2020-01-12 07:51:14'),
(15, 3, 1, 'FACTURA', '20', '2020-01-12 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-12 19:01:50', '2020-01-12 19:01:50'),
(16, 1, 1, 'FACTURA', '39', '2020-01-17 00:00:00', '0.20', '9.00', 'Registrado', '2020-01-18 03:13:24', '2020-01-18 03:13:24'),
(17, 1, 1, 'FACTURA', '15', '2020-01-17 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-18 03:38:02', '2020-01-18 03:38:02'),
(18, 1, 1, 'FACTURA', '15', '2020-01-18 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-18 17:57:58', '2020-01-18 17:57:58'),
(19, 1, 1, 'FACTURA', '16', '2020-01-18 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-18 19:00:23', '2020-01-18 19:00:23'),
(20, 1, 1, 'FACTURA', '17', '2020-01-18 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-19 02:29:27', '2020-01-19 02:29:27'),
(21, 1, 1, 'FACTURA', '17', '2020-01-18 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-19 03:07:17', '2020-01-19 03:07:17'),
(22, 1, 1, 'FACTURA', '17', '2020-01-18 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-19 03:08:46', '2020-01-19 03:08:46'),
(23, 1, 1, 'FACTURA', '17', '2020-01-18 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-19 03:44:26', '2020-01-19 03:44:26'),
(24, 2, 1, 'FACTURA', '19', '2020-01-18 00:00:00', '0.20', '13.40', 'Registrado', '2020-01-19 04:00:30', '2020-01-19 04:00:30'),
(25, 2, 1, 'FACTURA', '20', '2020-01-18 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-19 04:23:12', '2020-01-19 04:23:12'),
(26, 2, 1, 'FACTURA', '21', '2020-01-18 00:00:00', '0.20', '53.60', 'Registrado', '2020-01-19 04:50:26', '2020-01-19 04:50:26'),
(27, 2, 1, 'FACTURA', '20', '2020-01-19 00:00:00', '0.20', '33.50', 'Registrado', '2020-01-19 13:32:52', '2020-01-19 13:32:52'),
(28, 2, 1, 'FACTURA', '23', '2020-02-07 00:00:00', '0.20', '33.50', 'Registrado', '2020-02-07 23:24:07', '2020-02-07 23:24:07'),
(29, 3, 1, 'FACTURA', '22', '2020-03-21 00:00:00', '0.12', '33.50', 'Registrado', '2020-03-21 19:16:54', '2020-03-21 19:16:54'),
(30, 2, 1, 'FACTURA', '26', '2020-03-22 00:00:00', '0.12', '60.00', 'Registrado', '2020-03-23 01:30:36', '2020-03-23 01:30:36'),
(31, 3, 1, 'FACTURA', '30', '2020-03-22 00:00:00', '0.12', '5.60', 'Registrado', '2020-03-23 03:03:59', '2020-03-23 03:03:59'),
(32, 2, 1, 'FACTURA', '31', '2020-03-22 00:00:00', '0.12', '3.50', 'Registrado', '2020-03-23 03:34:17', '2020-03-23 03:34:17'),
(33, 2, 1, 'FACTURA', '32', '2020-03-22 00:00:00', '0.12', '3.50', 'Registrado', '2020-03-23 03:49:52', '2020-03-23 03:49:52'),
(34, 2, 1, 'FACTURA', '33', '2020-03-22 00:00:00', '0.12', '3.50', 'Registrado', '2020-03-23 04:44:28', '2020-03-23 04:44:28'),
(35, 2, 1, 'FACTURA', '34', '2020-03-23 00:00:00', '0.12', '3.50', 'Registrado', '2020-03-23 05:21:31', '2020-03-23 05:21:31'),
(36, 3, 1, 'FACTURA', '35', '2020-03-23 00:00:00', '0.12', '30.00', 'Registrado', '2020-03-23 16:48:51', '2020-03-23 16:48:51'),
(37, 3, 1, 'FACTURA', '36', '2020-03-23 00:00:00', '0.12', '3.50', 'Registrado', '2020-03-23 17:37:09', '2020-03-23 17:37:09'),
(38, 2, 1, 'FACTURA', '37', '2020-03-23 00:00:00', '0.12', '33.50', 'Registrado', '2020-03-23 21:44:41', '2020-03-23 21:44:41');

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVentaAnular` AFTER UPDATE ON `ventas` FOR EACH ROW BEGIN
  UPDATE productos p
    JOIN detalle_ventas dv
      ON dv.idproducto = p.id
     AND dv.idventa= new.id
     set p.stock = p.stock + dv.cantidad;
end
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorias_nombre_unique` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_nombre_unique` (`nombre`);

--
-- Indices de la tabla `clientes_banco`
--
ALTER TABLE `clientes_banco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientes_banco_idcliente_foreign` (`idcliente`),
  ADD KEY `clientes_banco_idbanco_foreign` (`idbanco`);

--
-- Indices de la tabla `clientes_tarjetas`
--
ALTER TABLE `clientes_tarjetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientes_tarjetas_idcliente_foreign` (`idcliente`),
  ADD KEY `clientes_tarjetas_idtarjeta_foreign` (`idtarjeta`),
  ADD KEY `clientes_tarjetas_idbanco_foreign` (`idbanco`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_idproveedor_foreign` (`idproveedor`),
  ADD KEY `compras_idusuario_foreign` (`idusuario`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_compras_idcompra_foreign` (`idcompra`),
  ADD KEY `detalle_compras_idproducto_foreign` (`idproducto`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_idventa_foreign` (`idventa`),
  ADD KEY `detalle_ventas_idproducto_foreign` (`idproducto`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `forma_pago_nombre_unique` (`nombre`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagos_idcliente_foreign` (`idcliente`),
  ADD KEY `pagos_idbanco_foreign` (`idbanco`),
  ADD KEY `pagos_idtarjeta_foreign` (`idtarjeta`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_nombre_unique` (`nombre`),
  ADD KEY `productos_idcategoria_foreign` (`idcategoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `proveedores_nombre_unique` (`nombre`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_nombre_unique` (`nombre`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarjeta_idbancos_foreign` (`idbancos`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`),
  ADD UNIQUE KEY `users_password_unique` (`password`),
  ADD KEY `users_idrol_foreign` (`idrol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_idcliente_foreign` (`idcliente`),
  ADD KEY `ventas_idusuario_foreign` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bancos`
--
ALTER TABLE `bancos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `clientes_banco`
--
ALTER TABLE `clientes_banco`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clientes_tarjetas`
--
ALTER TABLE `clientes_tarjetas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes_banco`
--
ALTER TABLE `clientes_banco`
  ADD CONSTRAINT `clientes_banco_idbanco_foreign` FOREIGN KEY (`idbanco`) REFERENCES `bancos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clientes_banco_idcliente_foreign` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clientes_tarjetas`
--
ALTER TABLE `clientes_tarjetas`
  ADD CONSTRAINT `clientes_tarjetas_idbanco_foreign` FOREIGN KEY (`idbanco`) REFERENCES `bancos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clientes_tarjetas_idcliente_foreign` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clientes_tarjetas_idtarjeta_foreign` FOREIGN KEY (`idtarjeta`) REFERENCES `tarjeta` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_idproveedor_foreign` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `compras_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_idcompra_foreign` FOREIGN KEY (`idcompra`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_compras_idproducto_foreign` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_idproducto_foreign` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_ventas_idventa_foreign` FOREIGN KEY (`idventa`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_idbanco_foreign` FOREIGN KEY (`idbanco`) REFERENCES `bancos` (`id`),
  ADD CONSTRAINT `pagos_idcliente_foreign` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `pagos_idtarjeta_foreign` FOREIGN KEY (`idtarjeta`) REFERENCES `tarjeta` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_idcategoria_foreign` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `tarjeta_idbancos_foreign` FOREIGN KEY (`idbancos`) REFERENCES `bancos` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_idrol_foreign` FOREIGN KEY (`idrol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_idcliente_foreign` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ventas_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
