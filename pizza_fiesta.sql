-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2021 a las 19:41:24
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pizza_fiesta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders_items`
--

CREATE TABLE `orders_items` (
  `id` int(11) NOT NULL,
  `pizza_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pizzas`
--

CREATE TABLE `pizzas` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ingredients` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `photo` longtext NOT NULL DEFAULT '\'https://images.unsplash.com/photo-1571066811602-716837d681de?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1431&q=80\'',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pizzas`
--

INSERT INTO `pizzas` (`id`, `name`, `description`, `ingredients`, `value`, `photo`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(3, 'la default', 'pizza por defecto', 'queso, salsa', 300, 'https://images.unsplash.com/photo-1571066811602-716837d681de?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1431&q=80', 1, 1, '2021-06-30 20:05:23', 1, '2021-07-14 16:36:43'),
(21, 'lomo suprema 3', '', 'piña,jamon,coco', 500, 'https://media.istockphoto.com/photos/picking-slice-of-pepperoni-pizza-picture-id1133727757?k=6&m=1133727757&s=612x612&w=0&h=6wLUhTKLTudlkgLXQxdOZIVr6D9zuIcMJhpgTVmOWMo=', 1, 1, '2021-07-13 15:53:58', 1, '2021-07-14 16:36:43'),
(22, 'tradicional', 'la misma pizza de toda la vida', 'salsa,mozzarella', 10, 'https://irecetasfaciles.com/wp-content/uploads/2019/08/pizza-de-jamon-queso-y-tocino.jpg', 1, 1, '2021-07-13 17:36:41', 1, '2021-07-14 16:36:43'),
(24, '4 quesos', 'para los mas atrevidos', 'parmesano,cheddar,gouda,matera', 100, 'https://elgourmet.s3.amazonaws.com/recetas/share/pizza_Mh3H4eanyBKEsStv1YclPWTf9OUqIi.png', 1, 1, '2021-07-13 17:40:57', 1, '2021-07-14 16:36:43'),
(25, 'prueba final', 'probablemente se edito esto como 100 veces', 'queso,jamon,aceitunas negras', 10, 'https://www.recetasdesbieta.com/wp-content/uploads/2018/09/Como-hacer-pizza-casera-rapida-con-masa-de-pizza-sin-repos-1.jpg', 1, 1, '2021-07-14 16:40:07', 1, NULL),
(26, 'la de la pulga', 'no tiene pulgas, no...', 'queso,champiñones,aceitunas', 5.99, 'https://i1.wp.com/hipertextual.com/wp-content/uploads/2020/01/hipertextual-pizzas-no-se-hacen-solas-pero-casi-2020510258.jpg?fit=1200%2C800&ssl=1', 1, 20, '2021-07-14 16:56:51', 21, '2021-07-14 17:09:19'),
(27, 'la del bicho', '¡siuuuuuuuuu!', 'salsa,queso,champiñones,elbicho', 6.99, 'https://fotos.perfil.com/2021/01/24/trim/1280/720/pizzas-de-verano-1118524.jpg', 1, 21, '2021-07-14 17:04:06', 21, '2021-07-14 17:08:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'USER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `direction`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@admin.com', 'admin', NULL, NULL, 1, '2021-07-01 14:57:53'),
(2, 'user', 'user@user.com', 'user', NULL, NULL, 2, '2021-07-01 14:57:53'),
(20, 'messi', 'messi@messi.com', 'messi', '', '', 2, '2021-07-14 16:55:20'),
(21, 'Cristiano', 'cristiano@elbicho.com', 'cristiano', '234234', '3242erwe', 2, '2021-07-14 17:02:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_cart`
--

CREATE TABLE `users_cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pizza_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_index` (`user_id`);

--
-- Indices de la tabla `orders_items`
--
ALTER TABLE `orders_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pizza_index` (`pizza_id`),
  ADD KEY `order_index` (`order_id`);

--
-- Indices de la tabla `pizzas`
--
ALTER TABLE `pizzas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `created_index` (`created_by`),
  ADD KEY `updated_index` (`updated_by`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol_index` (`role`);

--
-- Indices de la tabla `users_cart`
--
ALTER TABLE `users_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_index` (`user_id`),
  ADD KEY `pizza_index` (`pizza_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `orders_items`
--
ALTER TABLE `orders_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `pizzas`
--
ALTER TABLE `pizzas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `users_cart`
--
ALTER TABLE `users_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pizzas`
--
ALTER TABLE `pizzas`
  ADD CONSTRAINT `created_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `updated_fk` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `role_fk` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `users_cart`
--
ALTER TABLE `users_cart`
  ADD CONSTRAINT `pizza_fk` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
