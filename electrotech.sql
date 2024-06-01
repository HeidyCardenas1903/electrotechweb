-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-03-2024 a las 02:35:37
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `electrotech`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))   BEGIN 
    	DECLARE precio_actual decimal(10,2);
        SELECT precio INTO precio_actual FROM productos WHERE id = codigo;

        INSERT INTO detalle_temp(token_user,id_producto,cantidad,preciototal) VALUES (token_user,codigo,cantidad,precio_actual);

        SELECT tmp.correlativo, tmp.id_producto, p.nombre, tmp.cantidad, tmp.preciototal FROM detalle_temp tmp INNER JOIN productos p 
        ON tmp.id_producto = p.id
        WHERE tmp.token_user = token_user;
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_factura` (IN `no_factura` INT)   BEGIN
    DECLARE existe_factura int;
    DECLARE registros int;
    DECLARE a int;

    DECLARE cod_producto int ;
    DECLARE cant_producto int ;
    DECLARE existencia_actual int ;
    DECLARE nueva_existencia int ;


    SET existe_factura = (SELECT COUNT(*) FROM facturas WHERE id = no_factura AND estatus = 1);

    IF existe_factura > 0 THEN
      CREATE TEMPORARY TABLE tbl_tmp (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        cod_prod BIGINT,
        cant_prod INT);

        SET a = 1;

        SET registros = (SELECT COUNT(*) FROM detallefactura WHERE id_factura = no_factura);

        IF registros > 0 THEN
          INSERT INTO tbl_tmp(cod_prod, cant_prod) SELECT id_producto, cantidad FROM detallefactura WHERE id_factura = no_factura;

          WHILE a <= registros DO 
            SELECT cod_prod, cant_prod INTO cod_producto, cant_producto FROM tbl_tmp WHERE id = a;
            SELECT stock INTO existencia_actual FROM productos WHERE id = cod_producto;
            SET nueva_existencia = existencia_actual + cant_producto;

            UPDATE productos SET stock = nueva_existencia WHERE id = cod_producto;

            SET a=a+1;

          END WHILE;

          UPDATE facturas SET estatus = 2 WHERE id = no_factura;
          DROP TABLE tbl_tmp;

          SELECT * FROM facturas WHERE id = no_factura;

        END IF;
    
    ELSE
      SELECT 0 factura;
    END IF;

  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp` (`id_detalle` INT, `token` VARCHAR(50))   BEGIN
    	DELETE FROM detalle_temp WHERE correlativo = id_detalle;
        
        SELECT tmp.correlativo, tmp.id_producto, p.nombre, tmp.cantidad, tmp.preciototal
        FROM detalle_temp tmp INNER JOIN productos p
        ON tmp.id_producto = p.id
        WHERE tmp.token_user = token;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (`id_usuario` INT, `cod_cliente` INT, `token` VARCHAR(50))   BEGIN
		DECLARE factura INT;
        DECLARE registros INT;

        DEClARE total DECIMAL(10,2);

        DECLARE nueva_existencia int;
        DECLARE existencia_actual int;

        DECLARE tmp_cod_producto int;
        DECLARE tmp_cant_producto int;
        
        DECLARE a INT;
        SET a = 1;
        
        CREATE TEMPORARY TABLE tbl_tmp_tokenuser (
        	id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            cod_prod BIGINT,
            cant_prod int
        );
        SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);

        IF registros > 0 THEN
            INSERT INTO tbl_tmp_tokenuser(cod_prod, cant_prod) SELECT id_producto, cantidad FROM detalle_temp WHERE token_user = token; 

            INSERT INTO facturas(id_usuario, id_cliente) VALUES(id_usuario, cod_cliente);
            SET factura = LAST_INSERT_ID();

            INSERT INTO detallefactura(id_factura, id_producto, cantidad, preciototal) SELECT (factura) as id_factura, id_producto, cantidad, preciototal FROM detalle_temp WHERE token_user = token;

            WHILE a <= registros DO
                SELECT cod_prod, cant_prod INTO tmp_cod_producto, tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
                SELECT stock INTO existencia_actual FROM productos WHERE id = tmp_cod_producto;

                SET nueva_existencia = existencia_actual - tmp_cant_producto;
                UPDATE productos SET stock = nueva_existencia WHERE id = tmp_cod_producto;

                SET a=a+1;

            END WHILE;

            SET total = (SELECT SUM(cantidad * preciototal) FROM detalle_temp WHERE token_user = token);
            UPDATE facturas SET totalfactura = total WHERE id = factura;

            DELETE FROM detalle_temp WHERE token_user = token;
            TRUNCATE TABLE tbl_tmp_tokenuser;
            SELECT * FROM facturas WHERE id = factura;

        ELSE
            SELECT 0;
        END IF;

	END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `email`, `telefono`, `id_rol`) VALUES
(5, 'Johan Alejandro', 'Castañeda', 'cirowe1517@royalka.com', '3117654321', 3),
(13, 'Ana Rosa', 'Orduña', 'shdgajhg@irir.com', '3225453718', 3),
(18, 'Johan Alejandro', 'Guerrero Castañeda ', 'johan2783@outlook.com', '3145672345', 3),
(20, 'Sandra Milena ', 'Espinosa Soler', 'Sandrita1221@outlook.com', '3142356789', 3),
(52308875, 'Luz', 'Niño', 'nino@gmail.com', '3112860347', 3),
(1010960107, 'Diego', 'Castillo', 'dacn@gmail.com', '3112860047', 3),
(1073526432, 'Javier Steven', 'Castillo Niño', 'cjavier046@gmail.com', '3112860347', 3),
(2147483647, 'kasbd', 'casyillo', 'kihsab@gmail.com', '8465', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nit` int(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `telefono` bigint(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `iva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nit`, `nombre`, `razon_social`, `telefono`, `email`, `direccion`, `iva`) VALUES
(1, 123456789, 'Electrotech', '', 30215654875, 'soporte.electrotechdh@gmail.com', 'Cl 18 No. 35-69', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` bigint(11) NOT NULL,
  `id_factura` bigint(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `preciototal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallefactura`
--

INSERT INTO `detallefactura` (`correlativo`, `id_factura`, `id_producto`, `cantidad`, `preciototal`) VALUES
(72, 45, 8, 1, 1300000.00),
(73, 46, 9, 1, 789000.00),
(74, 47, 8, 2, 1300000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `preciototal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `correlativo` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `totalfactura` decimal(10,2) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `fecha`, `id_usuario`, `id_cliente`, `totalfactura`, `estatus`) VALUES
(44, '2024-03-11 17:03:50', 51, 5, 30.00, 2),
(45, '2024-03-11 18:43:46', 51, 5, 1300000.00, 2),
(46, '2024-03-11 19:07:09', 51, 5, 789000.00, 2),
(47, '2024-03-11 19:41:11', 51, 5, 2600000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodopago`
--

CREATE TABLE `metodopago` (
  `id` int(5) NOT NULL,
  `tipodepago` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodopago`
--

INSERT INTO `metodopago` (`id`, `tipodepago`) VALUES
(1, 'Tarjeta de Créd'),
(2, 'Efectivo'),
(3, 'Sistecredi Elec');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  `img` longblob NOT NULL,
  `id_proveedor` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `precio`, `stock`, `img`, `id_proveedor`, `nombre`, `descripcion`, `fecha_add`) VALUES
(8, 1300000, 8, '', 1819819831, 'REDMI Note 13 Pro', 'REDMI Note 13 Pro\r\nREDMI Note 13 Pro\r\nREDMI Note 13 Pro', '2024-03-11 17:23:12'),
(9, 789000, 25, '', 1819819831, 'REDMI Note 13', 'REDMI Note 13\r\nREDMI Note 13\r\nREDMI Note 13', '2024-03-11 17:23:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `nit` int(10) NOT NULL,
  `razonsocial` varchar(60) NOT NULL,
  `encargado` varchar(30) NOT NULL,
  `celular` int(15) NOT NULL,
  `correo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`nit`, `razonsocial`, `encargado`, `celular`, `correo`) VALUES
(830028931, 'Samsung Colombia', 'Jay Y. Lee', 600, 'cc.estoreco@samsung.com'),
(1819819831, 'Xiaomi ', 'Stephen King', 2147483647, 'xiaomisupport@gmail.com'),
(2147483647, 'Apple Inc', 'Bill Gates', 2147483647, 'applesupport@icloud.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador(a)'),
(3, 'Cliente'),
(2, 'Vendedor(a)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `last_session` datetime DEFAULT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `codigo_recuperacion` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `id_rol`, `email`, `last_session`, `activacion`, `password_request`, `codigo_recuperacion`) VALUES
(49, 'William Riaño', 'Willy0482', '$2y$10$7HDuteUu6.q9T5c2mPHswesC2ANdWYWYd4yNlyASj9yMsqxKeYdgS', 2, 'willi08422@gmail.com', NULL, 0, 0, NULL),
(51, 'Diego Castillo', 'Dacn2004', '$2y$10$kbJsTXmmJCQe1VqeqKdrFOF8vmbwmHtbv6koSD2upXG30GFe/JA7O', 1, 'Dacnsena@gmail.com', NULL, 0, 0, '647906'),
(52, 'Daniel Hibañez', 'Daniel4561', '$2y$10$3D6MqaBiH4ptjveYDh4mR.7PkZyriLd0EEWd0AGR6SiU00nisF3R6', 2, 'josedanielca27@gmail.com', NULL, 0, 0, NULL),
(53, 'Heidy Viviana Cardenas Soler', 'Heidy19', '$2y$10$sBm4SNQJv/0qaDxYuZqHDuyyQnBlBbYpUku7LyNoj2tgLajTJ4EFm', 1, 'hvcardenas2005@gmail.com', NULL, 0, 0, NULL),
(54, 'werwe', 'Ynelram', '$2y$10$qOM1/CdjfSHBJE1l26.REuAiWXde9IeXkzfAQU2L/R1.UkhCN1naS', 2, 'cjavier046@gmail.com', NULL, 0, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `metodopago`
--
ALTER TABLE `metodopago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_proveedor_2` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`nit`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `metodopago`
--
ALTER TABLE `metodopago`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `nit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas-cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facturas-usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`nit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
