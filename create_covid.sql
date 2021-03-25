
CREATE TABLE projekt.Wojewodztwo (
                Wojewodztwo_ID VARCHAR(3) NOT NULL,
                Wojewodztwo_Nazwa VARCHAR NOT NULL,
                Wojewodztwo_Miasto VARCHAR NOT NULL,
                Wojewodztwo_Liczba_Mieszkancow INTEGER NOT NULL,
                CONSTRAINT wojewodztwo_pk PRIMARY KEY (Wojewodztwo_ID)
);


CREATE TABLE projekt.Laboratorium (
                Laboratorium_ID VARCHAR NOT NULL,
                Laboratorium_Miasto VARCHAR NOT NULL,
                Laboratorium_Adres VARCHAR NOT NULL,
                Laboratorium_Max_Liczba_Testow_Na_Dzien INTEGER NOT NULL,
                CONSTRAINT laboratorium_pk PRIMARY KEY (Laboratorium_ID)
);


CREATE SEQUENCE projekt.sanepid_sanepid_id_seq_1;

CREATE TABLE projekt.Sanepid (
                Sanepid_ID INTEGER NOT NULL DEFAULT nextval('projekt.sanepid_sanepid_id_seq_1'),
                Sanepid_Adres VARCHAR NOT NULL,
                Sanepid_Telefon VARCHAR(9) NOT NULL,
                Wojewodztwo_ID VARCHAR(3) NOT NULL,
                Sanepid_Haslo VARCHAR NOT NULL,
                CONSTRAINT sanepid_pk PRIMARY KEY (Sanepid_ID)
);


ALTER SEQUENCE projekt.sanepid_sanepid_id_seq_1 OWNED BY projekt.Sanepid.Sanepid_ID;

CREATE TABLE projekt.Izolatorium (
                Izolatorium_ID VARCHAR NOT NULL,
                Izolatorium_Miasto VARCHAR NOT NULL,
                Izolatorium_Adres VARCHAR NOT NULL,
                CONSTRAINT izolatorium_pk PRIMARY KEY (Izolatorium_ID)
);


CREATE TABLE projekt.Szpital (
                Szpital_ID VARCHAR NOT NULL,
                Szpital_Nazwa VARCHAR NOT NULL,
                Szpital_Miasto VARCHAR NOT NULL,
                Szpital_Adres VARCHAR NOT NULL,
                Szpital_Pojemnosc INTEGER NOT NULL,
                CONSTRAINT szpital_pk PRIMARY KEY (Szpital_ID)
);


CREATE TABLE projekt.Osoba (
                Osoba_Pesel VARCHAR(12) NOT NULL,
                Osoba_Imie VARCHAR NOT NULL,
                Osoba_Nazwisko VARCHAR NOT NULL,
                Osoba_Miasto VARCHAR NOT NULL,
                Osoba_Adres VARCHAR NOT NULL,
                Osoba_Telefon VARCHAR(9) NOT NULL,
                Kontaktowa_Osoba_Pesel VARCHAR(12),
                Osoba_Haslo VARCHAR NOT NULL,
                Wojewodztwo_ID VARCHAR(3) NOT NULL,
                CONSTRAINT osoba_pk PRIMARY KEY (Osoba_Pesel)
);


CREATE SEQUENCE projekt.pracownik_laboratorium_pracownik_laboratorium_id_seq_1;

CREATE TABLE projekt.Pracownik_Laboratorium (
                Pracownik_Laboratorium_ID INTEGER NOT NULL DEFAULT nextval('projekt.pracownik_laboratorium_pracownik_laboratorium_id_seq_1'),
                Osoba_Pesel VARCHAR(12) NOT NULL,
                Laboratorium_ID VARCHAR NOT NULL,
                Pracownik_Laboratorium_Haslo VARCHAR NOT NULL,
                CONSTRAINT pracownik_laboratorium_pk PRIMARY KEY (Pracownik_Laboratorium_ID)
);


ALTER SEQUENCE projekt.pracownik_laboratorium_pracownik_laboratorium_id_seq_1 OWNED BY projekt.Pracownik_Laboratorium.Pracownik_Laboratorium_ID;

CREATE SEQUENCE projekt.lekarz_lekarz_id_seq;

CREATE TABLE projekt.Lekarz (
                Lekarz_ID INTEGER NOT NULL DEFAULT nextval('projekt.lekarz_lekarz_id_seq'),
                Osoba_Pesel VARCHAR(12) NOT NULL,
                Szpital_ID VARCHAR NOT NULL,
                Lekarz_Haslo VARCHAR NOT NULL,
                CONSTRAINT lekarz_pk PRIMARY KEY (Lekarz_ID)
);


ALTER SEQUENCE projekt.lekarz_lekarz_id_seq OWNED BY projekt.Lekarz.Lekarz_ID;

CREATE SEQUENCE projekt.zlecenie_testu_zlecenie_testu_id_seq_1;

CREATE TABLE projekt.Zlecenie_Testu (
                Zlecenie_Testu_ID INTEGER NOT NULL DEFAULT nextval('projekt.zlecenie_testu_zlecenie_testu_id_seq_1'),
                Osoba_Pesel VARCHAR(12) NOT NULL,
                Lekarz_ID INTEGER,
                Zlecenie_Testu_Data DATE NOT NULL,
                CONSTRAINT zlecenie_testu_pk PRIMARY KEY (Zlecenie_Testu_ID)
);


ALTER SEQUENCE projekt.zlecenie_testu_zlecenie_testu_id_seq_1 OWNED BY projekt.Zlecenie_Testu.Zlecenie_Testu_ID;

CREATE SEQUENCE projekt.test_test_id_seq;

CREATE TABLE projekt.Test (
                Test_ID INTEGER NOT NULL DEFAULT nextval('projekt.test_test_id_seq'),
                Zlecenie_Testu_ID INTEGER UNIQUE,
                Pracownik_Laboratorium_ID INTEGER NOT NULL,
                Test_Wynik BOOLEAN NOT NULL,
                Test_Data DATE NOT NULL,
                CONSTRAINT test_pk PRIMARY KEY (Test_ID)
);


ALTER SEQUENCE projekt.test_test_id_seq OWNED BY projekt.Test.Test_ID;

CREATE SEQUENCE projekt.pacjent_pacjent_id_seq;

CREATE TABLE projekt.Pacjent (
                Pacjent_ID INTEGER NOT NULL DEFAULT nextval('projekt.pacjent_pacjent_id_seq'),
                Osoba_Pesel VARCHAR(12) NOT NULL,
                Pacjent_Stan VARCHAR NOT NULL,
                Szpital_ID VARCHAR,
                CONSTRAINT pacjent_pk PRIMARY KEY (Pacjent_ID)
);


ALTER SEQUENCE projekt.pacjent_pacjent_id_seq OWNED BY projekt.Pacjent.Pacjent_ID;

CREATE TABLE projekt.Zmarli (
                Pacjent_ID INTEGER NOT NULL,
                Zgon_Data_Zgonu DATE NOT NULL,
                CONSTRAINT zmarli_pk PRIMARY KEY (Pacjent_ID)
);


CREATE SEQUENCE projekt.ozdrowiency_ozdrowieniec_id_seq;

CREATE TABLE projekt.Ozdrowiency (
                Ozdrowieniec_ID INTEGER NOT NULL DEFAULT nextval('projekt.ozdrowiency_ozdrowieniec_id_seq'),
                Pacjent_ID INTEGER NOT NULL,
                Ozdrowieniec_Data_Wpisu DATE NOT NULL,
                CONSTRAINT ozdrowiency_pk PRIMARY KEY (Ozdrowieniec_ID)
);


ALTER SEQUENCE projekt.ozdrowiency_ozdrowieniec_id_seq OWNED BY projekt.Ozdrowiency.Ozdrowieniec_ID;

CREATE SEQUENCE projekt.zakazeni_zakazony_id_seq;

CREATE TABLE projekt.Zakazeni (
                Zakazony_ID INTEGER NOT NULL DEFAULT nextval('projekt.zakazeni_zakazony_id_seq'),
                Pacjent_ID INTEGER NOT NULL,
                Zakazony_Data_Wpisu DATE NOT NULL,
                Sanepid_ID INTEGER NOT NULL,
                Zakazony_Miejsce_Kwarantanny CHAR NOT NULL,
                CONSTRAINT zakazeni_pk PRIMARY KEY (Zakazony_ID)
);


ALTER SEQUENCE projekt.zakazeni_zakazony_id_seq OWNED BY projekt.Zakazeni.Zakazony_ID;

CREATE SEQUENCE projekt.izolacja_izolacja_id_seq;

CREATE TABLE projekt.Izolacja (
                Izolacja_ID INTEGER NOT NULL DEFAULT nextval('projekt.izolacja_izolacja_id_seq'),
                Pacjent_ID INTEGER NOT NULL,
                Izolatorium_ID VARCHAR NOT NULL,
                Izolacja_Data_Przyjecia DATE NOT NULL,
                Izolacja_Data_Wypisu DATE NOT NULL,
                CONSTRAINT izolacja_pk PRIMARY KEY (Izolacja_ID)
);


ALTER SEQUENCE projekt.izolacja_izolacja_id_seq OWNED BY projekt.Izolacja.Izolacja_ID;

ALTER TABLE projekt.Osoba ADD CONSTRAINT wojewodztwo_osoba_fk
FOREIGN KEY (Wojewodztwo_ID)
REFERENCES projekt.Wojewodztwo (Wojewodztwo_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Sanepid ADD CONSTRAINT wojewodztwo_sanepid_fk
FOREIGN KEY (Wojewodztwo_ID)
REFERENCES projekt.Wojewodztwo (Wojewodztwo_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Pracownik_Laboratorium ADD CONSTRAINT laboratorium_pracownik_laboratorium_fk
FOREIGN KEY (Laboratorium_ID)
REFERENCES projekt.Laboratorium (Laboratorium_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Zakazeni ADD CONSTRAINT sanepid_zakazeni_fk
FOREIGN KEY (Sanepid_ID)
REFERENCES projekt.Sanepid (Sanepid_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Izolacja ADD CONSTRAINT izolatorium_izolacja_fk
FOREIGN KEY (Izolatorium_ID)
REFERENCES projekt.Izolatorium (Izolatorium_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Pacjent ADD CONSTRAINT szpital_pacjent_fk
FOREIGN KEY (Szpital_ID)
REFERENCES projekt.Szpital (Szpital_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Lekarz ADD CONSTRAINT szpital_lekarz_fk
FOREIGN KEY (Szpital_ID)
REFERENCES projekt.Szpital (Szpital_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Pacjent ADD CONSTRAINT osoba_info_pacjent_fk
FOREIGN KEY (Osoba_Pesel)
REFERENCES projekt.Osoba (Osoba_Pesel)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Lekarz ADD CONSTRAINT osoba_info_lekarz_pierwszego_kontaktu_fk
FOREIGN KEY (Osoba_Pesel)
REFERENCES projekt.Osoba (Osoba_Pesel)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Osoba ADD CONSTRAINT osoba_info_osoba_info_fk
FOREIGN KEY (Kontaktowa_Osoba_Pesel)
REFERENCES projekt.Osoba (Osoba_Pesel)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Pracownik_Laboratorium ADD CONSTRAINT osoba_info_pracownik_laboratorium_fk
FOREIGN KEY (Osoba_Pesel)
REFERENCES projekt.Osoba (Osoba_Pesel)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Zlecenie_Testu ADD CONSTRAINT osoba_zlecenie_testu_fk
FOREIGN KEY (Osoba_Pesel)
REFERENCES projekt.Osoba (Osoba_Pesel)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Test ADD CONSTRAINT pracownik_laboratorium_test_fk
FOREIGN KEY (Pracownik_Laboratorium_ID)
REFERENCES projekt.Pracownik_Laboratorium (Pracownik_Laboratorium_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Zlecenie_Testu ADD CONSTRAINT lekarz_zlecenie_testu_fk
FOREIGN KEY (Lekarz_ID)
REFERENCES projekt.Lekarz (Lekarz_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Test ADD CONSTRAINT zlecenie_testu_test_fk
FOREIGN KEY (Zlecenie_Testu_ID)
REFERENCES projekt.Zlecenie_Testu (Zlecenie_Testu_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Izolacja ADD CONSTRAINT pacjent_izolacja_fk
FOREIGN KEY (Pacjent_ID)
REFERENCES projekt.Pacjent (Pacjent_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Zakazeni ADD CONSTRAINT pacjent_zakazeni_fk
FOREIGN KEY (Pacjent_ID)
REFERENCES projekt.Pacjent (Pacjent_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Ozdrowiency ADD CONSTRAINT pacjent_ozdrowiency_fk
FOREIGN KEY (Pacjent_ID)
REFERENCES projekt.Pacjent (Pacjent_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Zmarli ADD CONSTRAINT pacjent_zmarli_fk
FOREIGN KEY (Pacjent_ID)
REFERENCES projekt.Pacjent (Pacjent_ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;