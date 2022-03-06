CREATE TABLE badminto_finalf.t_cheltuieli LIKE avban.t_cheltuieli;
ALTER TABLE badminto_finalf.t_cheltuieli CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_cheltuieli SELECT * from avban.t_cheltuieli;
ALTER TABLE badminto_finalf.t_cheltuieli CHANGE COLUMN id_chlet id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_cheltuieli
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE badminto_finalf.t_cheltuieli CHANGE COLUMN data_o created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE badminto_finalf.t_cheltuieli ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update badminto_finalf.t_cheltuieli set cUser = 3;
ALTER TABLE badminto_finalf.t_cheltuieli CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
