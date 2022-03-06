CREATE TABLE badminto_finalf.t_avocati_adresa LIKE avban.t_avocati_adresa;
ALTER TABLE badminto_finalf.t_avocati_adresa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_avocati_adresa SELECT * from avban.t_avocati_adresa;
ALTER TABLE badminto_finalf.t_avocati_adresa CHANGE COLUMN id_adr id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_avocati_adresa
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE badminto_finalf.t_avocati_adresa CHANGE COLUMN data_o created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE badminto_finalf.t_avocati_adresa ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update badminto_finalf.t_avocati_adresa set cUser = 3;
ALTER TABLE badminto_finalf.t_avocati_adresa CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
