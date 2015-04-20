DELIMITER $

DROP PROCEDURE IF EXISTS InserisciStaff $
CREATE PROCEDURE InserisciStaff (IN Id CHAR(8), Nome VARCHAR(30), Cognome VARCHAR(30), Nazionalita CHAR(3), 
                                    AnnoNascita YEAR(4), Ruolo ENUM('DS','Allenatore'), Password VARCHAR(40) )
BEGIN
    START TRANSACTION;
    INSERT INTO PersoneFisiche(Id,Nome,Cognome,Nazionalita,AnnoNascita)
    VALUES (Id,Nome,Cognome,Nazionalita,AnnoNascita);
    INSERT INTO Staff(Id,Ruolo,Password)
    VALUES (Id,Ruolo,Password);
    COMMIT;
END $


DROP PROCEDURE IF EXISTS InserisciCiclisti $
CREATE PROCEDURE InserisciCiclisti (IN Id CHAR(8), Nome VARCHAR(30), Cognome VARCHAR(30), Nazionalita CHAR(3), 
                                    AnnoNascita YEAR(4), TurnProf YEAR(4), Arrivo YEAR(4) )
BEGIN
    START TRANSACTION;
    INSERT INTO PersoneFisiche(Id,Nome,Cognome,Nazionalita,AnnoNascita)
    VALUES (Id,Nome,Cognome,Nazionalita,AnnoNascita);
    INSERT INTO Ciclisti(Id,TurnProf,Arrivo)
    VALUES (Id,TurnProf,Arrivo);
    COMMIT;
END $


DROP PROCEDURE IF EXISTS InserisciTappa $
CREATE PROCEDURE InserisciTappa (IN Numero INT, Data DATE, Distanza FLOAT(1), NomeCorsa VARCHAR(40), Partenza CHAR(5), 
                                    Arrivo CHAR(5) )
BEGIN
    DECLARE IdCorsa INT;
    SELECT c.IdCorsa INTO IdCorsa 
      FROM Corse c 
     WHERE c.NomeCorsa=NomeCorsa;
    INSERT INTO Tappe(Numero,Data,Distanza,IdCorsa,Partenza,Arrivo)
    VALUES (Numero,Data,Distanza,IdCorsa,Partenza,Arrivo);
END $

DELIMITER ;	


CALL InserisciStaff('rbamadio','Roberto','Amadio','ITA','1963','DS',SHA1('sge4nt2y'));
CALL InserisciStaff('szanatta','Stefano','Zanatta','ITA','1964','Allenatore',SHA1('sutnb48s'));
CALL InserisciStaff('mrscirea','Mario','Scirea','ITA','1964','Allenatore',SHA1('tbsc6kpb'));

INSERT INTO Recapiti(Id,Telefono,Via,Num,Localita,Prov) VALUES
       ('rbamadio','3288547965','Rossi',5,'Milano','MI'),
       ('szanatta','3465239841','Roma',15,'Brescia','BS'),
       ('mrscirea','3384526971','Marconi',20,'Pavia','PV');
	   
CALL InserisciCiclisti('ivnbasso','Ivan','Basso','ITA','1977','1998','2008');
CALL InserisciCiclisti('ptrsagan','Peter','Sagan','SLO','1990','2010','2010');
CALL InserisciCiclisti('dmcaruso','Damiano','Caruso','ITA','1987','2009','2011');
CALL InserisciCiclisti('admarchi','Alessandro','De Marchi','ITA','1986','2011','2012');
CALL InserisciCiclisti('dformolo','Davide','Formolo','ITA','1992','2014','2014');
CALL InserisciCiclisti('oscgatto','Oscar','Gatto','ITA','1985','2007','2009');
CALL InserisciCiclisti('dvllella','Davide','Villella','ITA','1991','2014','2014');
CALL InserisciCiclisti('eviviani','Elia','Viviani','ITA','1989','2010','2011');

INSERT INTO Recapiti(Id,Telefono,Via,Num,Localita,Prov) VALUES
		('ivnbasso','3476534897','Napoli',7,'Gallarate','VA'),
		('ptrsagan','3409876543','Einaudi',11,'Brescia','BS'),
		('dmcaruso','3491125689','Garibaldi',1,'Ragusa','RG'),
		('admarchi','32845763248','Carso',50,'San Daniele Del Friuli','UD'),
		('dformolo','38365478902','Roma',23,'Negrar','VR'),
		('oscgatto','34065789454','Facciolati',12,'Padova','PD'),
		('dvllella','32670982346','Manzoni',34,'Magenta','MI'),
		('eviviani','34075428765','Palladio',47,'Isola Della Scala','VR');
		
INSERT INTO PassBio(CodPass,RBC,Hb,Hct,Id) VALUES
		(1,4.0,13,45,'ivnbasso'),
		(2,4.5,13,46,'ptrsagan'),
		(3,4.2,14,47,'dmcaruso'),
		(4,4.6,17,44,'admarchi'),
		(5,4.1,16,47,'dformolo'),
		(6,5.0,15,48,'oscgatto'),
		(7,4.8,15,45,'dvllella'),
		(8,4.1,16,44,'eviviani');

INSERT INTO Luoghi(CAP,Localita,Nazione,Regione,Prov) VALUES
		(57027,'San Vincenzo','ITA','Toscana','LI'),
		(57022,'Donoratico','ITA','Toscana','LI'),
		(17053,'Laigueglia','ITA','Liguria','SV'),
		(00118,'Roma','ITA','Lazio','RM'),
		(47043,'Gatteo','ITA','Emilia Romagna','FC'),
		(41026,'Pavullo nel Frignano','ITA','Emilia Romagna','MO'),
		(47044,'Gatteo Mare','ITA','Emilia Romagna','FC'),
		(47045,'Sant\'Angelo di Gatteo','ITA','Emilia Romagna','FC'),
		(47030,'Sogliano al Rubicone','ITA','Emilia Romagna','FC'),
		(40014,'Crevalcore','ITA','Emilia Romagna','BO'),
		(20121,'Milano','ITA','Lombardia','MI'),
		(18038,'Sanremo','ITA','Liguria','IM'),
		(20019,'Settimo Milanese','ITA','Lombardia','MI'),
		(10121,'Torino','ITA','Piemonte','TO'),
		(60200,'Compi&egravegne','FRA','Piccardia',NULL),
		(59100,'Roubaix','FRA','Nord-Passo di Calais',NULL),
		(22100,'Como','ITA','Lombardia','CO'),
		(24121,'Bergamo','ITA','Lombardia','BG'),
		(53037,'San Gimignano','ITA','Toscana','SI'),
		(53100,'Siena','ITA','Toscana','SI');

INSERT INTO Corse(IdCorsa,NomeCorsa,DataInizio,DataFine,Distanza,Terminata,Approvata,Partenza,Arrivo) VALUES
		(1,'G.P. Costa degli Etruschi','2014-02-02','2014-02-02',190.6,1,1,57027,57022),
		(2,'Trofeo Laigueglia','2014-02-21','2014-02-21',181.2,1,1,17053,17053),
		(3,'Roma Maxima','2014-03-09','2014-03-09',195.0,1,1,00118,00118),
		(4,'Milano Sanremo','2014-03-23','2014-03-23',294.0,1,1,20121,18038),
		(5,'Settimana Internazionale Coppi e Bartali','2014-03-27','2014-03-30',441.4,1,1,47043,41026),
		(6,'Parigi Roubaix','2014-04-13','2014-04-13',257.0,1,1,60200,59100),
		(7,'Milano Torino','2014-10-01','2014-10-01',193.5,1,0,20019,10121),
		(8,'Il Lombardia','2014-10-05','2014-10-05',256.0,1,1,22100,24121),
		(9,'Strade Bianche','2015-03-07','2015-03-07',189.5,0,0,53037,53100);
		
CALL InserisciTappa(1,'2014-03-27',99.5,'Settimana Internazionale Coppi e Bartali',47043,47043);
CALL InserisciTappa(2,'2014-03-27',13.3,'Settimana Internazionale Coppi e Bartali',47044,47044);
CALL InserisciTappa(3,'2014-03-28',160.2,'Settimana Internazionale Coppi e Bartali',47045,47030);
CALL InserisciTappa(4,'2014-03-29',158.4,'Settimana Internazionale Coppi e Bartali',40014,40014);
CALL InserisciTappa(5,'2014-03-30',10.0,'Settimana Internazionale Coppi e Bartali',41026,41026);

INSERT INTO CiclistiCorse(Id,IdCorsa,Piazzamento) VALUES
             	('ivnbasso',1,''),
		('dformolo',1,7),
		('dvllella',1,''),
		('eviviani',1,''),
		('ptrsagan',1,1),
		('oscgatto',1,''),
		('admarchi',2,''),
		('dformolo',2,''),
		('dvllella',2,''),
		('dmcaruso',2,''),
		('ptrsagan',2,''),
		('oscgatto',2,''),
		('ivnbasso',3,''),
		('dformolo',3,''),
		('dvllella',3,''),
		('dmcaruso',3,''),
		('ptrsagan',3,1),
		('oscgatto',3,''),
		('ivnbasso',4,''),
		('dformolo',4,''),
		('admarchi',4,''),
		('dmcaruso',4,''),
		('ptrsagan',4,''),
		('oscgatto',4,''),
		('dvllella',4,5),
		('ivnbasso',5,5),
		('dformolo',5,''),
		('admarchi',5,''),
		('dmcaruso',5,''),
		('eviviani',5,1),
		('oscgatto',5,''),
		('ptrsagan',6,''),
		('dformolo',6,''),
		('admarchi',6,''),
		('dmcaruso',6,''),
		('eviviani',6,4),
		('dvllella',6,''),
		('ptrsagan',8,''),
		('dformolo',8,''),
		('admarchi',8,''),
		('dmcaruso',8,''),
		('ivnbasso',8,''),
		('dvllella',8,1);
		
	   
