CREATE TABLE badminto_finalf.t_s_luni_inchise LIKE avban.t_s_luni_inchise;
ALTER TABLE badminto_finalf.t_s_luni_inchise CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_s_luni_inchise SELECT * from avban.t_s_luni_inchise;
ALTER TABLE badminto_finalf.t_s_luni_inchise CHANGE COLUMN id_luna id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_s_luni_inchise
    CHANGE COLUMN id id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX uix_id (id ASC) VISIBLE;
ALTER TABLE badminto_finalf.t_s_luni_inchise ADD COLUMN created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE badminto_finalf.t_s_luni_inchise ADD COLUMN last_update TIMESTAMP NULL AFTER created;
ALTER TABLE badminto_finalf.t_s_luni_inchise ADD COLUMN id_user INT UNSIGNED NULL;
update badminto_finalf.t_s_luni_inchise set id_user = 3;
ALTER TABLE badminto_finalf.t_s_luni_inchise CHANGE COLUMN id_user id_user INT UNSIGNED NULL ;
ALTER TABLE `badminto_finalf`.`t_s_luni_inchise` CHANGE COLUMN `id_avocat` `id_avocat` INT UNSIGNED NOT NULL;
