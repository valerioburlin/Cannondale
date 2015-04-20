SELECT p.Nome,p.Cognome
FROM PersoneFisiche p JOIN Ciclisti c ON (p.Id=c.Id)
		      JOIN Tappe t ON (c.Id=t.VintaDa)
WHERE p.Id NOT IN (
		   SELECT p1.Id
		   FROM PersoneFisiche p1 NATURAL JOIN Ciclisti c1
		   WHERE EXISTS(
             			SELECT *
	     			FROM Ciclisti c2 NATURAL JOIN CiclistiCorse cc
	     			WHERE p1.Id=c2.Id AND cc.Piazzamento > 1
            			)
		   ); 

