-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2019 a las 19:02:49
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `la_comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf32_spanish2_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf32_spanish2_ci NOT NULL,
  `codigo_mesa` varchar(5) COLLATE utf32_spanish2_ci NOT NULL,
  `codigo_pedido` varchar(5) COLLATE utf32_spanish2_ci NOT NULL,
  `id_encuesta` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `codigo_mesa`, `codigo_pedido`, `id_encuesta`, `created_at`, `updated_at`) VALUES
(1, 'José', 'García', 'b20af', 'e0565', 2, '2019-12-03 05:42:44', '2019-12-03 06:04:53'),
(2, 'José', 'García', '1e46d', 'e3087', NULL, '2019-12-03 07:02:09', '2019-12-03 07:02:09'),
(3, 'José', 'García', '1a67e', 'd1b76', NULL, '2019-12-03 07:02:10', '2019-12-03 07:02:10'),
(4, 'José', 'García', 'a1ebf', 'a8040', NULL, '2019-12-03 07:03:22', '2019-12-03 07:03:22'),
(5, 'José', 'García', '4f27e', '8c7d5', NULL, '2019-12-03 20:30:39', '2019-12-03 20:30:39'),
(6, 'José', 'García', 'd987d', 'aad6a', NULL, '2019-12-03 21:19:58', '2019-12-03 21:19:58'),
(7, 'José', 'García', 'b130a', '70c3a', NULL, '2019-12-03 21:21:58', '2019-12-03 21:21:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidas`
--

CREATE TABLE `comidas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf32_spanish2_ci NOT NULL,
  `tipo` varchar(30) COLLATE utf32_spanish2_ci NOT NULL,
  `precio` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `comidas`
--

INSERT INTO `comidas` (`id`, `nombre`, `tipo`, `precio`, `created_at`, `updated_at`) VALUES
(1, 'pollo', 'comida', 200, '2019-12-03 01:25:03', '2019-12-03 01:25:03'),
(2, 'bife', 'comida', 150, '2019-12-03 01:27:00', '2019-12-03 01:27:00'),
(3, 'papas fritas', 'comida', 50, '2019-12-03 01:27:19', '2019-12-03 01:27:19'),
(4, 'agua', 'bebida', 35, '2019-12-03 01:27:40', '2019-12-03 01:27:40'),
(5, 'jugo de naranja', 'bebida', 40, '2019-12-03 01:27:54', '2019-12-03 01:27:54'),
(6, 'honey', 'cerveza', 90, '2019-12-03 01:28:16', '2019-12-03 01:28:16'),
(7, 'ipa', 'cerveza', 100, '2019-12-03 01:28:24', '2019-12-03 01:47:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf32_spanish2_ci NOT NULL,
  `apellido` varchar(200) COLLATE utf32_spanish2_ci NOT NULL,
  `clave` varchar(600) COLLATE utf32_spanish2_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf32_spanish2_ci NOT NULL,
  `estado` varchar(100) COLLATE utf32_spanish2_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `clave`, `tipo`, `estado`, `created_at`, `updated_at`) VALUES
(100, 'Miguel', 'Lopez', 'clJJEr4AoqRyY', 'mozo', 'activo', '2019-12-02 05:00:49', '2019-12-02 05:00:49'),
(101, 'Juan', 'Pérez', 'clJJEr4AoqRyY', 'socio', 'activo', '2019-12-02 05:01:03', '2019-12-02 05:01:03'),
(102, 'Miguel', 'Angel', 'clJJEr4AoqRyY', 'cervecero', 'activo', '2019-12-02 05:01:18', '2019-12-02 05:01:18'),
(103, 'Pablo', 'Suárez', 'cloiTAHLFJuxU', 'cocinero', 'activo', '2019-12-02 05:01:33', '2019-12-03 02:56:53'),
(104, 'Rubén', 'Gonzalez', 'clJJEr4AoqRyY', 'bartender', 'activo', '2019-12-02 05:02:01', '2019-12-02 05:02:01'),
(105, 'José', 'García', 'clJJEr4AoqRyY', 'admin', 'activo', '2019-12-02 23:17:57', '2019-12-02 23:17:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `puntaje_mesa` int(2) NOT NULL,
  `puntaje_restaurante` int(2) NOT NULL,
  `puntaje_mozo` int(2) NOT NULL,
  `puntaje_cocinero` int(2) NOT NULL,
  `texto_experiencia` varchar(66) COLLATE utf32_spanish2_ci NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `puntaje_mesa`, `puntaje_restaurante`, `puntaje_mozo`, `puntaje_cocinero`, `texto_experiencia`, `id_cliente`, `created_at`, `updated_at`) VALUES
(2, 10, 10, 10, 10, 'Muy buena experiencia', 1, '2019-12-03 06:04:53', '2019-12-03 06:04:53'),
(3, 1, 1, 1, 1, 'Muy mala', 1, '2019-12-03 16:01:32', '2019-12-03 16:01:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(6) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `codigo_pedido` varchar(300) COLLATE utf32_spanish2_ci NOT NULL,
  `monto` int(11) NOT NULL,
  `hora` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `id_mesa`, `codigo_pedido`, `monto`, `hora`, `created_at`, `updated_at`) VALUES
(9, 2, '77460', 200, '2019-12-02 20:33:29', '2019-12-03 03:33:29', '2019-12-03 03:33:29'),
(10, 3, 'a8040', 50, '2019-12-03 00:19:43', '2019-12-03 07:19:43', '2019-12-03 07:19:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(10) NOT NULL,
  `codigo_unico` varchar(5) COLLATE utf32_spanish2_ci DEFAULT NULL,
  `estado` varchar(60) COLLATE utf32_spanish2_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigo_unico`, `estado`, `created_at`, `updated_at`) VALUES
(2, 'e6a47', 'Con cliente pagando', '2019-12-02 23:28:44', '2019-12-03 03:23:02'),
(3, 'e5b8c', 'Con cliente esperando pedido', '2019-12-02 23:28:54', '2019-12-03 21:22:38'),
(4, NULL, 'Cerrada', '2019-12-02 23:28:59', '2019-12-02 23:28:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones_registros`
--

CREATE TABLE `operaciones_registros` (
  `id` int(11) NOT NULL,
  `operacion` varchar(100) COLLATE utf32_spanish2_ci NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `hora` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `operaciones_registros`
--

INSERT INTO `operaciones_registros` (`id`, `operacion`, `id_empleado`, `hora`, `created_at`, `updated_at`) VALUES
(1, 'Login', 105, '2019-12-02 16:24:48', '2019-12-02 23:24:48', '2019-12-02 23:24:48'),
(2, 'Cargar Mesa', 105, '2019-12-02 16:27:24', '2019-12-02 23:27:24', '2019-12-02 23:27:24'),
(3, 'Cargar Mesa', 105, '2019-12-02 16:28:44', '2019-12-02 23:28:44', '2019-12-02 23:28:44'),
(4, 'Cargar Mesa', 105, '2019-12-02 16:28:54', '2019-12-02 23:28:54', '2019-12-02 23:28:54'),
(5, 'Cargar Mesa', 105, '2019-12-02 16:28:59', '2019-12-02 23:28:59', '2019-12-02 23:28:59'),
(6, 'Cargar Comida', 105, '2019-12-02 18:25:03', '2019-12-03 01:25:03', '2019-12-03 01:25:03'),
(7, 'Cargar Comida', 105, '2019-12-02 18:27:00', '2019-12-03 01:27:00', '2019-12-03 01:27:00'),
(8, 'Cargar Comida', 105, '2019-12-02 18:27:19', '2019-12-03 01:27:19', '2019-12-03 01:27:19'),
(9, 'Cargar Comida', 105, '2019-12-02 18:27:40', '2019-12-03 01:27:40', '2019-12-03 01:27:40'),
(10, 'Cargar Comida', 105, '2019-12-02 18:27:54', '2019-12-03 01:27:54', '2019-12-03 01:27:54'),
(11, 'Cargar Comida', 105, '2019-12-02 18:28:16', '2019-12-03 01:28:16', '2019-12-03 01:28:16'),
(12, 'Cargar Comida', 105, '2019-12-02 18:28:24', '2019-12-03 01:28:24', '2019-12-03 01:28:24'),
(13, 'Cargar Comida', 105, '2019-12-02 18:29:31', '2019-12-03 01:29:31', '2019-12-03 01:29:31'),
(14, 'Borrar Comida', 105, '2019-12-02 18:32:24', '2019-12-03 01:32:24', '2019-12-03 01:32:24'),
(15, 'Modificar mesa', 105, '2019-12-02 18:56:38', '2019-12-03 01:56:38', '2019-12-03 01:56:38'),
(16, 'Modificar mesa', 105, '2019-12-02 18:57:05', '2019-12-03 01:57:05', '2019-12-03 01:57:05'),
(17, 'Cargar Mesa', 105, '2019-12-02 18:57:56', '2019-12-03 01:57:56', '2019-12-03 01:57:56'),
(18, 'Borrar Mesa', 105, '2019-12-02 19:00:36', '2019-12-03 02:00:36', '2019-12-03 02:00:36'),
(19, 'Modificar empleado', 105, '2019-12-02 19:30:06', '2019-12-03 02:30:06', '2019-12-03 02:30:06'),
(20, 'Modificar empleado', 105, '2019-12-02 19:32:28', '2019-12-03 02:32:28', '2019-12-03 02:32:28'),
(21, 'Modificar empleado', 105, '2019-12-02 19:33:30', '2019-12-03 02:33:30', '2019-12-03 02:33:30'),
(22, 'Modificar empleado', 105, '2019-12-02 19:35:53', '2019-12-03 02:35:53', '2019-12-03 02:35:53'),
(23, 'Modificar Empleado', 105, '2019-12-02 19:37:43', '2019-12-03 02:37:43', '2019-12-03 02:37:43'),
(24, 'Modificar Empleado', 105, '2019-12-02 19:38:29', '2019-12-03 02:38:29', '2019-12-03 02:38:29'),
(25, 'Cargar Pedido', 100, '2019-12-02 19:50:34', '2019-12-03 02:50:34', '2019-12-03 02:50:34'),
(26, 'Modificar Empleado', 105, '2019-12-02 19:56:53', '2019-12-03 02:56:53', '2019-12-03 02:56:53'),
(27, 'Login', 103, '2019-12-02 19:58:24', '2019-12-03 02:58:24', '2019-12-03 02:58:24'),
(28, 'Ver Pedido', 103, '2019-12-02 19:59:55', '2019-12-03 02:59:55', '2019-12-03 02:59:55'),
(29, 'Preparar pedido', 103, '2019-12-02 20:00:35', '2019-12-03 03:00:35', '2019-12-03 03:00:35'),
(30, 'Terminar Pedido', 103, '2019-12-02 20:01:35', '2019-12-03 03:01:35', '2019-12-03 03:01:35'),
(31, 'Cobrar Pedido', 105, '2019-12-02 20:21:09', '2019-12-03 03:21:09', '2019-12-03 03:21:09'),
(32, 'Cobrar Pedido', 105, '2019-12-02 20:23:02', '2019-12-03 03:23:02', '2019-12-03 03:23:02'),
(33, 'Cobrar Pedido', 105, '2019-12-02 20:26:16', '2019-12-03 03:26:16', '2019-12-03 03:26:16'),
(34, 'Cobrar Pedido', 105, '2019-12-02 20:26:50', '2019-12-03 03:26:50', '2019-12-03 03:26:50'),
(35, 'Cobrar Pedido', 105, '2019-12-02 20:27:10', '2019-12-03 03:27:10', '2019-12-03 03:27:10'),
(36, 'Cobrar Pedido', 105, '2019-12-02 20:27:35', '2019-12-03 03:27:35', '2019-12-03 03:27:35'),
(37, 'Cobrar Pedido', 105, '2019-12-02 20:27:52', '2019-12-03 03:27:52', '2019-12-03 03:27:52'),
(38, 'Ver Pedido', 103, '2019-12-02 20:28:33', '2019-12-03 03:28:33', '2019-12-03 03:28:33'),
(39, 'Cobrar Pedido', 105, '2019-12-02 20:32:17', '2019-12-03 03:32:17', '2019-12-03 03:32:17'),
(40, 'Cobrar Pedido', 105, '2019-12-02 20:33:29', '2019-12-03 03:33:29', '2019-12-03 03:33:29'),
(41, 'Cargar Pedido', 100, '2019-12-02 20:37:04', '2019-12-03 03:37:04', '2019-12-03 03:37:04'),
(42, 'Ver Pedido', 103, '2019-12-02 20:37:27', '2019-12-03 03:37:27', '2019-12-03 03:37:27'),
(43, 'Preparar pedido', 103, '2019-12-02 20:37:41', '2019-12-03 03:37:41', '2019-12-03 03:37:41'),
(44, 'Ver Pedido', 103, '2019-12-02 20:37:59', '2019-12-03 03:37:59', '2019-12-03 03:37:59'),
(45, 'Preparar pedido', 103, '2019-12-02 20:38:04', '2019-12-03 03:38:04', '2019-12-03 03:38:04'),
(46, 'Ver Pedido', 103, '2019-12-02 20:38:07', '2019-12-03 03:38:07', '2019-12-03 03:38:07'),
(47, 'Cancelar Pedido', 105, '2019-12-02 21:13:21', '2019-12-03 04:13:21', '2019-12-03 04:13:21'),
(48, 'Cancelar Pedido', 105, '2019-12-02 21:17:33', '2019-12-03 04:17:33', '2019-12-03 04:17:33'),
(49, 'Cancelar Pedido', 105, '2019-12-02 21:17:48', '2019-12-03 04:17:48', '2019-12-03 04:17:48'),
(50, 'Cerrar Mesa', 105, '2019-12-02 21:22:24', '2019-12-03 04:22:24', '2019-12-03 04:22:24'),
(51, 'Cerrar Mesa', 105, '2019-12-02 21:22:56', '2019-12-03 04:22:56', '2019-12-03 04:22:56'),
(52, 'Cerrar Mesa', 105, '2019-12-02 21:23:33', '2019-12-03 04:23:33', '2019-12-03 04:23:33'),
(53, 'Login', 101, '2019-12-02 22:22:50', '2019-12-03 05:22:50', '2019-12-03 05:22:50'),
(54, 'Cerrar Mesa', 101, '2019-12-02 22:23:03', '2019-12-03 05:23:03', '2019-12-03 05:23:03'),
(55, 'Cargar Pedido', 100, '2019-12-02 22:42:20', '2019-12-03 05:42:20', '2019-12-03 05:42:20'),
(56, 'Cargar Pedido', 100, '2019-12-02 22:42:44', '2019-12-03 05:42:44', '2019-12-03 05:42:44'),
(57, 'Cargar Pedido', 100, '2019-12-03 00:02:09', '2019-12-03 07:02:09', '2019-12-03 07:02:09'),
(58, 'Cargar Pedido', 100, '2019-12-03 00:02:10', '2019-12-03 07:02:10', '2019-12-03 07:02:10'),
(59, 'Cargar Pedido', 100, '2019-12-03 00:03:22', '2019-12-03 07:03:22', '2019-12-03 07:03:22'),
(60, 'Cobrar Pedido', 105, '2019-12-03 00:19:43', '2019-12-03 07:19:43', '2019-12-03 07:19:43'),
(61, 'Servir Pedido', 105, '2019-12-03 00:22:58', '2019-12-03 07:22:58', '2019-12-03 07:22:58'),
(62, 'Cargar Pedido', 100, '2019-12-03 13:30:39', '2019-12-03 20:30:39', '2019-12-03 20:30:39'),
(63, 'Cargar Pedido', 100, '2019-12-03 14:19:58', '2019-12-03 21:19:58', '2019-12-03 21:19:58'),
(64, 'Cargar Pedido', 100, '2019-12-03 14:21:58', '2019-12-03 21:21:58', '2019-12-03 21:21:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(100) NOT NULL,
  `id_comida` int(11) NOT NULL,
  `estado` varchar(300) COLLATE utf32_spanish2_ci NOT NULL DEFAULT 'pendiente',
  `codigo_unico` varchar(5) COLLATE utf32_spanish2_ci NOT NULL,
  `codigo_mesa` varchar(5) COLLATE utf32_spanish2_ci NOT NULL,
  `hora_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `tiempo_preparacion` int(11) DEFAULT NULL,
  `hora_entrega` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_comida`, `estado`, `codigo_unico`, `codigo_mesa`, `hora_creacion`, `tiempo_preparacion`, `hora_entrega`, `created_at`, `updated_at`) VALUES
(11, 1, 'cancelado', '77460', 'e6a47', '2019-12-02 19:50:34', 15, NULL, '2019-12-03 02:50:34', '2019-12-03 04:13:21'),
(12, 1, 'Cancelado', 'c896c', 'b1d8c', '2019-12-02 20:37:04', 20, NULL, '2019-12-03 03:37:04', '2019-12-03 04:17:33'),
(13, 3, 'Cancelado', 'c896c', 'b1d8c', '2019-12-02 20:37:04', 20, NULL, '2019-12-03 03:37:04', '2019-12-03 04:17:48'),
(14, 1, 'pendiente', 'f2313', '227be', '2019-12-02 22:42:20', NULL, NULL, '2019-12-03 05:42:20', '2019-12-03 05:42:20'),
(15, 1, 'pendiente', 'e0565', 'b20af', '2019-12-02 22:42:44', NULL, NULL, '2019-12-03 05:42:44', '2019-12-03 05:42:44'),
(16, 3, 'pendiente', 'e3087', '1e46d', '2019-12-03 00:02:08', NULL, NULL, '2019-12-03 07:02:09', '2019-12-03 07:02:09'),
(17, 3, 'pendiente', 'd1b76', '1a67e', '2019-12-03 00:02:10', NULL, NULL, '2019-12-03 07:02:10', '2019-12-03 07:02:10'),
(18, 3, 'Entregado', 'a8040', 'a1ebf', '2019-12-03 00:03:22', NULL, '2019-12-03 00:22:58', '2019-12-03 07:03:22', '2019-12-03 07:22:58'),
(19, 1, 'pendiente', '8c7d5', '4f27e', '2019-12-03 13:30:39', NULL, NULL, '2019-12-03 20:30:39', '2019-12-03 20:30:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comidas`
--
ALTER TABLE `comidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operaciones_registros`
--
ALTER TABLE `operaciones_registros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `comidas`
--
ALTER TABLE `comidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `operaciones_registros`
--
ALTER TABLE `operaciones_registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
