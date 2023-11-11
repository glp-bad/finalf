CREATE TABLE `badminto_finalf`.`t_factura_electronica` (
  `id` INT UNSIGNED NOT NULL,
  `id_factura` INT UNSIGNED NOT NULL,
  `e_factura` BLOB NOT NULL,
  `id_user` INT UNSIGNED NULL,
  `created` TIMESTAMP NULL,
  `updated` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
COMMENT = '		';

ALTER TABLE `badminto_finalf`.`t_factura_elctronica` ADD UNIQUE INDEX `uix_id_factura` (`id_factura` ASC) VISIBLE;

ALTER TABLE `badminto_finalf`.`t_factura_elctronica` 
ADD CONSTRAINT `uix_id_factura`
  FOREIGN KEY (`id_factura`)
  REFERENCES `badminto_finalf`.`t_factura` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `badminto_finalf`.`t_avocati` 
ADD COLUMN `contact_name` VARCHAR(45) NULL AFTER `platestetva`,
ADD COLUMN `contact_email` VARCHAR(100) NULL AFTER `contact_name`,
ADD COLUMN `contact_phone` VARCHAR(15) NULL AFTER `contact_email`;


ALTER TABLE `badminto_finalf`.`t_tip_factura` 
ADD COLUMN `e_invoice_type_code` VARCHAR(10) NULL AFTER `cTipfactura`;

update t_tip_factura set e_invoice_type_code = '380';

ALTER TABLE `badminto_finalf`.`t_factura_d` 
ADD COLUMN `quantity` DECIMAL(8,2) NOT NULL DEFAULT 1 AFTER `cText`;


ALTER TABLE `badminto_finalf`.`t_tip_um` 
ADD COLUMN `e_unit_code` VARCHAR(10) NULL AFTER `zecimale`;

update t_tip_um set e_unit_code = 'BB' where cTipabr = 'BUC';

ALTER TABLE `badminto_finalf`.`t_factura_d` 
ADD COLUMN `id_um` INT NOT NULL DEFAULT 1 AFTER `cText`;
ALTER TABLE `badminto_finalf`.`t_factura_d` ADD INDEX `id_um` (`id_um` ASC) VISIBLE;

ALTER TABLE `badminto_finalf`.`t_factura_d` 
CHANGE COLUMN `id_um` `id_um` INT UNSIGNED NOT NULL DEFAULT '1' ;

ALTER TABLE `badminto_finalf`.`t_factura_d` 
ADD CONSTRAINT `fk_t_factura_d_um`
  FOREIGN KEY (id_um)
  REFERENCES `badminto_finalf`.`t_tip_um` (id)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


  CREATE TABLE `badminto_finalf`.`e_categorie_tva` (
  `id` INT UNSIGNED NOT NULL,
  `code` VARCHAR(10) NULL,
  `descriere` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC) VISIBLE)
COMMENT = '			';

insert into e_categorie_tva (id, code, descriere) values (1,'S','Cota normala şi cota redusa a TVA');
insert into e_categorie_tva (id, code, descriere) values (2,'Z','TVA cota zero');
insert into e_categorie_tva (id, code, descriere) values (3,'E','Scutire de TVA');
insert into e_categorie_tva (id, code, descriere) values (4,'AE','TVA cu taxare inversa');
insert into e_categorie_tva (id, code, descriere) values (5,'K','TVA pentru livrări intracomunitare');
insert into e_categorie_tva (id, code, descriere) values (6,'G','TVA pentru exporturi');
insert into e_categorie_tva (id, code, descriere) values (7,'O','Nu face obiectul TVA');
insert into e_categorie_tva (id, code, descriere) values (8,'L','Taxele din Insulele Canare');
insert into e_categorie_tva (id, code, descriere) values (9,'M','Taxele din Ceuta şi Melilla');

ALTER TABLE `badminto_finalf`.`t_factura_d` 
ADD COLUMN `id_e_categorie_tva` INT UNSIGNED NOT NULL DEFAULT 1 AFTER `id_factura`;

ALTER TABLE `badminto_finalf`.`t_factura_d` 
ADD CONSTRAINT `fk_t_factura_d_e_categorie_tva`
  FOREIGN KEY (id_e_categorie_tva)
  REFERENCES `badminto_finalf`.`e_categorie_tva` (id)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



CREATE TABLE `badminto_finalf`.`e_tip_plata` (
  `id` INT UNSIGNED NOT NULL,
  `code` VARCHAR(10) NOT NULL,
  `descriere` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC) VISIBLE);

insert into e_tip_plata (id, code, descriere) value(1,'1', 'Instrument nedefinit');
insert into e_tip_plata (id, code, descriere) value(2,'2', 'Credit prin casa automată de compensare (ACH)');
insert into e_tip_plata (id, code, descriere) value(3,'3', 'Debit prin casa automată de compensare (ACH)');
insert into e_tip_plata (id, code, descriere) value(4,'4', 'Cerere pentru inversarea debitului transmis la casa automată de compensare (ACH)');
insert into e_tip_plata (id, code, descriere) value(5,'5', 'Cerere pentru inversarea creditului transmis la casa automată de compensare (ACH)');
insert into e_tip_plata (id, code, descriere) value(6,'6', 'Cerere de credit prin casa automată de compensare (ACH)');
insert into e_tip_plata (id, code, descriere) value(7,'7', 'Cerere de debit prin casa automată de compensare (ACH)');
insert into e_tip_plata (id, code, descriere) value(8,'8', 'Sumă reținută (Reținere)');
insert into e_tip_plata (id, code, descriere) value(9,'9', 'Compensare națională sau regională');
insert into e_tip_plata (id, code, descriere) value(10,'10','În numerar');
insert into e_tip_plata (id, code, descriere) value(11,'11','Inversarea creditului de economii transmis la ACH');
insert into e_tip_plata (id, code, descriere) value(12,'12','Inversarea debitului de economii transmis la ACH');
insert into e_tip_plata (id, code, descriere) value(13,'13','Credit de economii transmis către ACH');
insert into e_tip_plata (id, code, descriere) value(14,'14','Debit de economii transmis către ACH');
insert into e_tip_plata (id, code, descriere) value(15,'15','Înregistrare de credit');
insert into e_tip_plata (id, code, descriere) value(16,'16','Înregistrare de debit');
insert into e_tip_plata (id, code, descriere) value(17,'17','Creditul de concentrare/despăgubire (CCD) la cererea ACH');
insert into e_tip_plata (id, code, descriere) value(18,'18','Concentrarea/decontarea cererii de numerar ACH (CCD) debit');
insert into e_tip_plata (id, code, descriere) value(19,'19','ACH solicită credite pentru plata comerțului corporativ (CTP)');
insert into e_tip_plata (id, code, descriere) value(20,'20','Cec');
insert into e_tip_plata (id, code, descriere) value(21,'21','Bilet la ordin');
insert into e_tip_plata (id, code, descriere) value(22,'22','Bilet la ordin avalizat');
insert into e_tip_plata (id, code, descriere) value(23,'23','Cec bancar (emis de o bancă sau de o unitate similară)');
insert into e_tip_plata (id, code, descriere) value(24,'24','Scrisoare de schimb în așteptarea acceptării');
insert into e_tip_plata (id, code, descriere) value(25,'25','Cec certificat');
insert into e_tip_plata (id, code, descriere) value(26,'26','Cec local');
insert into e_tip_plata (id, code, descriere) value(27,'27','Solicitare la ACH pentru plata comerțului corporativ (CTP) debit');
insert into e_tip_plata (id, code, descriere) value(28,'28','Solicitare la ACH pentru credite de schimb comercial corporativ (CTX)');
insert into e_tip_plata (id, code, descriere) value(29,'29','Solicitare la ACH pentru debitarea schimburilor comerciale corporative (CTX)');
insert into e_tip_plata (id, code, descriere) value(30,'30','Transfer de credit');
insert into e_tip_plata (id, code, descriere) value(31,'31','Transfer de debit');
insert into e_tip_plata (id, code, descriere) value(32,'32','Concentrarea/plata cererii de numerar ACH plus (CCD+)');
insert into e_tip_plata (id, code, descriere) value(33,'33','Concentrarea/plata cererii de numerar ACH plus (CCD+)');
insert into e_tip_plata (id, code, descriere) value(34,'34','Plăți și depozit prestabilite ACH (PPD)');
insert into e_tip_plata (id, code, descriere) value(35,'35','Creditul de concentrare/despăgubire a economiilor ACH (CCD)');
insert into e_tip_plata (id, code, descriere) value(36,'36','Concentrarea/decontarea (CCD) a economiilor ACH');
insert into e_tip_plata (id, code, descriere) value(37,'37','Credit ACH pentru plata comerțului cu societăți de economii (CTP)');
insert into e_tip_plata (id, code, descriere) value(38,'38','Debit ACH pentru economii plăți comerciale corporative (CTP)');
insert into e_tip_plata (id, code, descriere) value(39,'39','Credit ACH de schimb comercial cu societăți de economii (CTX)');
insert into e_tip_plata (id, code, descriere) value(40,'40','Debit ACH de schimb cu societăți de economii (CTX)');
insert into e_tip_plata (id, code, descriere) value(41,'41','Concentrarea/plata în numerar a sumelor din economii prin ACH plus (CCD+)');
insert into e_tip_plata (id, code, descriere) value(42,'42','Plata în contul bancar');
insert into e_tip_plata (id, code, descriere) value(43,'43','Concentrarea/plata în numerar a economiilor înregistrate în ACH plus (CCD+)');
insert into e_tip_plata (id, code, descriere) value(44,'44','Scrisoare de schimb (Cambie) acceptată');
insert into e_tip_plata (id, code, descriere) value(45,'45','Transfer de credit prin facilitatea de Home Banking');
insert into e_tip_plata (id, code, descriere) value(46,'46','Transfer interbancar de debit');
insert into e_tip_plata (id, code, descriere) value(47,'47','Transfer de debit prin facilitatea de Home Banking');
insert into e_tip_plata (id, code, descriere) value(48,'48','Card bancar');
insert into e_tip_plata (id, code, descriere) value(49,'49','Debitare directă');
insert into e_tip_plata (id, code, descriere) value(50,'50','Plata prin Postgiro');
insert into e_tip_plata (id, code, descriere) value(51,'51','Plată prin compensare la distanță conform norma 6 97 CFONB (Organizația franceză pentru standarde bancare)');
insert into e_tip_plata (id, code, descriere) value(52,'52','Plată comercială rapidă');
insert into e_tip_plata (id, code, descriere) value(53,'53','Plată rapidă din Trezorerie');
insert into e_tip_plata (id, code, descriere) value(54,'54','Card de credit');
insert into e_tip_plata (id, code, descriere) value(55,'55','Card de debit');
insert into e_tip_plata (id, code, descriere) value(56,'56','BankGiro');
insert into e_tip_plata (id, code, descriere) value(57,'57','Acord permanent');
insert into e_tip_plata (id, code, descriere) value(58,'58','Transferul de credit SEPA');
insert into e_tip_plata (id, code, descriere) value(59,'59','Debitare directă SEPA');
insert into e_tip_plata (id, code, descriere) value(60,'60','Bilet la ordin');
insert into e_tip_plata (id, code, descriere) value(61,'61','Bilet la ordin semnat de debitor');
insert into e_tip_plata (id, code, descriere) value(62,'62','Bilet la ordin semnat de debitor și aprobat de o bancă');
insert into e_tip_plata (id, code, descriere) value(63,'63','Bilet la ordin semnat de debitor și aprobat de o terță parte');
insert into e_tip_plata (id, code, descriere) value(64,'64','Bilet la ordin semnat de o bancă');
insert into e_tip_plata (id, code, descriere) value(65,'65','Bilet la ordin semnat de o bancă și aprobat de o altă bancă');
insert into e_tip_plata (id, code, descriere) value(66,'66','Bilet la ordin semnat de un terț');
insert into e_tip_plata (id, code, descriere) value(67,'67','Bilet la ordin semnat de un terț și aprobat de o bancă');
insert into e_tip_plata (id, code, descriere) value(68,'68','Serviciul de plată online');
insert into e_tip_plata (id, code, descriere) value(69,'69','Consiliere de transfer');
insert into e_tip_plata (id, code, descriere) value(70,'70','Scrisoare de schimb întocmită de creditor cu privire la debitor');
insert into e_tip_plata (id, code, descriere) value(71,'74','Scrisoare de schimb întocmită de creditor pentru o bancă');
insert into e_tip_plata (id, code, descriere) value(72,'75','Scrisoare de schimb elaborată de creditor, aprobată de o altă bancă');
insert into e_tip_plata (id, code, descriere) value(73,'76','Scrisoare de schimb elaborată de creditor pentru o bancă și aprobat de o terță parte');
insert into e_tip_plata (id, code, descriere) value(74,'77','Scrisoare de schimb întocmită de creditor pentru o terță parte');
insert into e_tip_plata (id, code, descriere) value(75,'78','Scrisoare de schimb întocmită de creditor pentru o terță parte, acceptat și aprobată de o bancă');
insert into e_tip_plata (id, code, descriere) value(76,'91','Bilet la ordin netransferabil');
insert into e_tip_plata (id, code, descriere) value(77,'92','Cec local netransferabil');
insert into e_tip_plata (id, code, descriere) value(78,'93','Referința Giro');
insert into e_tip_plata (id, code, descriere) value(79,'94','Giro rapid');
insert into e_tip_plata (id, code, descriere) value(81,'95','Giro format liber - care nu este prestabilit');
insert into e_tip_plata (id, code, descriere) value(82,'96','Metoda solicitată de plată nu a fost utilizată');
insert into e_tip_plata (id, code, descriere) value(83,'97','Compensarea între parteneri');
insert into e_tip_plata (id, code, descriere) value(84,'ZZZ','Definit de comun acord');



ALTER TABLE `badminto_finalf`.`t_factura` 
ADD COLUMN `id_e_tip_plata` INT UNSIGNED NOT NULL DEFAULT 1 AFTER `id_tipfactura`,
ADD COLUMN `t_facturacol` VARCHAR(45) NULL AFTER `id_avocat`;


ALTER TABLE `badminto_finalf`.`t_factura` 
ADD CONSTRAINT `fk_t_factura_e_tip_plata`
  FOREIGN KEY (id_e_tip_plata)
  REFERENCES `badminto_finalf`.`e_tip_plata` (id)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;