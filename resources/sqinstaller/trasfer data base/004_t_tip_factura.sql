CREATE TABLE badminto_finalf.t_tip_factura LIKE avban.t_tip_factura;
ALTER TABLE badminto_finalf.t_tip_factura CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_tip_factura SELECT * from avban.t_tip_factura;
ALTER TABLE `badminto_finalf`.`t_tip_factura` CHANGE COLUMN `id_tipfactura` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_tip_factura`
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;
