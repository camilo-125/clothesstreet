USE clothesstreet_db;

-- ============================================================
-- 1. LIMPIAR E INSERTAR PRODUCTOS
-- ============================================================

INSERT INTO producto (nombre, categoria, genero, precio, descripcion, imagen) VALUES 
-- HOMBRE
('Camiseta Oversize Heavy Cotton', 'Camisetas', 'Hombre', 110000.00, 'Camiseta negra pesada corte boxy fit.', 'img/top.png'),
('Hoodie Midnight Black', 'Hoodies', 'Hombre', 180000.00, 'Hoodie de algodón afelpado con capucha gruesa.', 'img/hoodie.png'),
('Chaqueta Leather Street', 'Chaquetas', 'Hombre', 290000.00, 'Chaqueta de sintético con bordado frontal.', 'img/bomber.png'),
('Pantalón Cargo Tactical Black', 'Pantalones', 'Hombre', 210000.00, 'Pantalón cargo con bolsillos laterales y ajustador.', 'img/cargo.png'),
('Bermuda Denim Street', 'Bermudas', 'Hombre', 135000.00, 'Bermuda en jean rígido lavada.', 'img/bermuda.png'),
('Sweatpants Heavy Grey', 'Sweatpants', 'Hombre', 160000.00, 'Sudadera gris en algodón perchado.', 'img/sweatpants.png'),

-- MUJER
('Crop Top Seamless Ribbed', 'Tops', 'Mujer', 75000.00, 'Crop top corto acanalado sin costuras.', 'img/croptop.png'),
('Falda Cargo Khaki', 'Faldas', 'Mujer', 125000.00, 'Falda estilo cargo con bolsillos laterales.', 'img/falda.png'),
('Shorts High Waist Denim', 'Shorts', 'Mujer', 95000.00, 'Short en tiro alto lavado claro.', 'img/shorts.png'),
('Shoulder Bag Mini', 'Bolsos', 'Mujer', 85000.00, 'Bolso de hombro compacto.', 'img/shoulderbag.png'),

-- UNISEX (Aparecen automáticamente en Men\'s y Women\'s)
('Gorra Snapback Calle 5', 'Accesorios', 'Unisex', 95000.00, 'Gorra con visera plana y bordado frontal.', 'img/gorra.png'),
('Pack Medias High Socks x3', 'Medias', 'Unisex', 45000.00, 'Pack de 3 pares de medias con logo bordado.', 'img/medias.png'),
('Chest Rig Utility Bag', 'Bolsos', 'Unisex', 120000.00, 'Bolso pechera táctico impermeable.', 'img/chestrig.png'),
('Camiseta Vintage Acid Wash', 'Camisetas', 'Unisex', 115000.00, 'Camiseta lavada efecto desgastado.', 'img/top.png'),
('Hoodie Oversize Essential', 'Hoodies', 'Unisex', 185000.00, 'Hoodie gris básico holgado.', 'img/hoodie.png'),
('Chaqueta Rompevientos Street', 'Chaquetas', 'Unisex', 240000.00, 'Chaqueta liviana impermeable.', 'img/bomber.png'),
('Pantalón Cargo Wide Leg', 'Pantalones', 'Unisex', 195000.00, 'Pantalón de bota ancha ajuste elástico.', 'img/cargo.png');

-- ============================================================
-- 2. INSERTAR VARIANTES DE INVENTARIO PARA CADA PRODUCTO
-- ============================================================

INSERT INTO inventario (talla, color, stock_disponible, id_producto) VALUES
-- Camiseta Hombre (id_producto 4)
('M', 'Negro', 10, 4),
('L', 'Negro', 8, 4),

-- Hoodie Hombre (id_producto 5)
('M', 'Negro', 12, 5),

-- Chaqueta Hombre (id_producto 6)
('L', 'Negro', 5, 6),

-- Pantalón Cargo Hombre (id_producto 7)
('30', 'Negro', 7, 7),

-- Bermuda Hombre (id_producto 8)
('32', 'Azul', 6, 8),

-- Sweatpants Hombre (id_producto 9)
('M', 'Gris', 10, 9),

-- Crop Top Mujer (id_producto 10)
('S', 'Blanco', 15, 10),

-- Falda Mujer (id_producto 11)
('S', 'Beige', 8, 11),

-- Shorts Mujer (id_producto 12)
('M', 'Azul', 9, 12),

-- Shoulder Bag Mujer (id_producto 13)
('Única', 'Negro', 10, 13),

-- Gorra Unisex (id_producto 14)
('Única', 'Negro', 15, 14),

-- Medias Unisex (id_producto 15)
('Única', 'Blanco', 25, 15),

-- Chest Rig Unisex (id_producto 16)
('Única', 'Negro', 6, 16),

-- Camiseta Unisex (id_producto 17)
('L', 'Gris', 11, 17),

-- Hoodie Unisex (id_producto 18)
('M', 'Gris', 14, 18),

-- Chaqueta Unisex (id_producto 19)
('L', 'Negro', 4, 19),

-- Pantalón Cargo Unisex (id_producto 20)
('M', 'Negro', 9, 20);