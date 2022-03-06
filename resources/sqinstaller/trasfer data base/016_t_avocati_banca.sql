CREATE TABLE badminto_finalf.t_avocati_banca LIKE avban.t_avocati_banca;
ALTER TABLE badminto_finalf.t_avocati_banca CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_avocati_banca SELECT * from avban.t_avocati_banca;
ALTER TABLE badminto_finalf.t_avocati_banca CHANGE COLUMN id_avba id INT UNSIGNED NOT NULL ;

ALTER TABLE badminto_finalf.t_avocati_banca
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;

ALTER TABLE badminto_finalf.t_avocati_banca CHANGE COLUMN data_o created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE badminto_finalf.t_avocati_banca ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update badminto_finalf.t_avocati_banca set cUser = 3;
ALTER TABLE badminto_finalf.t_avocati_banca CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;

