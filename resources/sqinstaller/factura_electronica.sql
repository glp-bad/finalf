CREATE TABLE `badminto_finalf`.`t_factura_electronica` (
  `id` INT UNSIGNED NOT NULL,
  `id_factura` INT UNSIGNED NOT NULL,
  `e_factura` BLOB NOT NULL,
  `id_user` INT UNSIGNED NULL,
  `created` TIMESTAMP NULL,
  `updated` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
COMMENT = '		';

ALTER TABLE `badminto_finalf`.`t_factura_elctronica` ADD UNIQUE INDEX `uix_id_factura` (`id_factura` ASC) VISIBLE;

ALTER TABLE `badminto_finalf`.`t_factura_elctronica` 
ADD CONSTRAINT `uix_id_factura`
  FOREIGN KEY (`id_factura`)
  REFERENCES `badminto_finalf`.`t_factura` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `badminto_finalf`.`t_avocati` 
ADD COLUMN `contact_name` VARCHAR(45) NULL AFTER `platestetva`,
ADD COLUMN `contact_email` VARCHAR(100) NULL AFTER `contact_name`,
ADD COLUMN `contact_phone` VARCHAR(15) NULL AFTER `contact_email`;