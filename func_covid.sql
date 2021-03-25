CREATE OR REPLACE FUNCTION projekt.wpisz_na_liste_zakazonych() RETURNS TRIGGER AS'
DECLARE
	ID_sanepidu integer;
	ID_pacjenta integer;
	liczba_wystapien integer;
BEGIN
	IF(NEW.Test_Wynik = TRUE) THEN
		SELECT COUNT(*) INTO liczba_wystapien FROM projekt.zlecenie_testu, projekt.pacjent, projekt.test WHERE test.Zlecenie_testu_id = zlecenie_testu.Zlecenie_testu_id AND zlecenie_testu.osoba_pesel = pacjent.osoba_pesel AND test.zlecenie_testu_id = NEW.Zlecenie_Testu_ID;
		IF(liczba_wystapien < 1) THEN
			INSERT INTO projekt.pacjent(Osoba_Pesel, Pacjent_Stan) VALUES ((SELECT zlecenie_testu.Osoba_Pesel FROM projekt.zlecenie_testu WHERE zlecenie_testu.Zlecenie_Testu_ID = NEW.Zlecenie_Testu_ID), ''chory'');
			SELECT pacjent.Pacjent_ID INTO ID_pacjenta FROM projekt.pacjent, projekt.zlecenie_testu WHERE NEW.Zlecenie_Testu_ID = zlecenie_testu.Zlecenie_Testu_ID AND zlecenie_testu.osoba_pesel = pacjent.osoba_pesel AND pacjent.pacjent_stan = ''chory'';
		ELSE
			SELECT pacjent.Pacjent_ID INTO ID_pacjenta FROM projekt.pacjent, projekt.zlecenie_testu WHERE NEW.Zlecenie_Testu_ID = zlecenie_testu.Zlecenie_Testu_ID AND zlecenie_testu.osoba_pesel = pacjent.osoba_pesel AND pacjent.pacjent_stan = ''podejrzany'';
			UPDATE projekt.pacjent SET Pacjent_Stan = ''chory'' WHERE pacjent.Pacjent_ID = ID_pacjenta;
		END IF;
		SELECT sanepid.Sanepid_ID INTO ID_sanepidu FROM projekt.test, projekt.osoba, projekt.sanepid, projekt.zlecenie_testu WHERE zlecenie_testu.Zlecenie_Testu_ID = NEW.Zlecenie_Testu_ID AND zlecenie_testu.osoba_pesel = osoba.osoba_pesel AND osoba.wojewodztwo_id = sanepid.wojewodztwo_id;
		INSERT INTO projekt.zakazeni(Pacjent_ID, Zakazony_Data_Wpisu, Sanepid_ID, Zakazony_Miejsce_Kwarantanny) VALUES (ID_pacjenta, NEW.Test_Data, ID_sanepidu, ''D'');
	ELSE
		SELECT pacjent.Pacjent_ID INTO ID_pacjenta FROM projekt.pacjent, projekt.zlecenie_testu WHERE NEW.Zlecenie_Testu_ID = zlecenie_testu.Zlecenie_Testu_ID AND zlecenie_testu.osoba_pesel = pacjent.osoba_pesel AND pacjent.pacjent_stan = ''podejrzany'';
		DELETE FROM projekt.pacjent WHERE pacjent.Pacjent_ID = ID_pacjenta;
	END IF;
	RETURN NEW;
END;
' LANGUAGE 'plpgsql';

CREATE TRIGGER test_trigger AFTER INSERT ON projekt.Test FOR EACH ROW EXECUTE PROCEDURE projekt.wpisz_na_liste_zakazonych();



CREATE OR REPLACE FUNCTION projekt.wpisz_na_liste_ozdrowialych_lub_zmarlych() RETURNS TRIGGER AS'
BEGIN
	IF(NEW.Pacjent_Stan = ''ozdrowiały'') THEN
		INSERT INTO projekt.ozdrowiency(Pacjent_ID, Ozdrowieniec_Data_Wpisu) VALUES (NEW.Pacjent_ID, NOW());
	END IF;
	IF(NEW.Pacjent_Stan = ''nie żyje'') THEN
		INSERT INTO projekt.zmarli VALUES (NEW.Pacjent_ID, NOW());
	END IF;
	RETURN NEW;
END;
' LANGUAGE 'plpgsql';

CREATE TRIGGER pacjent_stan_trigger AFTER UPDATE ON projekt.Pacjent FOR EACH ROW EXECUTE PROCEDURE projekt.wpisz_na_liste_ozdrowialych_lub_zmarlych();


CREATE DOMAIN projekt.telefon CHAR(9) CONSTRAINT same_cyfry CHECK (VALUE ~ '[0-9]{9}') CONSTRAINT dlugosc CHECK (LENGTH(VALUE) <= 9);

ALTER TABLE projekt.osoba ALTER COLUMN Osoba_Telefon TYPE projekt.telefon;
ALTER TABLE projekt.sanepid ALTER COLUMN Sanepid_Telefon TYPE projekt.telefon;


CREATE OR REPLACE FUNCTION projekt.edytuj_pesel_kontaktowej(varchar, varchar) RETURNS text AS'
	DECLARE
	pesel ALIAS FOR $1;
	pesel_kontaktowej ALIAS FOR $2;
	flaga boolean;
	BEGIN
		SELECT EXISTS(SELECT * FROM projekt.osoba WHERE osoba_pesel = pesel) INTO flaga;
		IF((pesel_kontaktowej != pesel) AND flaga) THEN
			UPDATE projekt.osoba SET kontaktowa_osoba_pesel = pesel_kontaktowej WHERE osoba_pesel = pesel;
			RETURN ''Zmienono pesel osoby kontaktowej pomyślnie'';
		ELSE
			RETURN ''Nie znaleziono peselu lub są one identyczne'';
		END IF;
	END;
' LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION projekt.dodaj_izolacje(varchar, varchar, date) RETURNS BOOLEAN AS'
DECLARE
	pesel ALIAS FOR $1;
	ID_izolatorium ALIAS FOR $2;
	data_przyjecia ALIAS FOR $3;
	ID_pacjenta integer;
	liczba_wystapien integer;
BEGIN
	SELECT COUNT(*) INTO liczba_wystapien FROM projekt.pacjent p, projekt.osoba o WHERE o.osoba_pesel = p.osoba_pesel AND o.osoba_pesel = pesel;
	IF(liczba_wystapien = 0) THEN
		INSERT INTO projekt.pacjent(Osoba_Pesel, Pacjent_Stan) VALUES (pesel, ''kwarantanna'');
	END IF;
	SELECT DISTINCT p.pacjent_id INTO ID_pacjenta FROM projekt.pacjent p JOIN projekt.osoba o ON p.osoba_pesel = o.osoba_pesel AND p.osoba_pesel = pesel;
	IF(liczba_wystapien > 0) THEN
		UPDATE projekt.pacjent SET Pacjent_Stan = ''kwarantanna'' WHERE osoba_pesel = pesel;
	END IF;
	INSERT INTO Projekt.Izolacja(Pacjent_ID, Izolatorium_ID, Izolacja_Data_Przyjecia, Izolacja_Data_Wypisu) VALUES(ID_pacjenta, ID_izolatorium, data_przyjecia, data_przyjecia + interval ''10 days'');
	RETURN TRUE;
END;
' LANGUAGE 'plpgsql';
