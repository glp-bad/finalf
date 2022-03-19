CREATE TABLE badminto_finalf.t_facturi_numar LIKE avban.t_facturi_numar;
ALTER TABLE badminto_finalf.t_facturi_numar CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_facturi_numar SELECT * from avban.t_facturi_numar;
ALTER TABLE `badminto_finalf`.`t_facturi_numar` CHANGE COLUMN `id_nr` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_facturi_numar`
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;

ALTER TABLE `badminto_finalf`.`t_facturi_numar` CHANGE COLUMN `id_avocat` `id_avocat` INT UNSIGNED NOT NULL;

ALTER TABLE `badminto_finalf`.`t_facturi_numar` CHANGE COLUMN `data_o` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `badminto_finalf`.`t_facturi_numar` ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update `badminto_finalf`.`t_facturi_numar` set cUser = 3;
ALTER TABLE `badminto_finalf`.`t_facturi_numar` CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
