CREATE TABLE badminto_finalf.t_tip_organizare_juridica LIKE avban.t_tip_organizare_juridica;
ALTER TABLE badminto_finalf.t_tip_organizare_juridica CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_tip_organizare_juridica SELECT * from avban.t_tip_organizare_juridica;
ALTER TABLE `badminto_finalf`.`t_tip_organizare_juridica` CHANGE COLUMN `id_tip` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_tip_organizare_juridica` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;