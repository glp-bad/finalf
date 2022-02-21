CREATE TABLE badminto_finalf.t_tip_document LIKE avban.t_tip_document;
ALTER TABLE badminto_finalf.t_tip_document CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_tip_document SELECT * from avban.t_tip_document;
ALTER TABLE badminto_finalf.t_tip_document CHANGE COLUMN id_tipd id INT UNSIGNED NOT NULL ;
ALTER TABLE badminto_finalf.t_tip_document
    CHANGE COLUMN id id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    ADD UNIQUE INDEX uix_id (id ASC) VISIBLE;
