CREATE TABLE badminto_finalf.t_parteneri LIKE avban.t_parteneri;
ALTER TABLE badminto_finalf.t_parteneri CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_parteneri SELECT * from avban.t_parteneri;
ALTER TABLE `badminto_finalf`.`t_parteneri` CHANGE COLUMN `id_part` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_parteneri` CHANGE COLUMN `id_avocat` `id_avocat` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_parteneri` CHANGE COLUMN `id_tip` `id_tip` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_parteneri`
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;

ALTER TABLE `badminto_finalf`.`t_parteneri` CHANGE COLUMN `data_o` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `badminto_finalf`.`t_parteneri` ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;

update `badminto_finalf`.`t_parteneri` set cUser = 3;
ALTER TABLE `badminto_finalf`.`t_parteneri` CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;

