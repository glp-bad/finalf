CREATE TABLE badminto_finalf.t_produse LIKE avban.t_produse;
ALTER TABLE badminto_finalf.t_produse CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_produse SELECT * from avban.t_produse;
ALTER TABLE badminto_finalf.t_produse CHANGE COLUMN id_prod id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_produse
    CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
ALTER TABLE badminto_finalf.t_produse CHANGE COLUMN data_o created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE badminto_finalf.t_produse ADD COLUMN `last_update` TIMESTAMP NULL AFTER `created` ;
update badminto_finalf.t_produse set cUser = 3;
ALTER TABLE badminto_finalf.t_produse CHANGE COLUMN `cUser` `id_user` INT UNSIGNED NULL ;
