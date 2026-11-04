-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 05, 2026 at 12:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clothesstreet_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `fecha_creacion`, `id_usuario`) VALUES
(2, '2026-10-01 02:05:04', 4),
(3, '2026-10-07 14:34:51', 5);

-- --------------------------------------------------------

--
-- Table structure for table `favoritos`
--

CREATE TABLE `favoritos` (
  `id_favorito` int(11) NOT NULL,
  `fecha_agregado` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favoritos`
--

INSERT INTO `favoritos` (`id_favorito`, `fecha_agregado`, `id_usuario`, `id_producto`) VALUES
(6, '2026-10-06 20:15:27', 4, 18),
(7, '2026-10-06 20:15:28', 4, 20),
(8, '2026-10-07 14:34:51', 5, 18),
(9, '2026-10-07 17:30:47', 4, 2),
(14, '2026-10-08 00:58:58', 4, 14),
(15, '2026-10-08 00:59:05', 4, 10),
(16, '2026-10-08 01:02:08', 4, 19);

-- --------------------------------------------------------

--
-- Table structure for table `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `talla` varchar(10) NOT NULL,
  `color` varchar(30) NOT NULL,
  `stock_disponible` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `talla`, `color`, `stock_disponible`, `id_producto`) VALUES
(1, 'M', 'Negro', 15, 1),
(2, 'L', 'Negro', 10, 1),
(3, 'Única', 'Negro', 12, 2),
(4, 'S', 'Gris', 5, 3),
(5, 'M', 'Gris', 7, 3),
(6, 'M', 'Negro', 10, 4),
(7, 'L', 'Negro', 8, 4),
(8, 'M', 'Negro', 12, 5),
(9, 'L', 'Negro', 25, 6),
(10, '30', 'Negro', 7, 7),
(11, '32', 'Azul', 6, 8),
(12, 'M', 'Gris', 10, 9),
(13, 'S', 'Blanco', 14, 10),
(14, 'S', 'Beige', 8, 11),
(15, 'M', 'Azul', 9, 12),
(16, 'Única', 'Negro', 10, 13),
(17, 'Única', 'Negro', 16, 14),
(18, 'Única', 'Blanco', 25, 15),
(19, 'Única', 'Negro', 6, 16),
(20, 'L', 'Gris', 11, 17),
(21, 'M', 'Gris', 8, 18),
(22, 'L', 'Negro', 0, 19),
(23, 'M', 'Negro', 7, 20);

-- --------------------------------------------------------

--
-- Table structure for table `item_carrito`
--

CREATE TABLE `item_carrito` (
  `id_item_carrito` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_carrito`
--

INSERT INTO `item_carrito` (`id_item_carrito`, `cantidad`, `id_carrito`, `id_inventario`) VALUES
(14, 1, 2, 23),
(15, 2, 2, 20),
(16, 2, 2, 21);

-- --------------------------------------------------------

--
-- Table structure for table `item_pedido`
--

CREATE TABLE `item_pedido` (
  `id_item_pedido` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_pedido`
--

INSERT INTO `item_pedido` (`id_item_pedido`, `cantidad`, `precio_unitario`, `id_pedido`, `id_inventario`) VALUES
(3, 1, 240000.00, 2, 22),
(4, 1, 240000.00, 3, 22),
(5, 1, 185000.00, 3, 21),
(6, 1, 95000.00, 4, 17),
(7, 1, 185000.00, 5, 21),
(8, 1, 185000.00, 6, 21),
(9, 1, 185000.00, 7, 21),
(10, 1, 195000.00, 8, 23),
(11, 1, 240000.00, 9, 22),
(12, 1, 195000.00, 10, 23),
(13, 1, 240000.00, 11, 22),
(14, 1, 75000.00, 12, 13),
(15, 2, 185000.00, 13, 21),
(16, 1, 95000.00, 14, 17);

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `direccion_entrega` varchar(255) NOT NULL,
  `estado` enum('pendiente','pagado','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `fecha_pedido`, `total`, `direccion_entrega`, `estado`, `id_usuario`) VALUES
(2, '2026-10-01 01:56:18', 240000.00, 'calle1', 'enviado', 4),
(3, '2026-10-03 12:59:21', 425000.00, 'calle1', 'cancelado', 4),
(4, '2026-10-03 13:04:19', 95000.00, 'calle1', 'pagado', 4),
(5, '2026-10-06 20:34:18', 185000.00, 'calle1', 'cancelado', 4),
(6, '2026-10-07 14:23:33', 185000.00, 'calle1', 'pagado', 4),
(7, '2026-10-07 14:53:33', 185000.00, 'carrera 4', 'pagado', 5),
(8, '2026-10-07 14:55:31', 195000.00, 'calle1', 'pagado', 4),
(9, '2026-10-07 17:30:29', 240000.00, 'calle1', 'pagado', 4),
(10, '2026-10-07 23:53:01', 195000.00, 'calle1', 'pagado', 4),
(11, '2026-10-08 00:42:43', 240000.00, 'calle1', 'pagado', 4),
(12, '2026-10-08 00:59:21', 75000.00, 'calle1', 'pagado', 4),
(13, '2026-10-08 01:02:29', 370000.00, 'calle1', 'pagado', 4),
(14, '2026-10-08 01:06:22', 95000.00, 'calle1', 'pagado', 4);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `genero` enum('Hombre','Mujer','Unisex') NOT NULL DEFAULT 'Unisex',
  `precio` decimal(10,2) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) NOT NULL DEFAULT 'img/default.jpg',
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `categoria`, `genero`, `precio`, `descripcion`, `imagen`, `activo`) VALUES
(1, 'Hoodie Oversize Medianoche', 'Hoodies', 'Unisex', 180000.00, 'Hoodie de algodón pesado con corte oversize.', 'img/hoodie.png', 1),
(2, 'Gorra Snapback Calle 5', 'Accesorios', 'Unisex', 95000.00, 'Gorra con visera plana y bordado frontal.', 'img/gorra.png', 1),
(3, 'Jersey Oversize Heavy Cotton', 'Camisetas', 'Hombre', 120000.00, 'Camiseta estampada corte boxy fit.', 'img/top.png', 1),
(4, 'Camiseta Oversize Heavy Cotton', 'Camisetas', 'Hombre', 110000.00, 'Camiseta negra pesada corte boxy fit.', 'img/top.png', 1),
(5, 'Hoodie Midnight Black', 'Hoodies', 'Hombre', 180000.00, 'Hoodie de algodón afelpado con capucha gruesa.', 'img/hoodie.png', 1),
(6, 'Chaqueta Leather Street', 'Chaquetas', 'Hombre', 290000.00, 'Chaqueta de sintético con bordado frontal.', 'img/bomber.png', 1),
(7, 'Pantalón Cargo Tactical Black', 'Pantalones', 'Hombre', 210000.00, 'Pantalón cargo con bolsillos laterales y ajustador.', 'img/cargo.png', 1),
(8, 'Bermuda Denim Street', 'Bermudas', 'Hombre', 135000.00, 'Bermuda en jean rígido lavada.', 'img/bermuda.png', 1),
(9, 'Sweatpants Heavy Grey', 'Sweatpants', 'Hombre', 160000.00, 'Sudadera gris en algodón perchado.', 'img/sweatpants.png', 1),
(10, 'Crop Top Seamless Ribbed', 'Tops', 'Mujer', 75000.00, 'Crop top corto acanalado sin costuras.', 'img/croptop.png', 1),
(11, 'Falda Cargo Khaki', 'Faldas', 'Mujer', 125000.00, 'Falda estilo cargo con bolsillos laterales.', 'img/falda.png', 1),
(12, 'Shorts High Waist Denim', 'Shorts', 'Mujer', 95000.00, 'Short en tiro alto lavado claro.', 'img/shorts.png', 1),
(13, 'Shoulder Bag Mini', 'Bolsos', 'Mujer', 85000.00, 'Bolso de hombro compacto.', 'img/shoulderbag.png', 1),
(14, 'Gorra Snapback Calle 5', 'Accesorios', 'Unisex', 95000.00, 'Gorra con visera plana y bordado frontal.', 'img/gorra.png', 1),
(15, 'Pack Medias High Socks x3', 'Medias', 'Unisex', 45000.00, 'Pack de 3 pares de medias con logo bordado.', 'img/medias.png', 1),
(16, 'Chest Rig Utility Bag', 'Bolsos', 'Unisex', 120000.00, 'Bolso pechera táctico impermeable.', 'img/chestrig.png', 1),
(17, 'Camiseta Vintage Acid Wash', 'Camisetas', 'Unisex', 115000.00, 'Camiseta lavada efecto desgastado.', 'img/top.png', 1),
(18, 'Hoodie Oversize Essential', 'Hoodies', 'Unisex', 185000.00, 'Hoodie gris básico holgado.', 'img/hoodie.png', 1),
(19, 'Chaqueta Rompevientos Street', 'Chaquetas', 'Unisex', 240000.00, 'Chaqueta liviana impermeable.', 'img/bomber.png', 0),
(20, 'Pantalón Cargo Wide Leg', 'Pantalones', 'Unisex', 195000.00, 'Pantalón de bota ancha ajuste elástico.', 'img/cargo.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `rol` enum('cliente','administrador') NOT NULL DEFAULT 'cliente',
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion_envio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `rol`, `nombre`, `correo`, `contrasena`, `telefono`, `direccion_envio`) VALUES
(1, 'administrador', 'Carlos Administrador', 'admin@clothesstreet.com', '$2y$10$4n9x5w59EegI66/83v68I.xYgC0yvIuS9j3sKx4.wP9W7L5v2o5iG', '3001234567', 'Oficina Central Calle 10 # 5-20'),
(2, 'cliente', 'Laura Gómez', 'laura.gomez@gmail.com', '$2y$10$4n9x5w59EegI66/83v68I.xYgC0yvIuS9j3sKx4.wP9W7L5v2o5iG', '3159876543', 'Carrera 15 # 45-30, Apto 201'),
(3, 'administrador', 'camilo', 'camilo@gmail.com', '$2y$10$l/u.DZ.wRetPBGo74FBDXuIsrEoC5r/HILmkSOygbpBiAau7OcOvG', '12323123', 'calle64 bn'),
(4, 'cliente', 'daniel', 'daniel@gmail.com', '$2y$10$1g7U3tVSz/oeF70k.573IeB1IGcuUy9Q3mcmVuw00yyqIn4NWmhlu', '123445677', 'calle1'),
(5, 'cliente', 'olapik', 'olapik@gmail.com', '$2y$10$yqb/VJSLkQOYwbrEJ5JQCeMT5VnCm/T8QCVrsIYBoudcwmlrSvEe2', '32112345678', 'carrera 4'),
(6, 'cliente', 'david', 'david@gmail.com', '$2y$10$7nz6POaGV26/sfqtvQi7leKc/.5u55D2BmiKuBDWHXl.xuTLEsi6W', '1234567', 'la paz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id_favorito`),
  ADD KEY `fk_favoritos_usuario` (`id_usuario`),
  ADD KEY `fk_favoritos_producto` (`id_producto`);

--
-- Indexes for table `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `fk_inventario_producto` (`id_producto`);

--
-- Indexes for table `item_carrito`
--
ALTER TABLE `item_carrito`
  ADD PRIMARY KEY (`id_item_carrito`),
  ADD KEY `fk_item_carrito_carrito` (`id_carrito`),
  ADD KEY `fk_item_carrito_inventario` (`id_inventario`);

--
-- Indexes for table `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`id_item_pedido`),
  ADD KEY `fk_item_pedido_pedido` (`id_pedido`),
  ADD KEY `fk_item_pedido_inventario` (`id_inventario`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_usuario` (`id_usuario`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id_favorito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `item_carrito`
--
ALTER TABLE `item_carrito`
  MODIFY `id_item_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `item_pedido`
--
ALTER TABLE `item_pedido`
  MODIFY `id_item_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_carrito_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `fk_favoritos_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_favoritos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_carrito`
--
ALTER TABLE `item_carrito`
  ADD CONSTRAINT `fk_item_carrito_carrito` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_item_carrito_inventario` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD CONSTRAINT `fk_item_pedido_inventario` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_item_pedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
