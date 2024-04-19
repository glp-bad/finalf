ALTER TABLE `t_factura_electronica` 
ADD COLUMN `cif` VARCHAR(15) NOT NULL AFTER `id_factura`;


CREATE TABLE `anaf_send_factura` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_factura` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_factura_UNIQUE` (`id_factura`)
);



insert into anaf_url (aplicatie, mediu, action, url) values('efactura', 'prod','listaMesajeFactura','https://api.anaf.ro/prod/FCTEL/rest/listaMesajeFactura');


CREATE TABLE `anaf_lista_mesaje` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_avocat` int unsigned NOT NULL,
  `anaf_id` varchar(15) NOT NULL,
  `anaf_cif` varchar(15) NOT NULL,
  `anaf_id_solicitare` varchar(15) NOT NULL COMMENT 'este id_incarare',
  `anaf_detalii` varchar(200) NOT NULL,
  `anaf_tip` varchar(30) NOT NULL,
  `anaf_data_creare` varchar(15) NOT NULL,
  `anaf_serial` varchar(36) NOT NULL,
  `anaf_data_creare_data` datetime NOT NULL,
  `emitent_cif` varchar(15) DEFAULT NULL,
  `emitent` varchar(100) DEFAULT NULL,
  `created_system` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uix_anaf_id` (`anaf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='datele din lista trimisa de anaf';



CREATE TABLE `anaf_lista_mesaje_buffer` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_avocat` int unsigned NOT NULL,
  `anaf_id` varchar(15) NOT NULL,
  `anaf_cif` varchar(15) NOT NULL,
  `anaf_id_solicitare` varchar(15) NOT NULL COMMENT 'este id_incarare',
  `anaf_detalii` varchar(200) NOT NULL,
  `anaf_tip` varchar(30) NOT NULL,
  `anaf_data_creare` varchar(15) NOT NULL,
  `anaf_serial` varchar(36) NOT NULL,
  `anaf_data_creare_data` datetime NOT NULL,
  `emitent_cif` varchar(15) DEFAULT NULL,
  `emitent` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uix_anaf_id` (`anaf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='datele din aceasta tabela se sterg dupa ce sunt inserate in anaf_lista_mesaje';


CREATE TABLE `anaf_send_factura_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_factura` INT NULL,
  `nr_factura` VARCHAR(45) NULL,
  `anaf_xml_response` BLOB NULL,
  `inserted_system` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`));
