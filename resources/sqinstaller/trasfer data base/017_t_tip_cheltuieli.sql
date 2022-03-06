CREATE TABLE badminto_finalf.t_tip_cheltuieli LIKE avban.t_tip_cheltuieli;
ALTER TABLE badminto_finalf.t_tip_cheltuieli CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_tip_cheltuieli SELECT * from avban.t_tip_cheltuieli;
ALTER TABLE badminto_finalf.t_tip_cheltuieli CHANGE COLUMN id_tipc id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_tip_cheltuieli
    CHANGE COLUMN id id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX uix_id (id ASC) VISIBLE;
