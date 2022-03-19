CREATE TABLE badminto_finalf.t_factura LIKE avban.t_factura;
ALTER TABLE badminto_finalf.t_factura CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_factura SELECT * from avban.t_factura;
ALTER TABLE `badminto_finalf`.`t_factura` CHANGE COLUMN `id_factura` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_factura`
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE `badminto_finalf`.`t_factura` CHANGE COLUMN `data_o` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `badminto_finalf`.`t_factura` ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update `badminto_finalf`.`t_factura` set cUser = 3;
ALTER TABLE `badminto_finalf`.`t_factura` CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
ALTER TABLE `badminto_finalf`.`t_factura` CHANGE COLUMN `data_f` `data_f` DATE NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_factura` CHANGE COLUMN `id_avocat` `id_avocat` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_factura` CHANGE COLUMN `id_nr` `id_nr` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_factura` CHANGE COLUMN `id_tipfactura` `id_tipfactura` INT UNSIGNED NOT NULL;
update t_factura set id_avocat = 6 where id_avocat = 0;
