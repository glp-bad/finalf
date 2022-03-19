CREATE TABLE badminto_finalf.t_parteneri_adrese LIKE avban.t_parteneri_adrese;
ALTER TABLE badminto_finalf.t_parteneri_adrese CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_parteneri_adrese SELECT * from avban.t_parteneri_adrese;
ALTER TABLE `badminto_finalf`.`t_parteneri_adrese` CHANGE COLUMN `id_pa` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_parteneri_adrese`
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE `badminto_finalf`.`t_parteneri_adrese` CHANGE COLUMN `data_o` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `badminto_finalf`.`t_parteneri_adrese` ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update `badminto_finalf`.`t_parteneri_adrese` set cUser = 3;
ALTER TABLE `badminto_finalf`.`t_parteneri_adrese` CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
ALTER TABLE `badminto_finalf`.`t_parteneri_adrese` CHANGE COLUMN `id_part` `id_part` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_parteneri_adrese` CHANGE COLUMN `id_localitate` `id_localitate` INT UNSIGNED NOT NULL;
