
DROP TABLE IF EXISTS PersoneFisiche;
DROP TABLE IF EXISTS Recapiti;
DROP TABLE IF EXISTS Staff;
DROP TABLE IF EXISTS Ciclisti;
DROP TABLE IF EXISTS PassBio;
DROP TABLE IF EXISTS CiclistiCorse;
DROP TABLE IF EXISTS Corse;
DROP TABLE IF EXISTS Tappe;
DROP TABLE IF EXISTS Luoghi;
DROP TABLE IF EXISTS Errori;


CREATE TABLE PersoneFisiche (
	Id            CHAR(8) PRIMARY KEY, 
	Nome          VARCHAR(30) NOT NULL,
	Cognome	      VARCHAR(30) NOT NULL,
	Nazionalita   CHAR(3),
	AnnoNascita   YEAR(4)
) ENGINE=InnoDB;

CREATE TABLE Recapiti (
	Id	   CHAR(8), 
  	Telefono   VARCHAR(10),
	Via        VARCHAR(30),
	Num	   INT,
 	Localita   VARCHAR(30),
	Prov 	   CHAR(3),
	PRIMARY KEY (Id,Telefono,Via,Num,Localita),
	FOREIGN KEY (Id) REFERENCES PersoneFisiche(Id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Staff (
	Id 	  CHAR(8) PRIMARY KEY,
	Ruolo     ENUM('DS','Allenatore') NOT NULL,
	Password  VARCHAR(40) NOT NULL,
	FOREIGN KEY (Id) REFERENCES PersoneFisiche(Id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Ciclisti (
	Id 	  CHAR(8) PRIMARY KEY,
	TurnProf  YEAR(4),
	Arrivo    YEAR(4),
	FOREIGN KEY (Id) REFERENCES PersoneFisiche(Id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE PassBio (
	CodPass  INT AUTO_INCREMENT PRIMARY KEY,
	RBC	 FLOAT(1) NOT NULL,
	Hb       INT NOT NULL,
	Hct      INT NOT NULL,
    	Id       CHAR(8) UNIQUE,
    	FOREIGN KEY (Id) REFERENCES Ciclisti(Id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Luoghi (
	CAP       CHAR(5) PRIMARY KEY,
	Localita  VARCHAR(30), 
	Nazione   CHAR(3),
	Regione	  VARCHAR(30),	
	Prov	  CHAR(2)
) ENGINE=InnoDB;

CREATE TABLE Corse (
	IdCorsa	    INT AUTO_INCREMENT PRIMARY KEY,
	NomeCorsa   VARCHAR(40) NOT NULL,
	DataInizio  DATE,
	DataFine    DATE,
	Distanza    FLOAT(1),
	Terminata   TINYINT(1),
	Approvata   TINYINT(1),
	Partenza    CHAR(5) NOT NULL,
	Arrivo      CHAR(5) NOT NULL,
	FOREIGN KEY (Partenza) REFERENCES Luoghi(CAP) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (Arrivo) REFERENCES Luoghi(CAP) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Tappe (
	IdTappa   INT AUTO_INCREMENT PRIMARY KEY,
	Numero	  INT NOT NULL,	
	Data      DATE,   	
	Distanza  FLOAT(1),
        VintaDa   CHAR(8), 
	IdCorsa   INT NOT NULL,
	Partenza  CHAR(5),
	Arrivo    CHAR(5),
        FOREIGN KEY (VintaDa) REFERENCES Ciclisti(Id) ON DELETE SET NULL,
        FOREIGN KEY (IdCorsa) REFERENCES Corse(IdCorsa) ON DELETE CASCADE,
	FOREIGN KEY (Partenza) REFERENCES Luoghi(CAP) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (Arrivo) REFERENCES Luoghi(CAP) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE CiclistiCorse (
	Id           CHAR(8), 
	IdCorsa      INT,
	Piazzamento  INT,
	PRIMARY KEY (Id,IdCorsa),
	FOREIGN KEY (Id) REFERENCES Ciclisti(Id) ON DELETE CASCADE,
	FOREIGN KEY (IdCorsa) REFERENCES Corse(IdCorsa) ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE Errori (
	CodiceErrore  INT PRIMARY KEY,
 	Descrizione   VARCHAR(255)   
) ENGINE=InnoDB;
INSERT INTO Errori(CodiceErrore,Descrizione) VALUES
       (1,'Il piazzamento deve riguardare uno dei primi 10 posti.'),
       (2,'Corsa non ancora disputata');


DELIMITER $

DROP TRIGGER IF EXISTS SetTerminata $
CREATE TRIGGER SetTerminata
AFTER UPDATE ON CiclistiCorse
FOR EACH ROW
BEGIN
    IF NEW.Piazzamento IS NOT NULL 
      THEN UPDATE Corse SET Terminata = 1 WHERE IdCorsa = NEW.IdCorsa;
    END IF;
END $


DROP TRIGGER IF EXISTS ControlloPiazzamentiData $
CREATE TRIGGER ControlloPiazzamentiData
BEFORE UPDATE ON CiclistiCorse
FOR EACH ROW
BEGIN
    IF NEW.Piazzamento IS NOT NULL AND CURDATE() < (SELECT c.DataFine
                      				      FROM Corse c 
                     				     WHERE c.IdCorsa = NEW.IdCorsa )
      THEN INSERT INTO Errori(CodiceErrore) VALUE(2);
    END IF;
END $


DROP FUNCTION IF EXISTS HaTappe $
CREATE FUNCTION HaTappe (corsa INT) RETURNS TINYINT
BEGIN
    DECLARE conta INT DEFAULT 0;
    DECLARE flag TINYINT(1) DEFAULT 0;
    
    SELECT COUNT(*) INTO conta 
    FROM Tappe 
    WHERE IdCorsa = corsa;
    
    IF conta > 0
      THEN SET flag = 1;
    END IF;

    RETURN flag;
END $ 


DROP FUNCTION IF EXISTS ContaVittorieParziali $
CREATE FUNCTION ContaVittorieParziali (ciclista CHAR(8)) RETURNS INT
BEGIN
    DECLARE vit INT DEFAULT 0;
   
    SELECT COUNT(*) INTO vit
    FROM Tappe t JOIN Ciclisti c ON (t.VintaDa = c.Id)
    WHERE c.Id = ciclista;
   
    RETURN vit;
END $

DELIMITER ;



SOURCE Documents/Basi/Progetto/SQL/Popolamento.sql
