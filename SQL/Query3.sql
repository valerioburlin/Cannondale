SELECT Id,Nome,Cognome
FROM PersoneFisiche 
WHERE Id IN (
	      	SELECT c.Id
	       	FROM Ciclisti c JOIN CiclistiCorse cc ON (c.Id=cc.Id)
 	       			JOIN Corse co ON (co.IdCorsa=cc.IdCorsa) 
 	       	WHERE EXTRACT(YEAR FROM co.DataFine)="2014" AND
	              EXTRACT(MONTH FROM co.DataFine)="02"
                GROUP BY c.Id
	       	HAVING COUNT(*) > 1
	      );
