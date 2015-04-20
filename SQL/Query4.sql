SELECT p.Nome,p.Cognome
FROM PersoneFisiche p NATURAL JOIN Ciclisti c
WHERE NOT EXISTS(
		  SELECT *
		  FROM Ciclisti c1 NATURAL JOIN CiclistiCorse cc
		  WHERE p.Id=c1.Id AND cc.Piazzamento <> 0
                ); 
