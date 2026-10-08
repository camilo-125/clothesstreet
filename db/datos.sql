USE clothesstreet_db;

-- ============================================================
-- 1. INSERTAR USUARIOS
-- ============================================================
INSERT INTO usuario (rol, nombre, correo, contrasena, telefono, direccion_envio) VALUES
('administrador', 'Carlos Administrador', 'admin@clothesstreet.com', '1234', '3001234567', 'Oficina Central Calle 10 # 5-20'),
('cliente', 'Laura Gómez', 'laura.gomez@gmail.com', '1234', '3159876543', 'Carrera 15 # 45-30, Apto 201');

-- ============================================================
-- 2. INSERTAR PRODUCTOS (Precios en COP)
-- ============================================================
INSERT INTO producto (nombre, categoria, genero, precio, descripcion, imagen) VALUES
('Hoodie Oversize Medianoche', 'Hoodies', 'Unisex', 180000.00, 'Hoodie de algodón pesado con corte oversize.', 'img/hoodie.png'),
('Gorra Snapback Calle 5', 'Accesorios', 'Unisex', 95000.00, 'Gorra con visera plana y bordado frontal.', 'img/gorra.png'),
('Jersey Oversize Heavy Cotton', 'Camisetas', 'Hombre', 120000.00, 'Camiseta estampada corte boxy fit.', 'img/top.png');


-- ============================================================
-- 3. INSERTAR INVENTARIO (Variantes de talla y color)
-- ============================================================
INSERT INTO inventario (talla, color, stock_disponible, id_producto) VALUES
('M', 'Negro', 15, 1),   -- id_inventario = 1 (Hoodie M)
('L', 'Negro', 10, 1),   -- id_inventario = 2 (Hoodie L)
('Única', 'Negro', 12, 2), -- id_inventario = 3 (Gorra)
('S', 'Gris', 5, 3),     -- id_inventario = 4 (Jersey S)
('M', 'Gris', 7, 3);     -- id_inventario = 5 (Jersey M)

-- ============================================================
-- 4. INSERTAR FAVORITOS
-- ============================================================
INSERT INTO favoritos (id_usuario, id_producto) VALUES
(2, 3);

-- ============================================================
-- 5. INSERTAR CARRITO Y SUS ÍTEMS
-- ============================================================
INSERT INTO carrito (id_usuario) VALUES (2);

-- Laura tiene en el carrito:
-- 1 Hoodie ($180.000) + 1 Gorra ($95.000)
INSERT INTO item_carrito (cantidad, id_carrito, id_inventario) VALUES
(1, 1, 1),
(1, 1, 3);

-- ============================================================
-- 6. INSERTAR UN PEDIDO REALIZADO
-- ============================================================
-- Laura compró: 1 Hoodie M ($180.000) + 1 Jersey M ($120.000) = Total: $300.000 COP
INSERT INTO pedido (total, direccion_entrega, estado, id_usuario) VALUES
(300000.00, 'Carrera 15 # 45-30, Apto 201', 'pagado', 2);

-- ============================================================
-- 7. INSERTAR DETALLE HISTÓRICO DEL PEDIDO (item_pedido)
-- ============================================================
INSERT INTO item_pedido (cantidad, precio_unitario, id_pedido, id_inventario) VALUES
(1, 180000.00, 1, 1),
(1, 120000.00, 1, 5);