CREATE TABLE badminto_finalf.t_factura_d LIKE avban.t_factura_d;
ALTER TABLE badminto_finalf.t_factura_d CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_factura_d SELECT * from avban.t_factura_d;
ALTER TABLE `badminto_finalf`.`t_factura_d` CHANGE COLUMN `id_facturad` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_factura_d`
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE `badminto_finalf`.`t_factura_d` CHANGE COLUMN `data_o` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `badminto_finalf`.`t_factura_d` ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update `badminto_finalf`.`t_factura_d` set cUser = 3;
ALTER TABLE `badminto_finalf`.`t_factura_d` CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
ALTER TABLE `badminto_finalf`.`t_factura_d` CHANGE COLUMN `id_factura` `id_factura` INT UNSIGNED NOT NULL;
