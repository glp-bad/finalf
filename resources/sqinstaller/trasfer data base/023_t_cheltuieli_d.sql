CREATE TABLE badminto_finalf.t_cheltuieli_d LIKE avban.t_cheltuieli_d;
ALTER TABLE badminto_finalf.t_cheltuieli_d CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_cheltuieli_d SELECT * from avban.t_cheltuieli_d;
ALTER TABLE badminto_finalf.t_cheltuieli_d CHANGE COLUMN id_cheltd id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_cheltuieli_d
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE badminto_finalf.t_cheltuieli_d CHANGE COLUMN data_o created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE badminto_finalf.t_cheltuieli_d ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update badminto_finalf.t_cheltuieli_d set cUser = 3;
ALTER TABLE badminto_finalf.t_cheltuieli_d CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
ALTER TABLE `badminto_finalf`.`t_cheltuieli_d` CHANGE COLUMN `id_chlet` `id_chlet` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_cheltuieli_d` CHANGE COLUMN `id_prod` `id_prod` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_cheltuieli_d` CHANGE COLUMN `id_tipm` `id_tipm` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_cheltuieli_d` CHANGE COLUMN `id_tipcat` `id_tipcat` INT UNSIGNED NOT NULL;
