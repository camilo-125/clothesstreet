CREATE DATABASE IF NOT EXISTS clothesstreet_db;
USE clothesstreet_db;

-- 1. TABLA: usuario
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT NOT NULL,
    rol ENUM('cliente', 'administrador') NOT NULL DEFAULT 'cliente',
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) DEFAULT NULL,
    direccion_envio VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. TABLA: producto (Incluye la columna imagen y activo)
CREATE TABLE producto (
    id_producto INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    genero ENUM('Hombre', 'Mujer', 'Unisex') NOT NULL DEFAULT 'Unisex',
    precio DECIMAL(10,2) NOT NULL,
    descripcion VARCHAR(255) DEFAULT NULL,
    imagen VARCHAR(255) NOT NULL DEFAULT 'img/default.jpg',
    activo TINYINT(1) DEFAULT 1,
    PRIMARY KEY (id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. TABLA: inventario
CREATE TABLE inventario (
    id_inventario INT AUTO_INCREMENT NOT NULL,
    talla VARCHAR(10) NOT NULL,
    color VARCHAR(30) NOT NULL,
    stock_disponible INT NOT NULL,
    id_producto INT NOT NULL,
    PRIMARY KEY (id_inventario),
    CONSTRAINT fk_inventario_producto FOREIGN KEY (id_producto) 
        REFERENCES producto(id_producto) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. TABLA: favoritos
CREATE TABLE favoritos (
    id_favorito INT AUTO_INCREMENT NOT NULL,
    fecha_agregado DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT NOT NULL,
    id_producto INT NOT NULL,
    PRIMARY KEY (id_favorito),
    CONSTRAINT fk_favoritos_usuario FOREIGN KEY (id_usuario) 
        REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_favoritos_producto FOREIGN KEY (id_producto) 
        REFERENCES producto(id_producto) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5. TABLA: carrito
CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT NOT NULL UNIQUE,
    PRIMARY KEY (id_carrito),
    CONSTRAINT fk_carrito_usuario FOREIGN KEY (id_usuario) 
        REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 6. TABLA: item_carrito
CREATE TABLE item_carrito (
    id_item_carrito INT AUTO_INCREMENT NOT NULL,
    cantidad INT NOT NULL,
    id_carrito INT NOT NULL,
    id_inventario INT NOT NULL,
    PRIMARY KEY (id_item_carrito),
    CONSTRAINT fk_item_carrito_carrito FOREIGN KEY (id_carrito) 
        REFERENCES carrito(id_carrito) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_item_carrito_inventario FOREIGN KEY (id_inventario) 
        REFERENCES inventario(id_inventario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 7. TABLA: pedido
CREATE TABLE pedido (
    id_pedido INT AUTO_INCREMENT NOT NULL,
    fecha_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    direccion_entrega VARCHAR(255) NOT NULL,
    estado ENUM('pendiente', 'pagado', 'enviado', 'entregado', 'cancelado') NOT NULL DEFAULT 'pendiente',
    id_usuario INT NOT NULL,
    PRIMARY KEY (id_pedido),
    CONSTRAINT fk_pedido_usuario FOREIGN KEY (id_usuario) 
        REFERENCES usuario(id_usuario) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 8. TABLA: item_pedido
CREATE TABLE item_pedido (
    id_item_pedido INT AUTO_INCREMENT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    id_pedido INT NOT NULL,
    id_inventario INT NOT NULL,
    PRIMARY KEY (id_item_pedido),
    CONSTRAINT fk_item_pedido_pedido FOREIGN KEY (id_pedido) 
        REFERENCES pedido(id_pedido) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_item_pedido_inventario FOREIGN KEY (id_inventario) 
        REFERENCES inventario(id_inventario) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;