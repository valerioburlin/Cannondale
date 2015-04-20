SELECT p.Nome,p.Cognome,c.TurnProf AS ProfessionistaDal,co.NomeCorsa
FROM PersoneFisiche p, Ciclisti c, CiclistiCorse cc, Corse co
WHERE p.Id=c.Id AND c.Id=cc.Id AND cc.IdCorsa=co.IdCorsa AND co.DataInizio <> co.DataFine AND cc.Piazzamento=1;

