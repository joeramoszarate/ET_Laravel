-- Explore Tumbes database dump (generated from migrations)
-- MySQL compatible SQL (InnoDB, utf8mb4)

SET FOREIGN_KEY_CHECKS=0;

-- Table: tiporol
CREATE TABLE IF NOT EXISTS `tiporol` (
  `id_tiprol` CHAR(18) NOT NULL,
  `descripcion` CHAR(18),
  PRIMARY KEY (`id_tiprol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: tipodocumento
CREATE TABLE IF NOT EXISTS `tipodocumento` (
  `id_tipdoc` VARCHAR(7) NOT NULL,
  `descripcion` CHAR(18),
  PRIMARY KEY (`id_tipdoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: tipopasajero
CREATE TABLE IF NOT EXISTS `tipopasajero` (
  `id_tippax` VARCHAR(7) NOT NULL,
  `descripcion` CHAR(18),
  PRIMARY KEY (`id_tippax`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: tipopaquete
CREATE TABLE IF NOT EXISTS `tipopaquete` (
  `id_tippaq` VARCHAR(7) NOT NULL,
  `descripcion` CHAR(18),
  PRIMARY KEY (`id_tippaq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: metodopago
CREATE TABLE IF NOT EXISTS `metodopago` (
  `id_metpago` VARCHAR(7) NOT NULL,
  `descripcion` CHAR(18),
  PRIMARY KEY (`id_metpago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: tipocomprobante
CREATE TABLE IF NOT EXISTS `tipocomprobante` (
  `id_tipcom` CHAR(5) NOT NULL,
  `descripcion` CHAR(18),
  PRIMARY KEY (`id_tipcom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: destino
CREATE TABLE IF NOT EXISTS `destino` (
  `id_destino` VARCHAR(7) NOT NULL,
  `nombre` CHAR(18) NOT NULL,
  `descripcion` CHAR(18) NOT NULL,
  `categoria` CHAR(18) NOT NULL,
  `temperatura_prom` CHAR(18),
  `imagen_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_destino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: categoriatour
CREATE TABLE IF NOT EXISTS `categoriatour` (
  `id_catto` VARCHAR(7) NOT NULL,
  `descripcion` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_catto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` VARCHAR(7) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `apellidos` VARCHAR(100) NOT NULL,
  `nro_documento` CHAR(18) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `contraseña` CHAR(8) NOT NULL,
  `nacionalidad` CHAR(18),
  `id_tipdoc` VARCHAR(7) NOT NULL,
  `telefono` CHAR(18),
  PRIMARY KEY (`id_cliente`),
  KEY `fk_cliente_tipodoc` (`id_tipdoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_tiprol` CHAR(18) NOT NULL,
  `id_usuario` CHAR(18) NOT NULL,
  `nombre` CHAR(18),
  `correo` CHAR(18),
  `contraseña` CHAR(18),
  `telefono` CHAR(18),
  `direccion` CHAR(18),
  `apellidos` CHAR(18),
  `id_tipdoc` VARCHAR(7) NOT NULL,
  `nro_documento` CHAR(18),
  `fecha_registro` CHAR(18),
  `estado` CHAR(18),
  PRIMARY KEY (`id_usuario`),
  KEY `fk_usuario_tiporol` (`id_tiprol`),
  KEY `fk_usuario_tipodoc` (`id_tipdoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: tour
CREATE TABLE IF NOT EXISTS `tour` (
  `id_tour` VARCHAR(7) NOT NULL,
  `duracion_dias` INT,
  `estado` CHAR(18) NOT NULL,
  `id_destino` VARCHAR(7) NOT NULL,
  `nombre_tour` VARCHAR(150) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `ubicacion_exacta` VARCHAR(150) NOT NULL,
  `imagen_url` VARCHAR(255) NOT NULL,
  `id_catto` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id_tour`),
  KEY `fk_tour_destino` (`id_destino`),
  KEY `fk_tour_cattour` (`id_catto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: paquetes
CREATE TABLE IF NOT EXISTS `paquetes` (
  `id_paquete` VARCHAR(7) NOT NULL,
  `nombre_paquete` VARCHAR(150) NOT NULL,
  `estado` CHAR(1) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `precio_base` DECIMAL(10,2) NOT NULL,
  `id_tippaq` VARCHAR(7) NOT NULL,
  `imagen_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_paquete`),
  KEY `fk_paquetes_tippaq` (`id_tippaq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: detpaquetedestino
CREATE TABLE IF NOT EXISTS `detpaquetedestino` (
  `id_detpaqdest` VARCHAR(7) NOT NULL,
  `id_paquete` VARCHAR(7) NOT NULL,
  `id_destino` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id_detpaqdest`),
  KEY `fk_detpaquetedestino_paquete` (`id_paquete`),
  KEY `fk_detpaquetedestino_destino` (`id_destino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: detallereservapaquete
CREATE TABLE IF NOT EXISTS `detallereservapaquete` (
  `id_numrep` VARCHAR(7) NOT NULL,
  `id_paquete` VARCHAR(7) NOT NULL,
  `cantidad_persona` INT NOT NULL,
  `precio_unitario` DECIMAL(10,2),
  `id_reserva` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id_numrep`),
  KEY `fk_detrespaq_paquete` (`id_paquete`),
  KEY `fk_detrespaq_reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: reserva
CREATE TABLE IF NOT EXISTS `reserva` (
  `id_reserva` VARCHAR(7) NOT NULL,
  `precio_publicado` DECIMAL(10,2) NOT NULL,
  `estado` CHAR(1) NOT NULL,
  `fecha_reserva` DATETIME NOT NULL,
  `observaciones` TEXT,
  `id_usuario` CHAR(18) NOT NULL,
  `id_cliente` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `fk_reserva_usuario` (`id_usuario`),
  KEY `fk_reserva_cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: detallereservatour
CREATE TABLE IF NOT EXISTS `detallereservatour` (
  `id_numreto` VARCHAR(7) NOT NULL,
  `id_tour` VARCHAR(7) NOT NULL,
  `cantidad_persona` INT NOT NULL,
  `precio_unitario` DECIMAL(10,2),
  `id_reserva` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id_numreto`),
  KEY `fk_detrestour_tour` (`id_tour`),
  KEY `fk_detrestour_reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: comprobantepago
CREATE TABLE IF NOT EXISTS `comprobantepago` (
  `id_compag` VARCHAR(7) NOT NULL,
  `num_serie` CHAR(18),
  `observaciones` TEXT,
  `id_reserva` VARCHAR(7) NOT NULL,
  `num_correlativo` CHAR(18) NOT NULL,
  `fecha_emision` DATETIME NOT NULL,
  `monto_facturado` DECIMAL(10,2) NOT NULL,
  `id_metpago` VARCHAR(7) NOT NULL,
  `id_tipcom` CHAR(5) NOT NULL,
  PRIMARY KEY (`id_compag`),
  KEY `fk_comppago_reserva` (`id_reserva`),
  KEY `fk_comppago_metpago` (`id_metpago`),
  KEY `fk_comppago_tipcom` (`id_tipcom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: detallepago
CREATE TABLE IF NOT EXISTS `detallepago` (
  `id_detpag` CHAR(18) NOT NULL,
  `cantidad_items` CHAR(18),
  `precio_unitario` CHAR(18),
  `id_compag` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id_detpag`),
  KEY `fk_detpago_compag` (`id_compag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: pasajeros
CREATE TABLE IF NOT EXISTS `pasajeros` (
  `id_pax` VARCHAR(7) NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `nro_documento` CHAR(18) NOT NULL,
  `telefono` CHAR(15),
  `id_tippax` VARCHAR(7) NOT NULL,
  `nacionalidad` VARCHAR(50) NOT NULL,
  `id_tipdoc` VARCHAR(7) NOT NULL,
  `apellidos` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_pax`),
  KEY `fk_pasajeros_tippax` (`id_tippax`),
  KEY `fk_pasajeros_tipdoc` (`id_tipdoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: pasajeroporreserva
CREATE TABLE IF NOT EXISTS `pasajeroporreserva` (
  `num_paxres` VARCHAR(7) NOT NULL,
  `id_pax` VARCHAR(7) NOT NULL,
  `id_reserva` VARCHAR(7) NOT NULL,
  `asiento` INT,
  `observaciones` TEXT,
  PRIMARY KEY (`num_paxres`),
  KEY `fk_paxres_pax` (`id_pax`),
  KEY `fk_paxres_reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: caja
CREATE TABLE IF NOT EXISTS `caja` (
  `id_caja` VARCHAR(7) NOT NULL,
  `fecha_apertura` DATE NOT NULL,
  `hora_apertura` DATETIME NOT NULL,
  `hora_cierre` DATETIME,
  `fondo_inicial` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `saldo_final` DECIMAL(10,2),
  `estado` ENUM('abierta','cerrada') NOT NULL DEFAULT 'abierta',
  `id_usuario` CHAR(18) NOT NULL,
  `observaciones` TEXT,
  PRIMARY KEY (`id_caja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: caja_movimiento
CREATE TABLE IF NOT EXISTS `caja_movimiento` (
  `id_movimiento` VARCHAR(7) NOT NULL,
  `id_caja` VARCHAR(7) NOT NULL,
  `hora` TIME NOT NULL,
  `concepto` VARCHAR(200) NOT NULL,
  `metodo_pago` VARCHAR(30) NOT NULL DEFAULT 'Efectivo',
  `tipo` ENUM('ingreso','egreso') NOT NULL,
  `monto` DECIMAL(10,2) NOT NULL,
  `saldo_acumulado` DECIMAL(10,2) NOT NULL,
  `id_reserva` VARCHAR(7),
  PRIMARY KEY (`id_movimiento`),
  KEY `fk_caja_movimiento_caja` (`id_caja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: Add foreign key constraints (enable if import order respects references)
ALTER TABLE `cliente` ADD CONSTRAINT `cliente_tipdoc_fk` FOREIGN KEY (`id_tipdoc`) REFERENCES `tipodocumento`(`id_tipdoc`);
ALTER TABLE `usuario` ADD CONSTRAINT `usuario_tiprol_fk` FOREIGN KEY (`id_tiprol`) REFERENCES `tiporol`(`id_tiprol`);
ALTER TABLE `usuario` ADD CONSTRAINT `usuario_tipdoc_fk` FOREIGN KEY (`id_tipdoc`) REFERENCES `tipodocumento`(`id_tipdoc`);
ALTER TABLE `tour` ADD CONSTRAINT `tour_destino_fk` FOREIGN KEY (`id_destino`) REFERENCES `destino`(`id_destino`);
ALTER TABLE `tour` ADD CONSTRAINT `tour_catto_fk` FOREIGN KEY (`id_catto`) REFERENCES `categoriatour`(`id_catto`);
ALTER TABLE `paquetes` ADD CONSTRAINT `paquetes_tippaq_fk` FOREIGN KEY (`id_tippaq`) REFERENCES `tipopaquete`(`id_tippaq`);
ALTER TABLE `detpaquetedestino` ADD CONSTRAINT `detpaquetedestino_paquete_fk` FOREIGN KEY (`id_paquete`) REFERENCES `paquetes`(`id_paquete`);
ALTER TABLE `detpaquetedestino` ADD CONSTRAINT `detpaquetedestino_destino_fk` FOREIGN KEY (`id_destino`) REFERENCES `destino`(`id_destino`);
ALTER TABLE `detallereservapaquete` ADD CONSTRAINT `detrespaq_paquete_fk` FOREIGN KEY (`id_paquete`) REFERENCES `paquetes`(`id_paquete`);
ALTER TABLE `detallereservapaquete` ADD CONSTRAINT `detrespaq_reserva_fk` FOREIGN KEY (`id_reserva`) REFERENCES `reserva`(`id_reserva`);
ALTER TABLE `reserva` ADD CONSTRAINT `reserva_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id_usuario`);
ALTER TABLE `reserva` ADD CONSTRAINT `reserva_cliente_fk` FOREIGN KEY (`id_cliente`) REFERENCES `cliente`(`id_cliente`);
ALTER TABLE `detallereservatour` ADD CONSTRAINT `detrestour_tour_fk` FOREIGN KEY (`id_tour`) REFERENCES `tour`(`id_tour`);
ALTER TABLE `detallereservatour` ADD CONSTRAINT `detrestour_reserva_fk` FOREIGN KEY (`id_reserva`) REFERENCES `reserva`(`id_reserva`);
ALTER TABLE `comprobantepago` ADD CONSTRAINT `comppago_reserva_fk` FOREIGN KEY (`id_reserva`) REFERENCES `reserva`(`id_reserva`);
ALTER TABLE `comprobantepago` ADD CONSTRAINT `comppago_metpago_fk` FOREIGN KEY (`id_metpago`) REFERENCES `metodopago`(`id_metpago`);
ALTER TABLE `comprobantepago` ADD CONSTRAINT `comppago_tipcom_fk` FOREIGN KEY (`id_tipcom`) REFERENCES `tipocomprobante`(`id_tipcom`);
ALTER TABLE `detallepago` ADD CONSTRAINT `detpago_compag_fk` FOREIGN KEY (`id_compag`) REFERENCES `comprobantepago`(`id_compag`);
ALTER TABLE `pasajeros` ADD CONSTRAINT `pasajeros_tippax_fk` FOREIGN KEY (`id_tippax`) REFERENCES `tipopasajero`(`id_tippax`);
ALTER TABLE `pasajeros` ADD CONSTRAINT `pasajeros_tipdoc_fk` FOREIGN KEY (`id_tipdoc`) REFERENCES `tipodocumento`(`id_tipdoc`);
ALTER TABLE `pasajeroporreserva` ADD CONSTRAINT `paxres_pax_fk` FOREIGN KEY (`id_pax`) REFERENCES `pasajeros`(`id_pax`);
ALTER TABLE `pasajeroporreserva` ADD CONSTRAINT `paxres_reserva_fk` FOREIGN KEY (`id_reserva`) REFERENCES `reserva`(`id_reserva`);
ALTER TABLE `caja_movimiento` ADD CONSTRAINT `caja_movimiento_caja_fk` FOREIGN KEY (`id_caja`) REFERENCES `caja`(`id_caja`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS=1;
