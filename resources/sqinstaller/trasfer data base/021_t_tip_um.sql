CREATE TABLE badminto_finalf.t_tip_um LIKE avban.t_tip_um;
ALTER TABLE badminto_finalf.t_tip_um CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_tip_um SELECT * from avban.t_tip_um;
ALTER TABLE badminto_finalf.t_tip_um CHANGE COLUMN id_tipm id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_tip_um
    CHANGE COLUMN id id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX uix_id (id ASC) VISIBLE;
