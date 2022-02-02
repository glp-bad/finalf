CREATE TABLE badminto_finalf.t_localitati_tip LIKE avban.t_localitati_tip;
ALTER TABLE badminto_finalf.t_localitati_tip CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_localitati_tip SELECT * from avban.t_localitati_tip;
ALTER TABLE `badminto_finalf`.`t_localitati_tip` CHANGE COLUMN `id_tip` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_localitati_tip`
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;



CREATE TABLE badminto_finalf.t_judete LIKE avban.t_judete;
ALTER TABLE badminto_finalf.t_judete CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_judete SELECT * from avban.t_judete;
ALTER TABLE `badminto_finalf`.`t_judete` CHANGE COLUMN `id_judet` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_judete`
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE `badminto_finalf`.`t_judete` CHANGE COLUMN `data_o` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `badminto_finalf`.`t_judete` ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update `badminto_finalf`.`t_judete` set cUser = 3;
ALTER TABLE `badminto_finalf`.`t_judete` CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;




CREATE TABLE badminto_finalf.t_localitati LIKE avban.t_localitati;
ALTER TABLE badminto_finalf.t_localitati CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_localitati SELECT * from avban.t_localitati;
ALTER TABLE `badminto_finalf`.`t_localitati` CHANGE COLUMN `id_localitate` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_localitati`
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE `badminto_finalf`.`t_localitati` CHANGE COLUMN `data_o` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `badminto_finalf`.`t_localitati` ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update `badminto_finalf`.`t_localitati` set cUser = 3;
ALTER TABLE `badminto_finalf`.`t_localitati` CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
