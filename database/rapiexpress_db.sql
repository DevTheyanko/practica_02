-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2025 a las 12:22:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rapiexpress_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `ID_Cargo` int(11) NOT NULL,
  `Cargo_Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`ID_Cargo`, `Cargo_Nombre`) VALUES
(1, 'Administrador'),
(2, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casilleros`
--

CREATE TABLE `casilleros` (
  `ID_Casillero` int(11) NOT NULL,
  `Casillero_Nombre` varchar(50) NOT NULL,
  `Direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `casilleros`
--

INSERT INTO `casilleros` (`ID_Casillero`, `Casillero_Nombre`, `Direccion`) VALUES
(1, 'Casillero 1', 'MIAMI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `ID_Categoria` int(11) NOT NULL,
  `Categoria_Nombre` varchar(50) DEFAULT NULL,
  `Categoria_Altura` decimal(10,2) DEFAULT NULL,
  `Categoria_Largo` decimal(10,2) DEFAULT NULL,
  `Categoria_Ancho` decimal(10,2) DEFAULT NULL,
  `Categoria_Peso` decimal(10,2) DEFAULT NULL,
  `Categoria_Piezas` int(11) DEFAULT NULL,
  `Categoria_Precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID_Cliente` int(11) NOT NULL,
  `Cedula_Identidad` varchar(23) NOT NULL,
  `Nombres_Cliente` varchar(50) NOT NULL,
  `Apellidos_Cliente` varchar(50) NOT NULL,
  `Direccion_Cliente` varchar(255) DEFAULT NULL,
  `Telefono_Cliente` varchar(20) DEFAULT NULL,
  `Correo_Cliente` varchar(100) DEFAULT NULL,
  `Fecha_Registro` datetime DEFAULT NULL,
  `ID_Sucursal` int(11) DEFAULT NULL,
  `ID_Casillero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID_Cliente`, `Cedula_Identidad`, `Nombres_Cliente`, `Apellidos_Cliente`, `Direccion_Cliente`, `Telefono_Cliente`, `Correo_Cliente`, `Fecha_Registro`, `ID_Sucursal`, `ID_Casillero`) VALUES
(1, '123456789', 'Juan', 'Martinez', 'Carrera 18', '04262345678', 'Juan@Martinez.com', '2025-07-11 06:03:48', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courier`
--

CREATE TABLE `courier` (
  `ID_Courier` int(11) NOT NULL,
  `RIF_Courier` varchar(23) NOT NULL,
  `Courier_Nombre` varchar(100) NOT NULL,
  `Courier_Direccion` varchar(255) DEFAULT NULL,
  `Courier_Telefono` varchar(20) DEFAULT NULL,
  `Courier_Correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `courier`
--

INSERT INTO `courier` (`ID_Courier`, `RIF_Courier`, `Courier_Nombre`, `Courier_Direccion`, `Courier_Telefono`, `Courier_Correo`) VALUES
(1, 'J-12345678-1', 'MRW', 'Venezuela', '04141234567', 'MRW@Venezuela.com'),
(2, 'J-12345678-2', 'FedEx', 'MIAMI', '04142345678', 'FedEx@MIAMI.COM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pagos`
--

CREATE TABLE `detalle_pagos` (
  `ID_Detalle` int(11) NOT NULL,
  `ID_Pago` int(11) NOT NULL,
  `Concepto_Pago` varchar(100) DEFAULT NULL,
  `Monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE `envios` (
  `ID_Envio` int(11) NOT NULL,
  `ID_Manifiesto` int(11) DEFAULT NULL,
  `Fecha_Envio` datetime DEFAULT NULL,
  `Fecha_Recepcion` datetime DEFAULT NULL,
  `Estado` enum('En tránsito','Recibido') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manifiestos_carga`
--

CREATE TABLE `manifiestos_carga` (
  `ID_Manifiesto` int(11) NOT NULL,
  `ID_Saca` int(11) DEFAULT NULL,
  `Fecha_Creacion` datetime DEFAULT NULL,
  `Aerolinea` varchar(100) DEFAULT NULL,
  `Estado` enum('Generado','Enviado','Verificado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `ID_Pago` int(11) NOT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Paquete` int(11) DEFAULT NULL,
  `Monto` decimal(10,2) DEFAULT NULL,
  `Metodo_Pago` enum('Transferencia','Efectivo') DEFAULT NULL,
  `Fecha_Pago` datetime DEFAULT NULL,
  `Estado` enum('Pendiente','Confirmado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `ID_Paquete` int(11) NOT NULL,
  `ID_Prealerta` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Categoria` int(11) DEFAULT NULL,
  `ID_Tracking` int(11) DEFAULT NULL,
  `ID_Sucursal` int(11) DEFAULT NULL,
  `ID_Courier` int(11) DEFAULT NULL,
  `Descripcion_pa` text DEFAULT NULL,
  `Estado` enum('Entrada','Procesado','Transito','Fallido','Entregado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes_sacas`
--

CREATE TABLE `paquetes_sacas` (
  `ID_Paquete` int(11) NOT NULL,
  `ID_Saca` int(11) NOT NULL,
  `Fecha_Asignacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prealertas`
--

CREATE TABLE `prealertas` (
  `ID_Prealerta` int(11) NOT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Tienda` int(11) DEFAULT NULL,
  `ID_Casillero` int(11) DEFAULT NULL,
  `Tracking_Tienda` varchar(100) DEFAULT NULL,
  `Prealerta_Piezas` int(11) DEFAULT NULL,
  `Prealerta_Peso` decimal(10,2) DEFAULT NULL,
  `Prealerta_Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sacas`
--

CREATE TABLE `sacas` (
  `ID_Saca` int(11) NOT NULL,
  `ID_Sucursal` int(11) DEFAULT NULL,
  `ID_Courier` int(11) DEFAULT NULL,
  `Saca_Total` decimal(10,2) DEFAULT NULL,
  `Saca_Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `ID_Sucursal` int(11) NOT NULL,
  `RIF_Sucursal` varchar(20) NOT NULL,
  `Sucursal_Nombre` varchar(50) NOT NULL,
  `Sucursal_Direccion` varchar(255) DEFAULT NULL,
  `Sucursal_Telefono` varchar(20) DEFAULT NULL,
  `Sucursal_Correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`ID_Sucursal`, `RIF_Sucursal`, `Sucursal_Nombre`, `Sucursal_Direccion`, `Sucursal_Telefono`, `Sucursal_Correo`) VALUES
(1, 'J-12345678-1', 'RapiExpress VEN', 'AV. LARA , BARQUISIMETO', '04241234567', 'RapiExpress@ven.com'),
(2, 'J-12345678-2', 'RapiExpress EC', 'Guayaquil', '04243456789', 'RapiExpress@ec.com'),
(3, 'J-12345678-3', 'BODEGA USA', 'Miami', '04244567891', 'RapiExpress@usa.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendas`
--

CREATE TABLE `tiendas` (
  `ID_Tienda` int(11) NOT NULL,
  `Tienda_Nombre` varchar(50) DEFAULT NULL,
  `Tienda_Direccion` varchar(255) DEFAULT NULL,
  `Tienda_Telefono` varchar(20) DEFAULT NULL,
  `Tienda_Correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiendas`
--

INSERT INTO `tiendas` (`ID_Tienda`, `Tienda_Nombre`, `Tienda_Direccion`, `Tienda_Telefono`, `Tienda_Correo`) VALUES
(1, 'Amazon', 'Online', '04141234567', 'support@amazon.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tracking`
--

CREATE TABLE `tracking` (
  `ID_Tracking` int(11) NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL,
  `Cedula_Identidad` varchar(23) NOT NULL,
  `Nombres_Usuario` varchar(50) NOT NULL,
  `Apellidos_Usuario` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Telefono_Usuario` varchar(20) DEFAULT NULL,
  `Correo_Usuario` varchar(100) DEFAULT NULL,
  `Direccion_Usuario` varchar(255) DEFAULT NULL,
  `Fecha_Registro` datetime DEFAULT NULL,
  `ID_Cargo` int(11) DEFAULT NULL,
  `ID_Sucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Cedula_Identidad`, `Nombres_Usuario`, `Apellidos_Usuario`, `Username`, `Password`, `Telefono_Usuario`, `Correo_Usuario`, `Direccion_Usuario`, `Fecha_Registro`, `ID_Cargo`, `ID_Sucursal`) VALUES
(1, 'V00000001', 'Admin', 'Principal', 'admin', '$2y$10$VbnFri/F9wdeEhrLDYD7Fe.1mpsN8X4wRQdrz13SU6ZlbUn711A1.', '04140000000', 'admin@correo.com', 'Dirección admin', '2025-07-09 19:33:22', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`ID_Cargo`);

--
-- Indices de la tabla `casilleros`
--
ALTER TABLE `casilleros`
  ADD PRIMARY KEY (`ID_Casillero`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_Cliente`),
  ADD KEY `ID_Casillero` (`ID_Casillero`),
  ADD KEY `idx_cliente_sucursal` (`ID_Sucursal`);

--
-- Indices de la tabla `courier`
--
ALTER TABLE `courier`
  ADD PRIMARY KEY (`ID_Courier`);

--
-- Indices de la tabla `detalle_pagos`
--
ALTER TABLE `detalle_pagos`
  ADD PRIMARY KEY (`ID_Detalle`),
  ADD KEY `ID_Pago` (`ID_Pago`);

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
  ADD PRIMARY KEY (`ID_Envio`),
  ADD KEY `ID_Manifiesto` (`ID_Manifiesto`);

--
-- Indices de la tabla `manifiestos_carga`
--
ALTER TABLE `manifiestos_carga`
  ADD PRIMARY KEY (`ID_Manifiesto`),
  ADD KEY `ID_Saca` (`ID_Saca`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`ID_Pago`),
  ADD KEY `ID_Cliente` (`ID_Cliente`),
  ADD KEY `ID_Paquete` (`ID_Paquete`),
  ADD KEY `idx_pago_estado_fecha` (`Estado`,`Fecha_Pago`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`ID_Paquete`),
  ADD KEY `ID_Prealerta` (`ID_Prealerta`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Categoria` (`ID_Categoria`),
  ADD KEY `ID_Tracking` (`ID_Tracking`),
  ADD KEY `ID_Sucursal` (`ID_Sucursal`),
  ADD KEY `ID_Courier` (`ID_Courier`),
  ADD KEY `idx_paquete_cliente_estado` (`ID_Cliente`,`Estado`);

--
-- Indices de la tabla `paquetes_sacas`
--
ALTER TABLE `paquetes_sacas`
  ADD PRIMARY KEY (`ID_Paquete`,`ID_Saca`),
  ADD KEY `ID_Saca` (`ID_Saca`);

--
-- Indices de la tabla `prealertas`
--
ALTER TABLE `prealertas`
  ADD PRIMARY KEY (`ID_Prealerta`),
  ADD KEY `ID_Cliente` (`ID_Cliente`),
  ADD KEY `ID_Tienda` (`ID_Tienda`),
  ADD KEY `ID_Casillero` (`ID_Casillero`);

--
-- Indices de la tabla `sacas`
--
ALTER TABLE `sacas`
  ADD PRIMARY KEY (`ID_Saca`),
  ADD KEY `ID_Sucursal` (`ID_Sucursal`),
  ADD KEY `ID_Courier` (`ID_Courier`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`ID_Sucursal`);

--
-- Indices de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  ADD PRIMARY KEY (`ID_Tienda`);

--
-- Indices de la tabla `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`ID_Tracking`),
  ADD KEY `idx_tracking_estado` (`Estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD KEY `ID_Cargo` (`ID_Cargo`),
  ADD KEY `ID_Sucursal` (`ID_Sucursal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `ID_Cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `casilleros`
--
ALTER TABLE `casilleros`
  MODIFY `ID_Casillero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `courier`
--
ALTER TABLE `courier`
  MODIFY `ID_Courier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_pagos`
--
ALTER TABLE `detalle_pagos`
  MODIFY `ID_Detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
  MODIFY `ID_Envio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `manifiestos_carga`
--
ALTER TABLE `manifiestos_carga`
  MODIFY `ID_Manifiesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `ID_Pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `ID_Paquete` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prealertas`
--
ALTER TABLE `prealertas`
  MODIFY `ID_Prealerta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sacas`
--
ALTER TABLE `sacas`
  MODIFY `ID_Saca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `ID_Sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  MODIFY `ID_Tienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tracking`
--
ALTER TABLE `tracking`
  MODIFY `ID_Tracking` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_casillero` FOREIGN KEY (`ID_Casillero`) REFERENCES `casilleros` (`ID_Casillero`),
  ADD CONSTRAINT `fk_clientes_sucursal` FOREIGN KEY (`ID_Sucursal`) REFERENCES `sucursales` (`ID_Sucursal`);

--
-- Filtros para la tabla `detalle_pagos`
--
ALTER TABLE `detalle_pagos`
  ADD CONSTRAINT `fk_detalle_pagos` FOREIGN KEY (`ID_Pago`) REFERENCES `pagos` (`ID_Pago`);

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `fk_envios_manifiesto` FOREIGN KEY (`ID_Manifiesto`) REFERENCES `manifiestos_carga` (`ID_Manifiesto`);

--
-- Filtros para la tabla `manifiestos_carga`
--
ALTER TABLE `manifiestos_carga`
  ADD CONSTRAINT `fk_manifiestos_saca` FOREIGN KEY (`ID_Saca`) REFERENCES `sacas` (`ID_Saca`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_pagos_cliente` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`),
  ADD CONSTRAINT `fk_pagos_paquete` FOREIGN KEY (`ID_Paquete`) REFERENCES `paquetes` (`ID_Paquete`);

--
-- Filtros para la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `fk_paquetes_categoria` FOREIGN KEY (`ID_Categoria`) REFERENCES `categorias` (`ID_Categoria`),
  ADD CONSTRAINT `fk_paquetes_cliente` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`),
  ADD CONSTRAINT `fk_paquetes_courier` FOREIGN KEY (`ID_Courier`) REFERENCES `courier` (`ID_Courier`),
  ADD CONSTRAINT `fk_paquetes_prealerta` FOREIGN KEY (`ID_Prealerta`) REFERENCES `prealertas` (`ID_Prealerta`),
  ADD CONSTRAINT `fk_paquetes_sucursal` FOREIGN KEY (`ID_Sucursal`) REFERENCES `sucursales` (`ID_Sucursal`),
  ADD CONSTRAINT `fk_paquetes_tracking` FOREIGN KEY (`ID_Tracking`) REFERENCES `tracking` (`ID_Tracking`),
  ADD CONSTRAINT `fk_paquetes_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`);

--
-- Filtros para la tabla `paquetes_sacas`
--
ALTER TABLE `paquetes_sacas`
  ADD CONSTRAINT `fk_paquetes_sacas_paquete` FOREIGN KEY (`ID_Paquete`) REFERENCES `paquetes` (`ID_Paquete`),
  ADD CONSTRAINT `fk_paquetes_sacas_saca` FOREIGN KEY (`ID_Saca`) REFERENCES `sacas` (`ID_Saca`);

--
-- Filtros para la tabla `prealertas`
--
ALTER TABLE `prealertas`
  ADD CONSTRAINT `fk_prealertas_casillero` FOREIGN KEY (`ID_Casillero`) REFERENCES `casilleros` (`ID_Casillero`),
  ADD CONSTRAINT `fk_prealertas_cliente` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`),
  ADD CONSTRAINT `fk_prealertas_tienda` FOREIGN KEY (`ID_Tienda`) REFERENCES `tiendas` (`ID_Tienda`);

--
-- Filtros para la tabla `sacas`
--
ALTER TABLE `sacas`
  ADD CONSTRAINT `fk_sacas_courier` FOREIGN KEY (`ID_Courier`) REFERENCES `courier` (`ID_Courier`),
  ADD CONSTRAINT `fk_sacas_sucursal` FOREIGN KEY (`ID_Sucursal`) REFERENCES `sucursales` (`ID_Sucursal`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_cargo` FOREIGN KEY (`ID_Cargo`) REFERENCES `cargos` (`ID_Cargo`),
  ADD CONSTRAINT `fk_usuarios_sucursal` FOREIGN KEY (`ID_Sucursal`) REFERENCES `sucursales` (`ID_Sucursal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
