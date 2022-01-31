CREATE TABLE badminto_finalf.t_avocati LIKE avban.t_avocati;
ALTER TABLE badminto_finalf.t_avocati CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
INSERT INTO badminto_finalf.t_avocati SELECT * from avban.t_avocati;
ALTER TABLE `badminto_finalf`.`t_avocati` CHANGE COLUMN `id_avocat` `id` INT UNSIGNED NOT NULL ;
ALTER TABLE `badminto_finalf`.`t_avocati` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
ADD UNIQUE INDEX `uix_id` (`id` ASC) VISIBLE;


