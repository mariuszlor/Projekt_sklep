GRANT EXECUTE ON *.* TO 'interfejs'@'localhost' IDENTIFIED BY PASSWORD '*35A0B0F1B8BF3102F473C1F1E6635608AA2DFFFC';

GRANT SELECT, INSERT (adres_wysylki, klient_id), UPDATE (adres_wysylki) ON `projekt_bazy_sklep`.`transakcja` TO 'interfejs'@'localhost';

GRANT SELECT ON `projekt_bazy_sklep`.`pracownik` TO 'interfejs'@'localhost';

GRANT SELECT, INSERT (nazwa_firmy, typ, login, imie, haslo, nazwisko, NIP, dom_adr_wys), UPDATE (nazwa_firmy, imie, haslo, nazwisko, NIP, dom_adr_wys) ON `projekt_bazy_sklep`.`klient` TO 'interfejs'@'localhost';

GRANT SELECT, INSERT (id_nadrzednej, nazwa), UPDATE (nazwa), DELETE ON `projekt_bazy_sklep`.`kategoria` TO 'interfejs'@'localhost';

GRANT SELECT, INSERT (blokada, nazwa, cena, opis, stan_magazyn, kategoria_id), UPDATE (blokada, nazwa, cena, opis, stan_magazyn, kategoria_id) ON `projekt_bazy_sklep`.`produkt` TO 'interfejs'@'localhost';

GRANT SELECT, INSERT ON `projekt_bazy_sklep`.`transakcja_produkt_v` TO 'interfejs'@'localhost';