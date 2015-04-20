DROP VIEW IF EXISTS Vittorie;
CREATE VIEW Vittorie(Id,Nome,Cognome,VittorieParziali,VittorieTotali) AS
SELECT p.Id,p.Nome,p.Cognome,ContaVittorieParziali(p.Id), COUNT(*) + ContaVittorieParziali(p.Id)
FROM PersoneFisiche p NATURAL JOIN CiclistiCorse cc
WHERE cc.Piazzamento = 1 
GROUP BY p.Nome,p.Cognome
UNION
SELECT p1.Id,p1.Nome,p1.Cognome,ContaVittorieParziali(p1.Id), COUNT(*)
FROM PersoneFisiche p1 JOIN Tappe t ON (p1.Id=t.VintaDa);
WHERE p1.Id NOT IN (
					 SELECT p2.Id
					 FROM PersoneFisiche p2 NATURAL JOIN CiclistiCorse cc1
					 WHERE cc1.Piazzamento = 1 
					)
GROUP BY p1.Nome,p1.Cognome;