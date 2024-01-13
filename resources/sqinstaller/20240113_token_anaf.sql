CREATE TABLE `anaf_token` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_avocat` int unsigned NOT NULL,
  `client_id` varchar(245) DEFAULT NULL,
  `client_secret` varchar(245) DEFAULT NULL,
  `refresh_token` varchar(245) DEFAULT NULL,
  `acces_token` varchar(245) DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index2` (`id_avocat`),
  CONSTRAINT `fk_id_avocat` FOREIGN KEY (`id_avocat`) REFERENCES `t_avocati` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='		';



CREATE TABLE `anaf_url` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `aplicatie` VARCHAR(50) NOT NULL,
  `mediu` VARCHAR(50) NOT NULL,
  `action` VARCHAR(100) NOT NULL,
  `url` VARCHAR(500) NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `uix` (`aplicatie` ASC, `mediu` ASC, `action` ASC) VISIBLE);

insert into anaf_url (aplicatie, mediu, action, url) values('token','prod','authorize', 'https://logincert.anaf.ro/anaf-oauth2/v1/authorize');
insert into anaf_url (aplicatie, mediu, action, url) values('token','prod','token', 'https://logincert.anaf.ro/anaf-oauth2/v1/token');
insert into anaf_url (aplicatie, mediu, action, url) values('token','prod','revoke', 'https://logincert.anaf.ro/anaf-oauth2/v1/revoke');

insert into anaf_url (aplicatie, mediu, action, url) values('efactura','test','listaMesajeFactura', 'https://api.anaf.ro/test/FCTEL/rest/listaMesajeFactura');
insert into anaf_url (aplicatie, mediu, action, url) values('efactura','test','stareMesaj', 'https://api.anaf.ro/test/FCTEL/rest/stareMesaj');
insert into anaf_url (aplicatie, mediu, action, url) values('efactura','test','upload', 'https://api.anaf.ro/test/FCTEL/rest/upload');



--- mediul de lucru cu eFactura si ANAF
insert into e_parameter (id_avocat, parameter, value, description) value(6, 'ANAF_EFACTURA_RUNTIME', 'test', 'mediul pentru legatura cu ANAF si eFactura');
insert into e_parameter (id_avocat, parameter, value, description) value(6, 'ANAF_EXPIRE_TOKEN', 90, 'timpul de valabilitate al tokenului de acces in zile');

--- anaf token
insert into anaf_token (id_avocat) values(6)