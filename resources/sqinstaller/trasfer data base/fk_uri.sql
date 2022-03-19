ALTER TABLE badminto_finalf.t_parteneri ADD FOREIGN KEY (id_avocat) REFERENCES badminto_finalf.t_avocati(id);
ALTER TABLE badminto_finalf.t_parteneri ADD FOREIGN KEY (id_tip) REFERENCES badminto_finalf.t_tip_organizare_juridica(id);
ALTER TABLE badminto_finalf.t_parteneri ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);

ALTER TABLE badminto_finalf.t_factura ADD FOREIGN KEY (id_avocat) REFERENCES badminto_finalf.t_avocati(id);
ALTER TABLE badminto_finalf.t_factura ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);
ALTER TABLE badminto_finalf.t_factura ADD FOREIGN KEY (id_nr) REFERENCES badminto_finalf.t_facturi_numar(id);
ALTER TABLE badminto_finalf.t_factura ADD FOREIGN KEY (id_tipfactura) REFERENCES badminto_finalf.t_tip_factura(id);

ALTER TABLE badminto_finalf.t_factura_d ADD FOREIGN KEY (id_factura) REFERENCES badminto_finalf.t_factura(id);
ALTER TABLE badminto_finalf.t_factura_d ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);

ALTER TABLE badminto_finalf.t_parteneri_adrese ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);
ALTER TABLE badminto_finalf.t_parteneri_adrese ADD FOREIGN KEY (id_part) REFERENCES badminto_finalf.t_parteneri(id);
ALTER TABLE badminto_finalf.t_parteneri_adrese ADD FOREIGN KEY (id_localitate) REFERENCES badminto_finalf.t_localitati(id);

ALTER TABLE badminto_finalf.t_parteneri_banca ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);
ALTER TABLE badminto_finalf.t_parteneri_banca ADD FOREIGN KEY (id_part) REFERENCES badminto_finalf.t_parteneri(id);

ALTER TABLE badminto_finalf.t_incasari_facturi ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);
ALTER TABLE badminto_finalf.t_incasari_facturi ADD FOREIGN KEY (id_factura) REFERENCES badminto_finalf.t_factura(id);
ALTER TABLE badminto_finalf.t_incasari_facturi ADD FOREIGN KEY (id_nr) REFERENCES badminto_finalf.t_facturi_numar(id);
ALTER TABLE badminto_finalf.t_incasari_facturi ADD FOREIGN KEY (id_tipd) REFERENCES badminto_finalf.t_tip_document(id);
ALTER TABLE badminto_finalf.t_incasari_facturi ADD FOREIGN KEY (id_incas) REFERENCES badminto_finalf.t_tip_incasare(id);

ALTER TABLE badminto_finalf.t_s_luni_inchise ADD FOREIGN KEY (id_avocat) REFERENCES badminto_finalf.t_avocati(id);
ALTER TABLE badminto_finalf.t_s_luni_inchise ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);

ALTER TABLE badminto_finalf.t_avocati_adresa ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);
ALTER TABLE badminto_finalf.t_avocati_adresa ADD FOREIGN KEY (id_avocat) REFERENCES badminto_finalf.t_avocati(id);
ALTER TABLE badminto_finalf.t_avocati_adresa ADD FOREIGN KEY (id_localitate) REFERENCES badminto_finalf.t_localitati(id);

ALTER TABLE badminto_finalf.t_avocati_banca ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);
ALTER TABLE badminto_finalf.t_avocati_banca ADD FOREIGN KEY (id_avocat) REFERENCES badminto_finalf.t_avocati(id);

ALTER TABLE badminto_finalf.t_cheltuieli ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);
ALTER TABLE badminto_finalf.t_cheltuieli ADD FOREIGN KEY (id_avocat) REFERENCES badminto_finalf.t_avocati(id);
ALTER TABLE badminto_finalf.t_cheltuieli ADD FOREIGN KEY (id_part) REFERENCES badminto_finalf.t_parteneri(id);
ALTER TABLE badminto_finalf.t_cheltuieli ADD FOREIGN KEY (id_tipc) REFERENCES badminto_finalf.t_tip_cheltuieli(id);
ALTER TABLE badminto_finalf.t_cheltuieli ADD FOREIGN KEY (id_tipd) REFERENCES badminto_finalf.t_tip_document(id);
ALTER TABLE badminto_finalf.t_cheltuieli ADD FOREIGN KEY (id_tipplata) REFERENCES badminto_finalf.t_tip_plata(id);

ALTER TABLE badminto_finalf.t_cheltuieli_d ADD FOREIGN KEY (id_user) REFERENCES badminto_finalf.users(id);
ALTER TABLE badminto_finalf.t_cheltuieli_d ADD FOREIGN KEY (id_chlet) REFERENCES badminto_finalf.t_cheltuieli(id);
ALTER TABLE badminto_finalf.t_cheltuieli_d ADD FOREIGN KEY (id_prod) REFERENCES badminto_finalf.t_produse(id);
ALTER TABLE badminto_finalf.t_cheltuieli_d ADD FOREIGN KEY (id_tipm) REFERENCES badminto_finalf.t_tip_um(id);
ALTER TABLE badminto_finalf.t_cheltuieli_d ADD FOREIGN KEY (id_tipcat) REFERENCES badminto_finalf.t_tip_cheltuieli_categorii(id);
