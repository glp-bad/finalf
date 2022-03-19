CREATE TABLE badminto_finalf.t_incasari_facturi LIKE avban.t_incasari_facturi;
ALTER TABLE badminto_finalf.t_incasari_facturi CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_incasari_facturi SELECT * from avban.t_incasari_facturi;
ALTER TABLE badminto_finalf.t_incasari_facturi CHANGE COLUMN id_incasf id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_incasari_facturi
    CHANGE COLUMN id id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX uix_id (id ASC) VISIBLE;
ALTER TABLE badminto_finalf.t_incasari_facturi CHANGE COLUMN data_o created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE badminto_finalf.t_incasari_facturi ADD COLUMN last_update TIMESTAMP NULL AFTER created;
update badminto_finalf.t_incasari_facturi set cUser = 3;
ALTER TABLE badminto_finalf.t_incasari_facturi CHANGE COLUMN cUser id_user INT UNSIGNED NULL ;

ALTER TABLE `badminto_finalf`.`t_incasari_facturi` CHANGE COLUMN `id_factura` `id_factura` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_incasari_facturi` CHANGE COLUMN `id_nr` `id_nr` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_incasari_facturi` CHANGE COLUMN `id_tipd` `id_tipd` INT UNSIGNED NOT NULL;
ALTER TABLE `badminto_finalf`.`t_incasari_facturi` CHANGE COLUMN `id_incas` `id_incas` INT UNSIGNED NOT NULL;
