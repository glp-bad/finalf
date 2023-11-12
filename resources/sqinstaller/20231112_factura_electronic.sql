CREATE TABLE `e_parameter` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_avocat` INT UNSIGNED NOT NULL,
  `parameter` VARCHAR(100) NOT NULL,
  `value` VARCHAR(100) NULL,
  `description` VARCHAR(300) NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `e_parameter` ADD UNIQUE INDEX `uix_param` (`id_avocat`, `parameter` ASC);

ALTER TABLE `e_parameter` 
ADD CONSTRAINT `fk_e_parameter_id_avocat`
  FOREIGN KEY (id_avocat)
  REFERENCES `t_avocati` (id)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

insert into e_parameter (id_avocat, parameter, value, description) values(6,'dueDate','15',' nr zile de la data emiterii facturii pana la scadenta');  
insert into e_parameter (id_avocat, parameter, value, description) values(6,'taxSchemeId','VAT','din documentatie');
insert into e_parameter (id_avocat, parameter, value, description) values(6,'sector 1','SECTOR1','din documentatie');
insert into e_parameter (id_avocat, parameter, value, description) values(6,'sector 2','SECTOR1','din documentatie');
insert into e_parameter (id_avocat, parameter, value, description) values(6,'sector 3','SECTOR1','din documentatie');
insert into e_parameter (id_avocat, parameter, value, description) values(6,'sector 4','SECTOR1','din documentatie');
insert into e_parameter (id_avocat, parameter, value, description) values(6,'sector 5','SECTOR1','din documentatie');
insert into e_parameter (id_avocat, parameter, value, description) values(6,'sector 6','SECTOR1','din documentatie');
insert into e_parameter (id_avocat, parameter, value, description) values(6,'currencyRON','RON','din documentatie');
insert into e_parameter (id_avocat, parameter, value, description) values(6,'countryCode','RO','din documentatie');


ALTER TABLE `t_factura` ADD COLUMN `e_due_date` DATE NULL AFTER `data_f`;