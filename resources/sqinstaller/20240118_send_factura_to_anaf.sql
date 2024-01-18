ALTER TABLE `t_factura_electronica` 
ADD COLUMN `cif` VARCHAR(15) NOT NULL AFTER `id_factura`;


CREATE TABLE `anaf_send_factura` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_factura` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_factura_UNIQUE` (`id_factura`)
);